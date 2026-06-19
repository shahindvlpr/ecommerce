<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = AttributeValue::with('attribute')->latest()->paginate(10);
        return view('admin.attribute-values.index', compact('values'));
    }

    public function create()
{
    $attributes = Attribute::where('is_active', true)->get();
    return view('admin.attribute-values.create', compact('attributes'));
}

public function edit(AttributeValue $attributeValue)
{
    $attributes = Attribute::where('is_active', true)->get();
    return view('admin.attribute-values.edit', compact('attributeValue', 'attributes'));
}

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255|unique:attribute_values,value,NULL,id,attribute_id,' . $request->attribute_id,
            'color_code' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'position' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->value);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('attribute-values', 'public');
        }

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'slug' => $slug,
            'color_code' => $request->color_code,
            'image' => $imagePath,
            'position' => $request->position ?? 0,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.attribute-values.index')
            ->with('success', 'Attribute value created successfully!');
    }


    public function update(Request $request, AttributeValue $attributeValue)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255|unique:attribute_values,value,' . $attributeValue->id . ',id,attribute_id,' . $request->attribute_id,
            'color_code' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'position' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->value);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($attributeValue->image) {
                \Storage::disk('public')->delete($attributeValue->image);
            }
            $imagePath = $request->file('image')->store('attribute-values', 'public');
            $attributeValue->image = $imagePath;
        }

        $attributeValue->update([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'slug' => $slug,
            'color_code' => $request->color_code,
            'position' => $request->position ?? 0,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.attribute-values.index')
            ->with('success', 'Attribute value updated successfully!');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        if ($attributeValue->image) {
            \Storage::disk('public')->delete($attributeValue->image);
        }
        $attributeValue->delete();

        return redirect()->route('admin.attribute-values.index')
            ->with('success', 'Attribute value deleted successfully!');
    }
}