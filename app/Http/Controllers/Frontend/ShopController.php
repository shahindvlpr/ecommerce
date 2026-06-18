<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get all active categories and brands for sidebar
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        // Build product query
        $query = Product::where('status', 1)
            ->with(['category', 'brand']);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand != '') {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate results
        $products = $query->paginate(12);

        return view('frontend.shop.index', compact('products', 'categories', 'brands'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $products = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->with(['category', 'brand'])
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('frontend.shop.index', compact('products', 'categories', 'brands', 'category'));
    }

    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $products = Product::where('brand_id', $brand->id)
            ->where('status', 1)
            ->with(['category', 'brand'])
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('frontend.shop.index', compact('products', 'categories', 'brands', 'brand'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with(['category', 'brand'])
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('frontend.shop.index', compact('products', 'categories', 'brands'));
    }

    public function ajaxFilter(Request $request)
    {
        $query = Product::where('status', 1)->with(['category', 'brand']);

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->brand) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->get();

        return response()->json([
            'html' => view('frontend.shop.partials.product_grid', compact('products'))->render()
        ]);
    }
}