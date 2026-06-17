<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    // Cart Expiration Time (in minutes)
    const CART_EXPIRATION_MINUTES = 60; // 60 minutes = 1 hour
    // Or use: const CART_EXPIRATION_HOURS = 24; // 24 hours
    
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Remove expired items before showing cart
        $this->removeExpiredItems();

        $cart = Cart::where('user_id', Auth::id())
            ->active() // Only get active (non-expired) items
            ->with('product')
            ->get();

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        return view('frontend.cart.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Add a product to cart with expiration time.
     */
    public function add(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'nullable|integer|min:1|max:999'
            ]);

            $productId = $request->product_id;
            $quantity = $request->quantity ?? 1;

            $product = Product::where('id', $productId)
                ->where('status', true)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not available'
                ], 404);
            }

            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }

            $price = $product->sale_price ?? $product->price;
            
            // Set expiration time
            $expiresAt = now()->addMinutes(self::CART_EXPIRATION_MINUTES);
            // Or for hours: $expiresAt = now()->addHours(self::CART_EXPIRATION_HOURS);

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->active()
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
                
                if ($product->stock < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available'
                    ], 400);
                }
                
                $cartItem->quantity = $newQuantity;
                $cartItem->price = $price;
                $cartItem->expires_at = $expiresAt; // Reset expiration
                $cartItem->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully',
                    'cart_count' => $this->getCartCount()
                ]);
            }

            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'expires_at' => $expiresAt,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => $this->getCartCount()
            ]);

        } catch (\Exception $e) {
            \Log::error('Cart Add Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.'
            ], 500);
        }
    }

    /**
     * Remove expired items from cart.
     */
    public function removeExpiredItems()
    {
        if (Auth::check()) {
            $expiredItems = Cart::where('user_id', Auth::id())
                ->expired()
                ->get();

            foreach ($expiredItems as $item) {
                // Restore stock if needed
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
                $item->delete();
            }

            if ($expiredItems->count() > 0) {
                \Log::info('Removed ' . $expiredItems->count() . ' expired cart items for user ' . Auth::id());
            }
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('id', $id)
                ->active()
                ->with('product')
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }

            $quantity = $request->quantity ?? 1;
            
            if ($cartItem->product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }

            $cartItem->quantity = $quantity;
            // Reset expiration on update
            $cartItem->expires_at = now()->addMinutes(self::CART_EXPIRATION_MINUTES);
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $this->getCartCount()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('id', $id)
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ], 404);
            }

            // Restore stock
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->stock += $cartItem->quantity;
                $product->save();
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $this->getCartCount()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Clear all cart items.
     */
    public function clear()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }

            $cartItems = Cart::where('user_id', Auth::id())->get();
            
            // Restore stock for all items
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            Cart::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Get cart count (only active items).
     */
public function getCartCount()
{
    try {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        // Remove expired items first (if you have expiration)
        // $this->removeExpiredItems();

        $count = Cart::where('user_id', Auth::id())
            ->active() // যদি active scope থাকে
            ->sum('quantity');

        return response()->json(['count' => $count]);

    } catch (\Exception $e) {
        \Log::error('Cart count error: ' . $e->getMessage());
        return response()->json(['count' => 0]);
    }
}

    /**
     * Get cart total (only active items).
     */
    public function getCartTotal()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['total' => 0]);
            }

            $cart = Cart::where('user_id', Auth::id())
                ->active()
                ->get();
                
            $total = 0;
            foreach ($cart as $item) {
                $total += $item->price * $item->quantity;
            }

            return response()->json(['total' => $total]);

        } catch (\Exception $e) {
            return response()->json(['total' => 0]);
        }
    }

    /**
     * Get remaining time for cart items.
     */
    public function getCartExpiry()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['expiry' => null]);
            }

            $cart = Cart::where('user_id', Auth::id())
                ->active()
                ->first();

            if (!$cart || !$cart->expires_at) {
                return response()->json(['expiry' => null]);
            }

            $remaining = now()->diffInMinutes($cart->expires_at);

            return response()->json([
                'expiry' => $remaining,
                'expires_at' => $cart->expires_at,
                'formatted' => $cart->remaining_time
            ]);

        } catch (\Exception $e) {
            return response()->json(['expiry' => null]);
        }
    }

    /**
     * Extend cart expiration time.
     */
    public function extendExpiry()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }

            $cartItems = Cart::where('user_id', Auth::id())
                ->active()
                ->get();

            foreach ($cartItems as $item) {
                $item->expires_at = now()->addMinutes(self::CART_EXPIRATION_MINUTES);
                $item->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart expiration extended',
                'cart_count' => $this->getCartCount()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}