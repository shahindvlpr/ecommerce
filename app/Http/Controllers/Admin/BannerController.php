<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'position' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:100',
            'status' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/banners', $imageName);
            $validated['image'] = 'banners/' . $imageName;
        }

        // Handle Mobile Image Upload
        if ($request->hasFile('mobile_image')) {
            $mobileImageName = time() . '_mobile_' . $request->file('mobile_image')->getClientOriginalName();
            $request->file('mobile_image')->storeAs('public/banners', $mobileImageName);
            $validated['mobile_image'] = 'banners/' . $mobileImageName;
        }

        $validated['status'] = $request->has('status');

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully!');
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'position' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:100',
            'status' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && Storage::exists('public/' . $banner->image)) {
                Storage::delete('public/' . $banner->image);
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/banners', $imageName);
            $validated['image'] = 'banners/' . $imageName;
        }

        // Handle Mobile Image Upload
        if ($request->hasFile('mobile_image')) {
            if ($banner->mobile_image && Storage::exists('public/' . $banner->mobile_image)) {
                Storage::delete('public/' . $banner->mobile_image);
            }
            $mobileImageName = time() . '_mobile_' . $request->file('mobile_image')->getClientOriginalName();
            $request->file('mobile_image')->storeAs('public/banners', $mobileImageName);
            $validated['mobile_image'] = 'banners/' . $mobileImageName;
        }

        $validated['status'] = $request->has('status');

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        // Delete images
        if ($banner->image && Storage::exists('public/' . $banner->image)) {
            Storage::delete('public/' . $banner->image);
        }
        if ($banner->mobile_image && Storage::exists('public/' . $banner->mobile_image)) {
            Storage::delete('public/' . $banner->mobile_image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully!');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->update(['status' => !$banner->status]);
        $status = $banner->status ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Banner {$status} successfully!");
    }

    public function duplicate(Banner $banner)
    {
        $newBanner = $banner->replicate();
        $newBanner->title = $banner->title . ' (Copy)';
        $newBanner->save();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner duplicated successfully!');
    }
}