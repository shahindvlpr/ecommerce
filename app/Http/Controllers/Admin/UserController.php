<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of customers only.
     */
    public function customers()
    {
        $users = User::where('role', 'customer')
            ->latest()
            ->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of vendors only.
     */
    public function vendors()
{
    $vendors = User::where('role', 'vendor')->latest()->paginate(10);
    return view('admin.vendors.index', compact('vendors'));
}

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,vendor,admin',
            'status' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

/**
 * Display the specified user.
 */
public function show(User $user)
{
    // If vendor, show vendor details
    if ($user->role === 'vendor') {
        return view('admin.vendors.show', compact('user'));
    }
    
    // For customers or other roles
    return view('admin.users.show', compact('user'));
}
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,vendor,admin',
            'status' => 'nullable|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Prepare data for update
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->has('status'),
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin user!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();

        return redirect()->back()
            ->with('success', 'User status updated successfully!');
    }

    /**
     * Change user role.
     */
    public function changeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:customer,vendor,admin',
        ]);

        if ($user->role === 'admin' && $request->role !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->back()->with('error', 'At least one admin is required!');
            }
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    /**
     * Export users to Excel.
     */
    public function exportExcel()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No users found to export!');
        }

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Role' => $user->role ?? 'customer',
                'Status' => $user->status ? 'Active' : 'Inactive',
                'Joined' => $user->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $fileName = 'users-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display customer orders.
     */
    public function customerOrders(User $user)
    {
        $orders = $user->orders()->latest()->paginate(10);
        return view('admin.users.orders', compact('user', 'orders'));
    }

    /**
     * Display vendor products.
     */
    public function vendorProducts(User $user)
    {
        $products = $user->products()->latest()->paginate(10);
        return view('admin.vendors.products', compact('user', 'products'));
    }

    /**
     * Approve vendor.
     */
    public function approveVendor(User $user)
    {
        if ($user->role !== 'vendor') {
            return redirect()->back()->with('error', 'User is not a vendor!');
        }

        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'Vendor approved successfully!');
    }

    
}