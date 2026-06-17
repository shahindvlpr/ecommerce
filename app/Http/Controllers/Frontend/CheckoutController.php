<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Get cart items
        $cart = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cart->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        // Get user's addresses
        $addresses = Address::where('user_id', $user->id)->get();

        return view('frontend.checkout.index', compact(
            'cart',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'addresses',
            'user'
        ));
    }

    /**
     * Process the order.
     */
    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bkash,nagad,sslcommerz',
        ]);

        // Get cart items
        $cart = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cart->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $orderNumber,
            'subtotal' => $subtotal,
            'discount' => 0,
            'tax' => $tax,
            'shipping_cost' => $shipping,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'shipping_status' => 'pending',
            'shipping_address' => $request->address . ', ' . $request->city . ', ' . ($request->state ?? '') . ', ' . $request->postal_code . ', ' . $request->country,
            'billing_address' => $request->address . ', ' . $request->city . ', ' . ($request->state ?? '') . ', ' . $request->postal_code . ', ' . $request->country,
            'phone' => $request->phone,
            'email' => $request->email,
            'notes' => $request->notes ?? null,
        ]);

        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_variation_id' => $item->product_variation_id ?? null,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->price * $item->quantity,
            ]);

            // Update product stock
            $product = $item->product;
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }
        }

        // Clear cart
        Cart::where('user_id', $user->id)->delete();

        // Redirect based on payment method
        if ($request->payment_method == 'cod') {
            // Cash on Delivery
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully!');
        } elseif ($request->payment_method == 'bkash') {
            // bKash payment integration
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully! Please complete bKash payment.');
        } elseif ($request->payment_method == 'nagad') {
            // Nagad payment integration
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully! Please complete Nagad payment.');
        } elseif ($request->payment_method == 'sslcommerz') {
            // SSLCommerz payment integration
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully! Please complete payment.');
        }

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Show order success page.
     */
    public function success($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.checkout.success', compact('order'));
    }

    /**
     * Cancel checkout.
     */
    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Checkout cancelled.');
    }

    /**
     * Apply coupon to order.
     */
    public function applyCoupon(Request $request)
    {
        // Coupon logic will be implemented here
        return response()->json(['success' => false, 'message' => 'Coupon feature coming soon!']);
    }

    /**
     * Get divisions for address.
     */
    public function getDivisions()
    {
        $divisions = [
            'Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 
            'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh'
        ];
        return response()->json($divisions);
    }

    /**
     * Get districts by division.
     */
    public function getDistricts($divisionId)
    {
        $districts = [
            'Dhaka' => ['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail', 'Kishoreganj'],
            'Chittagong' => ['Chittagong', 'Cox\'s Bazar', 'Rangamati', 'Bandarban', 'Khagrachari'],
            'Rajshahi' => ['Rajshahi', 'Bogura', 'Pabna', 'Sirajganj', 'Natore'],
            'Khulna' => ['Khulna', 'Jessore', 'Jhenaidah', 'Magura', 'Narail'],
            'Barisal' => ['Barisal', 'Patuakhali', 'Bhola', 'Jhalokati', 'Pirojpur'],
            'Sylhet' => ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj'],
            'Rangpur' => ['Rangpur', 'Dinajpur', 'Kurigram', 'Gaibandha', 'Nilphamari'],
            'Mymensingh' => ['Mymensingh', 'Jamalpur', 'Netrokona', 'Sherpur'],
        ];
        
        return response()->json($districts[$divisionId] ?? []);
    }
}