<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class VendorProfileController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();
        return view('vendor.profile.index', compact('vendor'));
    }

    public function update(Request $request)
    {
        $vendor = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->id,
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string',
            'shop_address' => 'nullable|string',
            'shop_phone' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_holder' => 'nullable|string|max:255',
        ]);

        $vendor->update($request->only([
            'name', 'email', 'shop_name', 'shop_description',
            'shop_address', 'shop_phone', 'bank_name',
            'bank_account_number', 'bank_account_holder'
        ]));

        // Handle Shop Logo Upload
        if ($request->hasFile('shop_logo')) {
            $path = $request->file('shop_logo')->store('vendor/logos', 'public');
            $vendor->update(['shop_logo' => $path]);
        }

        // Handle Shop Banner Upload
        if ($request->hasFile('shop_banner')) {
            $path = $request->file('shop_banner')->store('vendor/banners', 'public');
            $vendor->update(['shop_banner' => $path]);
        }

        return redirect()->route('vendor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $vendor = Auth::user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $vendor->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('vendor.profile')
            ->with('success', 'Password updated successfully!');
    }
}