<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(10);
            
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();
        
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:products',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'nullable|exists:brands,id',
        'price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'sku' => 'nullable|string|max:100|unique:products',
        'short_description' => 'nullable|string|max:500',
        'description' => 'nullable|string',
        'thumbnail' => 'nullable|image|max:2048',
        'status' => 'nullable|boolean',
        'featured' => 'nullable|boolean',
        'trending' => 'nullable|boolean',
    ]);

    $slug = $request->slug ?? Str::slug($request->name);

    // Handle thumbnail upload
    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
    }

    Product::create([
        'name' => $request->name,
        'slug' => $slug,
        'category_id' => $request->category_id,
        'brand_id' => $request->brand_id,
        'price' => $request->price,
        'sale_price' => $request->sale_price,
        'stock' => $request->stock,
        'sku' => $request->sku,
        'short_description' => $request->short_description,
        'description' => $request->description,
        'thumbnail' => $thumbnailPath,
        'status' => $request->has('status'),
        'featured' => $request->has('featured'),
        'trending' => $request->has('trending'),
    ]);

    return redirect()->route('admin.products.index')
        ->with('success', 'Product created successfully!');
}

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'trending' => 'nullable|boolean',
        ]);

        $slug = $request->slug ?? Str::slug($request->name);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
            $product->thumbnail = $thumbnailPath;
        }

        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->has('status'),
            'featured' => $request->has('featured'),
            'trending' => $request->has('trending'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Delete thumbnail
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $product->status = !$product->status;
        $product->save();

        return redirect()->back()
            ->with('success', 'Product status updated successfully!');
    }

    /**
     * Toggle product featured.
     */
    public function toggleFeatured(Product $product)
    {
        $product->featured = !$product->featured;
        $product->save();

        return redirect()->back()
            ->with('success', 'Product featured status updated successfully!');
    }

    /**
     * Export products to Excel.
     */
    public function exportExcel()
    {
        // Implement Excel export
        return redirect()->back()->with('info', 'Export feature coming soon!');
    }

    /**
     * Import products from Excel.
     */
    public function import(Request $request)
    {
        // Implement Excel import
        return redirect()->back()->with('info', 'Import feature coming soon!');
    }
}