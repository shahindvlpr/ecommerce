<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', true)
            ->when($request->get('category'), function ($query, $categorySlug) {
                return $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->when($request->get('brand'), function ($query, $brandSlug) {
                return $query->whereHas('brand', function ($q) use ($brandSlug) {
                    $q->where('slug', $brandSlug);
                });
            })
            ->when($request->get('sort'), function ($query, $sort) {
                if ($sort === 'price_asc') {
                    return $query->orderBy('price', 'asc');
                } elseif ($sort === 'price_desc') {
                    return $query->orderBy('price', 'desc');
                } elseif ($sort === 'newest') {
                    return $query->orderBy('created_at', 'desc');
                }
                return $query->orderBy('name', 'asc');
            })
            ->paginate(15);

        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();

        return view('frontend.shop.index', compact('products', 'categories', 'brands'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->where('status', true)
            ->paginate(15);

        return view('frontend.shop.category', compact('category', 'products'));
    }

    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $products = Product::where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(15);

        return view('frontend.shop.brand', compact('brand', 'products'));
    }

    public function ajaxFilter(Request $request)
    {
        // AJAX filter logic
        return response()->json(['status' => 'success']);
    }
}