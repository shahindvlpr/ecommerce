<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', Auth::id())
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
     * Add a product to cart.
     */
    public function add(Request $request)
    {
        try {
            // Check if user is logged in
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first',
                    'redirect' => route('login')
                ], 401);
            }

            // Validate request
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'nullable|integer|min:1|max:999'
            ]);

            $productId = $validated['product_id'];
            $quantity = $validated['quantity'] ?? 1;

            // Check if product exists and is active
            $product = Product::where('id', $productId)
                ->where('status', true)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not available'
                ], 404);
            }

            // Check stock
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $product->stock . ' left.'
                ], 400);
            }

            // Get price (sale price or regular price)
            $price = $product->sale_price ?? $product->price;

            // Check if product already in cart
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // Update quantity
                $newQuantity = $cartItem->quantity + $quantity;
                
                // Check stock
                if ($product->stock < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available. Only ' . $product->stock . ' left.'
                    ], 400);
                }
                
                $cartItem->quantity = $newQuantity;
                $cartItem->price = $price;
                $cartItem->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully',
                    'cart_count' => $this->getCartCount()
                ]);
            }

            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => $this->getCartCount()
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors()['product_id'] ?? ['Invalid product'])
            ], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Cart Add Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
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
                ->with('product')
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }

            $quantity = $request->quantity ?? 1;
            
            // Check stock
            if ($cartItem->product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }

            $cartItem->quantity = $quantity;
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
     * Get cart count.
     */
    public function getCartCount()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['count' => 0]);
            }

            $count = Cart::where('user_id', Auth::id())->sum('quantity');

            return response()->json(['count' => $count]);

        } catch (\Exception $e) {
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Get cart total.
     */
    public function getCartTotal()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['total' => 0]);
            }

            $cart = Cart::where('user_id', Auth::id())->get();
            $total = 0;
            foreach ($cart as $item) {
                $total += $item->price * $item->quantity;
            }

            return response()->json(['total' => $total]);

        } catch (\Exception $e) {
            return response()->json(['total' => 0]);
        }
    }
}