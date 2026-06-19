<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])
            ->latest()
            ->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function pending()
    {
        $reviews = Review::with(['product', 'user'])
            ->where('is_approved', 0)
            ->latest()
            ->paginate(15);
        
        return view('admin.reviews.pending', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->is_approved = true;
        $review->save();

        // Update product rating
        if ($review->product) {
            $review->product->updateRating();
        }

        return redirect()->back()
            ->with('success', 'Review approved successfully!');
    }

    public function reject(Review $review)
    {
        $review->is_approved = false;
        $review->save();

        return redirect()->back()
            ->with('success', 'Review rejected successfully!');
    }

    public function destroy(Review $review)
    {
        $product = $review->product;
        $review->delete();

        // Update product rating
        if ($product) {
            $product->updateRating();
        }

        return redirect()->back()
            ->with('success', 'Review deleted successfully!');
    }
}