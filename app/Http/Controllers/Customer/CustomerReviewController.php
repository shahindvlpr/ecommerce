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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id ?? null,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified' => $this->isVerifiedPurchase($request->product_id),
            'is_approved' => false, // Admin approval needed
        ]);

        // Update product rating
        $product = Product::find($request->product_id);
        $product->updateRating();

        return back()->with('success', 'Review submitted successfully! It will be visible after admin approval.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $review = Review::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        // Update product rating
        $product = Product::find($review->product_id);
        $product->updateRating();

        return back()->with('success', 'Review updated successfully.');
    }

    public function destroy($id)
    {
        $review = Review::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $productId = $review->product_id;
        $review->delete();

        // Update product rating
        $product = Product::find($productId);
        $product->updateRating();

        return back()->with('success', 'Review deleted successfully.');
    }

    private function isVerifiedPurchase($productId)
    {
        // Check if user has purchased this product
        return Order::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }
}