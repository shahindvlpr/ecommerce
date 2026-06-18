<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display a listing of the user's wishlist.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.wishlist', compact('wishlist'));
    }

    /**
     * Add a product to wishlist.
     */
    public function add($productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Please login first'], 401);
        }

        $product = Product::findOrFail($productId);
        
        // Check if already in wishlist
        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Product already in wishlist'], 200);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return response()->json(['message' => 'Product added to wishlist'], 200);
    }

    /**
     * Remove a product from wishlist.
     */
    public function remove($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist successfully.');
    }

    /**
     * Clear all wishlist.
     */
    public function clear()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        Wishlist::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Wishlist cleared successfully.');
    }

    /**
     * Toggle wishlist status (Add/Remove).
     */
    public function toggle(Request $request, $productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Please login first'], 401);
        }

        $product = Product::findOrFail($productId);
        
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'message' => 'Product removed from wishlist',
                'status' => 'removed'
            ], 200);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            return response()->json([
                'message' => 'Product added to wishlist',
                'status' => 'added'
            ], 200);
        }
    }

    /**
     * Get wishlist count.
     */
    public function getCount()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $count = Wishlist::where('user_id', $user->id)->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Check if product is in wishlist.
     */
    public function check($productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['in_wishlist' => false]);
        }

        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        return response()->json(['in_wishlist' => $exists]);
    }
}