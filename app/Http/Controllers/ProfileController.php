<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Address;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display user's orders.
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }

    /**
     * Display user's addresses.
     */
    public function addresses()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->get();

        return view('profile.addresses', compact('addresses'));
    }

    /**
     * Store a new address.
     */
    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'type' => 'required|in:shipping,billing,both',
        ]);

        $user = Auth::user();

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }

        $address = Address::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email ?? $user->email,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'type' => $request->type,
            'is_default' => $request->has('is_default') ? $request->is_default : false,
        ]);

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    /**
     * Update an address.
     */
    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'type' => 'required|in:shipping,billing,both',
        ]);

        $user = Auth::user();
        
        $address = Address::where('user_id', $user->id)->findOrFail($id);

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', $user->id)->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email ?? $user->email,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'type' => $request->type,
            'is_default' => $request->has('is_default') ? $request->is_default : false,
        ]);

        return redirect()->back()->with('success', 'Address updated successfully.');
    }

    /**
     * Delete an address.
     */
    public function destroyAddress($id)
    {
        $user = Auth::user();
        
        $address = Address::where('user_id', $user->id)->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}