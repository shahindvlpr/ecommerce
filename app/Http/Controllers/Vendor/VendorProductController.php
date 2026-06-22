<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'vendor_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
            'description' => $request->description,
            'status' => true,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->update(['thumbnail' => $path]);
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::where('vendor_id', Auth::id())
            ->with('category')
            ->findOrFail($id);

        return view('vendor.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        $categories = Category::where('status', true)->get();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->update(['thumbnail' => $path]);
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        $product->update(['status' => !$product->status]);

        return back()->with('success', 'Product status updated!');
    }

    public function exportExcel()
    {
        // Export logic
        return back()->with('success', 'Products exported successfully!');
    }
}