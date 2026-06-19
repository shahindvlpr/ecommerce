<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::withCount('values')->latest()->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes',
            'type' => 'required|in:text,select,color,size',
            'status' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);

        Attribute::create([
            'name' => $request->name,
            'slug' => $slug,
            'type' => $request->type,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully!');
    }

    public function show(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin.attributes.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
            'type' => 'required|in:text,select,color,size',
            'status' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);

        $attribute->update([
            'name' => $request->name,
            'slug' => $slug,
            'type' => $request->type,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully!');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully!');
    }

    public function toggleStatus(Attribute $attribute)
    {
        $attribute->status = !$attribute->status;
        $attribute->save();

        return redirect()->back()
            ->with('success', 'Attribute status updated successfully!');
    }
}