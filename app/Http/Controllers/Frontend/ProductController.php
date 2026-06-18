<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product details page.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', true)
            ->with(['category', 'brand', 'productImages', 'variations', 'reviews.user'])
            ->firstOrFail();

        // Increment view count
        $product->incrementViews();

        // ============================================
        // REVIEWS
        // ============================================
        // Get approved reviews with pagination
        $reviews = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        $totalReviews = $reviews->total();

        // Rating distribution for statistics
        $ratingDistribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        
        // Get all approved reviews for distribution
        $allApprovedReviews = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->get();
        
        foreach ($allApprovedReviews as $review) {
            if (isset($ratingDistribution[$review->rating])) {
                $ratingDistribution[$review->rating]++;
            }
        }

        // Review percentages for progress bar
        $reviewPercentages = [];
        if ($totalReviews > 0) {
            for ($i = 5; $i >= 1; $i--) {
                $reviewPercentages[$i] = round(($ratingDistribution[$i] / $totalReviews) * 100);
            }
        }

        // ============================================
        // CHECK IF USER CAN REVIEW
        // ============================================
        $canReview = false;
        if (auth()->check()) {
            // Check if user purchased this product (delivered)
            $hasPurchased = OrderItem::whereHas('order', function($query) {
                $query->where('user_id', auth()->id())
                    ->where('status', 'delivered');
            })->where('product_id', $product->id)->exists();

            // Check if user already reviewed this product
            $hasReviewed = Review::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();

            $canReview = $hasPurchased && !$hasReviewed;
        }

        // ============================================
        // RELATED PRODUCTS
        // ============================================
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->inStock()
            ->limit(4)
            ->get();

        // ============================================
        // WISHLIST CHECK
        // ============================================
        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('frontend.product.show', compact(
            'product',
            'reviews',
            'totalReviews',
            'ratingDistribution',
            'reviewPercentages',
            'canReview',
            'relatedProducts',
            'inWishlist'
        ));
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->with(['category', 'brand'])
            ->paginate(15);

        return view('frontend.shop.index', compact('products'));
    }

    /**
     * AJAX search for live search.
     */
    public function ajaxSearch(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', true)
            ->where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'slug', 'price', 'thumbnail']);

        return response()->json($products);
    }

    /**
     * Get product reviews via AJAX.
     */
    public function getReviews(Request $request, $productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        // Check if user can review
        $canReview = false;
        if (auth()->check()) {
            $hasPurchased = OrderItem::whereHas('order', function($query) {
                $query->where('user_id', auth()->id())
                    ->where('status', 'delivered');
            })->where('product_id', $productId)->exists();

            $hasReviewed = Review::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->exists();

            $canReview = $hasPurchased && !$hasReviewed;
        }

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'can_review' => $canReview,
            'html' => view('frontend.product.partials.reviews', compact('reviews'))->render()
        ]);
    }

    /**
     * Get product rating statistics via AJAX.
     */
    public function getRatingStats($productId)
    {
        $product = Product::findOrFail($productId);
        
        $totalReviews = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->count();

        $ratingDistribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        
        $allReviews = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->get();
        
        foreach ($allReviews as $review) {
            if (isset($ratingDistribution[$review->rating])) {
                $ratingDistribution[$review->rating]++;
            }
        }

        $reviewPercentages = [];
        if ($totalReviews > 0) {
            for ($i = 5; $i >= 1; $i--) {
                $reviewPercentages[$i] = round(($ratingDistribution[$i] / $totalReviews) * 100);
            }
        }

        return response()->json([
            'success' => true,
            'average_rating' => $product->rating ?? 0,
            'total_reviews' => $totalReviews,
            'distribution' => $ratingDistribution,
            'percentages' => $reviewPercentages
        ]);
    }

    /**
     * Get recently viewed products.
     */
    public function recentlyViewed()
    {
        $recentlyViewed = session()->get('recently_viewed', []);
        
        if (empty($recentlyViewed)) {
            return response()->json([]);
        }

        $products = Product::whereIn('id', $recentlyViewed)
            ->where('status', true)
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Track recently viewed products.
     */
    public function trackView(Request $request)
    {
        $productId = $request->product_id;
        
        if (!$productId) {
            return response()->json(['success' => false]);
        }

        $recentlyViewed = session()->get('recently_viewed', []);
        
        // Remove if already exists
        $recentlyViewed = array_filter($recentlyViewed, function($id) use ($productId) {
            return $id != $productId;
        });
        
        // Add to beginning
        array_unshift($recentlyViewed, $productId);
        
        // Keep only last 20
        $recentlyViewed = array_slice($recentlyViewed, 0, 20);
        
        session()->put('recently_viewed', $recentlyViewed);
        
        return response()->json(['success' => true]);
    }
}