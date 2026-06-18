<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        // Get cart items for logged in user
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
        }
        
        // Calculate shipping, tax and total
        $shipping = ($subtotal >= 100) ? 0 : 10;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;
        
        // Return view with data
        return view('frontend.cart.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = \App\Models\Product::findOrFail($request->product_id);
        
        // Check if product already in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => Cart::where('user_id', Auth::id())->count()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!'
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        $cartItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!'
        ]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully!'
        ]);
    }

    /**
     * Get cart count (for AJAX)
     */
    public function getCartCount()
    {
        $count = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Get cart total (for AJAX)
     */
    public function getCartTotal()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $total += $price * $item->quantity;
        }
        
        return response()->json(['total' => $total]);
    }

    /**
     * Get cart expiry (for timer)
     */
    public function getCartExpiry()
    {
        // Return expiry time in seconds (e.g., 60 minutes)
        return response()->json(['expiry' => 3600]);
    }

    /**
     * Extend cart expiry
     */
    public function extendExpiry()
    {
        return response()->json(['success' => true]);
    }
}