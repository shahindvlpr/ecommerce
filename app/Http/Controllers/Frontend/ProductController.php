<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', true)
            ->with(['category', 'brand', 'images', 'variations'])
            ->firstOrFail();

        // Increment view count
        $product->incrementViews();

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->inStock()
            ->limit(4)
            ->get();

        // Get product rating distribution
        $ratingDistribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        
        if ($product->reviews) {
            foreach ($product->reviews as $review) {
                if (isset($ratingDistribution[$review->rating])) {
                    $ratingDistribution[$review->rating]++;
                }
            }
        }

        $totalReviews = $product->reviews_count ?? 0;
        $reviewPercentages = [];
        if ($totalReviews > 0) {
            for ($i = 5; $i >= 1; $i--) {
                $reviewPercentages[$i] = round(($ratingDistribution[$i] / $totalReviews) * 100);
            }
        }

        // Check if product is in wishlist
        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('frontend.product.show', compact(
            'product',
            'relatedProducts',
            'ratingDistribution',
            'reviewPercentages',
            'totalReviews',
            'inWishlist'
        ));
    }

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
}