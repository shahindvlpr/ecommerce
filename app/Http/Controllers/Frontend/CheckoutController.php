<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\VendorEarning;
use App\Models\Product;
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

        // Check stock availability
        foreach ($cart as $item) {
            if ($item->product && $item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', 'Sorry, ' . $item->product->name . ' is out of stock!');
            }
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
            // ============================================================
            // 1. CREATE ORDER
            // ============================================================
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_status' => 'pending',
                'shipping_address' => $fullAddress,
                'billing_address' => $fullAddress,
                'notes' => $request->notes ?? null,
            ]);

            // ============================================================
            // 2. CREATE ORDER ITEMS WITH VENDOR ID
            // ============================================================
            $vendorIds = [];
            
            foreach ($cart as $item) {
                $price = $item->product->sale_price ?? $item->product->price;
                $product = $item->product;
                
                // Get vendor_id from product
                $vendorId = $product->vendor_id ?? null;
                
                if ($vendorId) {
                    $vendorIds[] = $vendorId;
                }

                // Create Order Item with vendor_id
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variation_id' => $item->product_variation_id ?? null,
                    'vendor_id' => $vendorId,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'total' => $price * $item->quantity,
                ]);

                // ============================================================
                // 3. CREATE VENDOR EARNINGS
                // ============================================================
                if ($vendorId) {
                    $commissionRate = 10; // 10% commission
                    $commissionAmount = ($price * $item->quantity) * ($commissionRate / 100);
                    $netAmount = ($price * $item->quantity) - $commissionAmount;

                    VendorEarning::create([
                        'vendor_id' => $vendorId,
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'amount' => $price * $item->quantity,
                        'commission' => $commissionAmount,
                        'net_amount' => $netAmount,
                        'type' => 'sale',
                        'status' => 'pending',
                        'description' => "Sale of {$product->name} (Order #{$orderNumber})",
                    ]);
                }

                // Update product stock
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            // ============================================================
            // 4. UPDATE ORDER VENDOR_ID (if single vendor)
            // ============================================================
            $uniqueVendors = array_unique($vendorIds);
            
            if (count($uniqueVendors) == 1) {
                $order->vendor_id = $uniqueVendors[0];
                $order->save();
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            // ============================================================
            // 5. PAYMENT METHOD BASED REDIRECT
            // ============================================================
            if ($request->payment_method == 'cod') {
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully! You will pay on delivery.');
                    
            } elseif ($request->payment_method == 'bkash') {
                // bKash Payment Gateway
                try {
                    if (class_exists(\App\Services\BkashService::class)) {
                        $bkash = new \App\Services\BkashService();
                        $payment = $bkash->createPayment($order, $order->total);
                        
                        if ($payment && isset($payment['paymentID'])) {
                            session([
                                'bkash_payment_id' => $payment['paymentID'],
                                'bkash_order_id' => $order->id,
                            ]);
                            
                            return redirect($payment['bkashURL']);
                        }
                    }
                    
                    return redirect()->route('checkout.cancel')
                        ->with('error', 'bKash payment initialization failed! Please try again.');
                    
                } catch (\Exception $e) {
                    return redirect()->route('checkout.cancel')
                        ->with('error', 'bKash payment failed: ' . $e->getMessage());
                }
                
            } elseif ($request->payment_method == 'nagad') {
                // Nagad Payment Gateway
                try {
                    if (class_exists(\App\Services\NagadService::class)) {
                        $nagad = new \App\Services\NagadService();
                        $payment = $nagad->createPayment($order, $order->total);
                        
                        if ($payment && isset($payment['paymentReferenceId'])) {
                            session([
                                'nagad_payment_ref' => $payment['paymentReferenceId'],
                                'nagad_order_id' => $order->id,
                            ]);
                            
                            return redirect($payment['paymentUrl']);
                        }
                    }
                    
                    return redirect()->route('checkout.cancel')
                        ->with('error', 'Nagad payment initialization failed! Please try again.');
                    
                } catch (\Exception $e) {
                    return redirect()->route('checkout.cancel')
                        ->with('error', 'Nagad payment failed: ' . $e->getMessage());
                }
                
            } elseif ($request->payment_method == 'sslcommerz') {
                return redirect()->route('sslcommerz.pay', ['order' => $order->id]);
            }

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            \Log::error('Checkout Error: ' . $e->getMessage());
            \Log::error('Checkout Trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Something went wrong! Please try again.')
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
            'Chittagong' => ['Chittagong', "Cox's Bazar", 'Rangamati', 'Bandarban', 'Khagrachari', 'Comilla', 'Feni', 'Noakhali', 'Lakshmipur', 'Chandpur', 'Brahmanbaria'],
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
        return response()->json([]);
    }
}