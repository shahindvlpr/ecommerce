<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the addresses.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $addresses = Address::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.addresses', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        return view('customer.addresses-create');
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'type' => 'required|in:shipping,billing,both',
        ]);

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }

        Address::create([
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

        return redirect()->route('customer.addresses')
            ->with('success', 'Address added successfully.');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', $user->id)->findOrFail($id);

        return view('customer.addresses-edit', compact('address'));
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'type' => 'required|in:shipping,billing,both',
        ]);

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

        return redirect()->route('customer.addresses')
            ->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified address.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', $user->id)->findOrFail($id);
        $address->delete();

        return redirect()->route('customer.addresses')
            ->with('success', 'Address deleted successfully.');
    }

    /**
     * Set default address.
     */
    public function setDefault($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Remove default from all addresses
        Address::where('user_id', $user->id)->update(['is_default' => false]);
        
        // Set this address as default
        $address = Address::where('user_id', $user->id)->findOrFail($id);
        $address->is_default = true;
        $address->save();

        return redirect()->route('customer.addresses')
            ->with('success', 'Default address set successfully.');
    }
}