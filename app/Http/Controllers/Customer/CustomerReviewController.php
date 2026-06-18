<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CustomerReviewController extends Controller
{
    /**
     * Display all reviews by the user.
     */
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('customer.reviews.index', compact('reviews'));
    }

    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string|max:1000',
                'images' => 'nullable|array|max:5',
                'images.*' => 'image|max:2048',
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
            $hasPurchased = OrderItem::whereHas('order', function($q) {
                $q->where('user_id', Auth::id())->where('status', 'delivered');
            })->where('product_id', $request->product_id)->exists();

            // Handle images
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('reviews', 'public');
                    $images[] = $path;
                }
            }

            $review = Review::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'images' => $images,
                'is_approved' => $hasPurchased ? true : false,
                'is_verified' => $hasPurchased,
            ]);

            // Update product rating
            $product = Product::find($request->product_id);
            $product->updateRating();

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!',
                'review' => $review,
                'html' => view('customer.reviews.partials.review-item', compact('review'))->render()
            ]);

        } catch (\Exception $e) {
            Log::error('Review store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit review. Please try again.'
            ], 500);
        }
    }

    /**
     * Update a review.
     */
    public function update(Request $request, $id)
    {
        try {
            $review = Review::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string|max:1000',
                'images' => 'nullable|array|max:5',
                'images.*' => 'image|max:2048',
            ]);

            // Handle images
            $images = $review->images ?? [];
            if ($request->hasFile('images')) {
                // Delete old images
                if (!empty($review->images)) {
                    foreach ($review->images as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('reviews', 'public');
                    $images[] = $path;
                }
            }

            $review->update([
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'images' => $images,
                'is_approved' => false, // Need re-approval
            ]);

            // Update product rating
            $product = Product::find($review->product_id);
            $product->updateRating();

            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully!',
                'review' => $review
            ]);

        } catch (\Exception $e) {
            Log::error('Review update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update review.'
            ], 500);
        }
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        try {
            $review = Review::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $productId = $review->product_id;

            // Delete images
            if (!empty($review->images)) {
                foreach ($review->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

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

        } catch (\Exception $e) {
            Log::error('Review delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review.'
            ], 500);
        }
    }

    /**
     * Get product reviews (for AJAX).
     */
    public function getProductReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        // Check if user can review
        $canReview = false;
        if (Auth::check()) {
            $hasPurchased = OrderItem::whereHas('order', function($q) {
                $q->where('user_id', Auth::id())->where('status', 'delivered');
            })->where('product_id', $productId)->exists();

            $hasReviewed = Review::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();

            $canReview = $hasPurchased && !$hasReviewed;
        }

        // Rating statistics
        $stats = [
            'total' => $reviews->total(),
            'average' => Review::where('product_id', $productId)->where('is_approved', true)->avg('rating') ?? 0,
            'distribution' => []
        ];

        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('product_id', $productId)
                ->where('is_approved', true)
                ->where('rating', $i)
                ->count();
            $stats['distribution'][$i] = [
                'count' => $count,
                'percentage' => $stats['total'] > 0 ? round(($count / $stats['total']) * 100) : 0
            ];
        }

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'stats' => $stats,
            'can_review' => $canReview,
            'html' => view('customer.reviews.partials.review-list', compact('reviews'))->render()
        ]);
    }

    /**
     * Mark a review as helpful.
     */
    public function helpful($id)
    {
        try {
            $review = Review::findOrFail($id);
            $review->helpful();

            return response()->json([
                'success' => true,
                'message' => 'Marked as helpful!',
                'count' => $review->helpful_count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as helpful.'
            ], 500);
        }
    }

    /**
     * Report a review.
     */
    public function report($id)
    {
        try {
            $review = Review::findOrFail($id);
            $review->report();

            return response()->json([
                'success' => true,
                'message' => 'Review reported!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to report review.'
            ], 500);
        }
    }
}