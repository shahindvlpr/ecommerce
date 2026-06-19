<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|max:255|unique:categories',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $slug = $request->slug ?? Str::slug($request->name);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'icon' => $request->icon,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        'icon' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:500',
        'image' => 'nullable|image|max:2048',
        'status' => 'nullable|boolean',
    ]);

    $slug = $request->slug ?? Str::slug($request->name);

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }
        $imagePath = $request->file('image')->store('categories', 'public');
        $category->image = $imagePath;
    }

    $category->update([
        'name' => $request->name,
        'slug' => $slug,
        'icon' => $request->icon,
        'description' => $request->description,
        'status' => $request->has('status'),
    ]);

    return redirect()->route('admin.categories.index')
        ->with('success', 'Category updated successfully!');
}

    public function destroy(Category $category)
    {
        // Delete image
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->status = !$category->status;
        $category->save();

        return redirect()->back()
            ->with('success', 'Category status updated successfully!');
    }
}