<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;

class CustomerReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $reviews = Review::where('user_id', $user->id)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id ?? null,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified' => $this->isVerifiedPurchase($user->id, $request->product_id),
            'is_approved' => false, // Admin approval needed
        ]);

        // Update product rating
        $product = Product::find($request->product_id);
        if ($product) {
            $this->updateProductRating($product);
        }

        return redirect()->back()->with('success', 'Review submitted successfully! It will be visible after admin approval.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $review = Review::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        // Update product rating
        $product = Product::find($review->product_id);
        if ($product) {
            $this->updateProductRating($product);
        }

        return redirect()->back()->with('success', 'Review updated successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $review = Review::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $productId = $review->product_id;
        $review->delete();

        // Update product rating
        $product = Product::find($productId);
        if ($product) {
            $this->updateProductRating($product);
        }

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    private function isVerifiedPurchase($userId, $productId)
    {
        // Check if user has purchased this product
        return Order::where('user_id', $userId)
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }

    private function updateProductRating($product)
    {
        $avgRating = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->avg('rating');
        
        $product->rating = $avgRating ?? 0;
        $product->reviews_count = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->count();
        $product->save();
    }
}