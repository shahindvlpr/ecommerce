<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status');
        $validated['used_count'] = 0;

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    /**
     * Display the specified coupon.
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status');

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }

    /**
     * Toggle coupon status.
     */
    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update([
            'status' => !$coupon->status
        ]);

        $status = $coupon->status ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Coupon {$status} successfully!");
    }

    /**
     * Duplicate a coupon.
     */
    public function duplicate(Coupon $coupon)
    {
        $newCoupon = $coupon->replicate();
        $newCoupon->code = $coupon->code . '-copy-' . time();
        $newCoupon->used_count = 0;
        $newCoupon->save();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon duplicated successfully!');
    }

    /**
     * Export coupons as CSV.
     */
    public function export()
    {
        $coupons = Coupon::all();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="coupons_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($coupons) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'Code', 'Name', 'Type', 'Value', 'Min Order', 'Max Discount', 'Usage Limit', 'Used Count', 'Status', 'Start Date', 'End Date']);
            
            // Data
            foreach ($coupons as $coupon) {
                fputcsv($file, [
                    $coupon->id,
                    $coupon->code,
                    $coupon->name,
                    $coupon->type,
                    $coupon->value,
                    $coupon->min_order_amount,
                    $coupon->max_discount,
                    $coupon->usage_limit,
                    $coupon->used_count,
                    $coupon->status ? 'Active' : 'Inactive',
                    $coupon->start_date,
                    $coupon->end_date,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Apply coupon to order (AJAX).
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:coupons,code',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon->is_valid) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is not valid.',
            ], 422);
        }

        if ($coupon->min_order_amount && $request->subtotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount is $' . number_format($coupon->min_order_amount, 2),
            ], 422);
        }

        $discount = $coupon->calculateDiscount($request->subtotal);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'formatted_discount' => '$' . number_format($discount, 2),
            'message' => 'Coupon applied successfully!',
            'coupon' => $coupon,
        ]);
    }
}