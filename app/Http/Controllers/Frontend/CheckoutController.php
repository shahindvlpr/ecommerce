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
            $price = $item->product->sale_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
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
            'notes' => 'nullable|string',
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
            $price = $item->product->sale_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
        }

        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

        // Build full address
        $fullAddress = $request->address . ', ' . $request->city;
        if ($request->state) {
            $fullAddress .= ', ' . $request->state;
        }
        if ($request->postal_code) {
            $fullAddress .= ', ' . $request->postal_code;
        }
        $fullAddress .= ', ' . $request->country;

        try {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                
                // Customer info
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'payment_method' => $request->payment_method,
                
                // Financials
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
                
                // Statuses
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_PENDING,
                'shipping_status' => Order::SHIPPING_PENDING,
                
                // Addresses
                'shipping_address' => $fullAddress,
                'billing_address' => $fullAddress,
                
                // Additional
                'notes' => $request->notes ?? null,
            ]);

            // Create order items
            foreach ($cart as $item) {
                $price = $item->product->sale_price ?? $item->product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variation_id' => $item->product_variation_id ?? null,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'total' => $price * $item->quantity,
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
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully! You will pay on delivery.');
            } elseif ($request->payment_method == 'bkash') {
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully! Please complete bKash payment.');
            } elseif ($request->payment_method == 'nagad') {
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully! Please complete Nagad payment.');
            } elseif ($request->payment_method == 'sslcommerz') {
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully! Please complete SSLCommerz payment.');
            }

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong! Please try again. ' . $e->getMessage())
                ->withInput();
        }
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
        return response()->json([
            'success' => false, 
            'message' => 'Coupon feature coming soon!'
        ]);
    }

    /**
     * Get divisions for address.
     */
    public function getDivisions()
    {
        $divisions = [
            'Dhaka', 
            'Chittagong', 
            'Rajshahi', 
            'Khulna', 
            'Barisal', 
            'Sylhet', 
            'Rangpur', 
            'Mymensingh'
        ];
        return response()->json($divisions);
    }

    /**
     * Get districts by division.
     */
    public function getDistricts($divisionId)
    {
        $districts = [
            'Dhaka' => ['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail', 'Kishoreganj', 'Manikganj', 'Munshiganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Faridpur', 'Madaripur', 'Gopalganj'],
            'Chittagong' => ['Chittagong', 'Cox\'s Bazar', 'Rangamati', 'Bandarban', 'Khagrachari', 'Comilla', 'Feni', 'Noakhali', 'Lakshmipur', 'Chandpur', 'Brahmanbaria'],
            'Rajshahi' => ['Rajshahi', 'Bogura', 'Pabna', 'Sirajganj', 'Natore', 'Chapainawabganj', 'Naogaon', 'Joypurhat'],
            'Khulna' => ['Khulna', 'Jessore', 'Jhenaidah', 'Magura', 'Narail', 'Bagerhat', 'Satkhira', 'Kushtia', 'Chuadanga', 'Meherpur'],
            'Barisal' => ['Barisal', 'Patuakhali', 'Bhola', 'Jhalokati', 'Pirojpur', 'Barguna'],
            'Sylhet' => ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj'],
            'Rangpur' => ['Rangpur', 'Dinajpur', 'Kurigram', 'Gaibandha', 'Nilphamari', 'Lalmonirhat', 'Thakurgaon', 'Panchagarh'],
            'Mymensingh' => ['Mymensingh', 'Jamalpur', 'Netrokona', 'Sherpur'],
        ];
        
        return response()->json($districts[$divisionId] ?? []);
    }

    /**
     * Get upazilas by district.
     */
    public function getUpazilas($districtId)
    {
        // This can be expanded with actual data
        return response()->json([]);
    }
}