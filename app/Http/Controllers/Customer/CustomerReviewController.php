<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);
            
        return view('customer.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'title' => 'nullable|string|max:255',
        ]);

        // Check if user already reviewed this product
        $existing = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already reviewed this product!'
            ], 400);
        }

        // Check if user purchased this product
        $hasPurchased = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->where('user_id', Auth::id())->where('status', 'delivered');
        })->where('product_id', $request->product_id)->exists();

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_approved' => $hasPurchased ? true : false, // Auto-approve if purchased
            'is_verified' => $hasPurchased,
        ]);

        // Update product rating
        $product = Product::find($request->product_id);
        $product->updateRating();

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $review
        ]);
    }

    public function update(Request $request, $id)
    {
        $review = Review::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'title' => 'nullable|string|max:255',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_approved' => false, // Need re-approval
        ]);

        // Update product rating
        $product = Product::find($review->product_id);
        $product->updateRating();

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $review = Review::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $productId = $review->product_id;
        $review->delete();

        // Update product rating
        $product = Product::find($productId);
        if ($product) {
            $product->updateRating();
        }

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully!'
        ]);
    }

    public function getProductReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }
}