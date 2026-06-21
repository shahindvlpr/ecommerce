<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use App\Models\Order;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = ProductReturn::with(['user', 'order'])
            ->latest()
            ->paginate(15);
            
        return view('admin.returns.index', compact('returns'));
    }

    public function pending()
    {
        $returns = ProductReturn::with(['user', 'order'])
            ->pending()
            ->latest()
            ->paginate(15);
            
        return view('admin.returns.index', compact('returns'));
    }

    public function approved()
    {
        $returns = ProductReturn::with(['user', 'order'])
            ->approved()
            ->latest()
            ->paginate(15);
            
        return view('admin.returns.index', compact('returns'));
    }

    public function completed()
    {
        $returns = ProductReturn::with(['user', 'order'])
            ->completed()
            ->latest()
            ->paginate(15);
            
        return view('admin.returns.index', compact('returns'));
    }

    public function show($id)
    {
        $return = ProductReturn::with(['user', 'order', 'order.items'])
            ->findOrFail($id);
            
        return view('admin.returns.show', compact('return'));
    }

    public function updateStatus(Request $request, $id)
    {
        $return = ProductReturn::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed,cancelled',
            'refund_amount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $return->status = $request->status;
        
        if ($request->status == 'approved') {
            $return->approved_at = now();
            $return->refund_amount = $request->refund_amount ?? $return->refund_amount;
        }
        
        if ($request->status == 'completed') {
            $return->completed_at = now();
        }
        
        $return->admin_notes = $request->admin_notes ?? $return->admin_notes;
        $return->save();

        return redirect()->back()->with('success', 'Return status updated successfully!');
    }

    public function destroy($id)
    {
        $return = ProductReturn::findOrFail($id);
        $return->delete();
        
        return redirect()->route('admin.returns.index')
            ->with('success', 'Return deleted successfully!');
    }
}