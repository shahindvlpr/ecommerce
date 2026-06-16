<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)
            ->where('status', true)
            ->with(['category', 'brand'])
            ->limit(8)
            ->get();

        $latestProducts = Product::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $categories = Category::where('status', true)
            ->withCount('products')
            ->orderBy('order')
            ->limit(6)
            ->get();

        $banners = Banner::where('status', true)
            ->orderBy('order')
            ->get();

        $brands = Brand::where('status', true)
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->orderBy('products_count', 'desc')
            ->limit(8)
            ->get();

        return view('frontend.home', compact(
            'featuredProducts',
            'latestProducts',
            'categories',
            'banners',
            'brands'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('status', true)
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(15);

        return view('frontend.search', compact('products', 'query'));
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function faq()
    {
        return view('frontend.pages.faq');
    }

    public function sitemap()
    {
        // Generate sitemap XML
        return response()->view('sitemap', [], 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        return response("User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml'), 200)
            ->header('Content-Type', 'text/plain');
    }
}