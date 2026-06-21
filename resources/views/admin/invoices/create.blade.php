@extends('layouts.admin')

@section('title', 'Create Invoice - EktaMart Admin')
@section('page-title', 'Create Invoice')
@section('icon', 'file-invoice')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Back to Invoices
            </a>
        </div>
    </div>

    <div class="card premium-card">
        <div class="card-body">
            <form action="{{ route('admin.invoices.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Order <span class="text-danger">*</span></label>
                        <select name="order_id" class="form-select" required>
                            <option value="">Select Order</option>
                            @foreach(\App\Models\Order::with('user')->get() as $order)
                                <option value="{{ $order->id }}" {{ isset($order) && $order->id == $order->id ? 'selected' : '' }}>
                                    #{{ $order->id }} - {{ $order->user->name ?? 'Guest' }} - ${{ number_format($order->total, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Subtotal <span class="text-danger">*</span></label>
                        <input type="number" name="subtotal" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tax</label>
                        <input type="number" name="tax" class="form-control" step="0.01" value="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Shipping</label>
                        <input type="number" name="shipping" class="form-control" step="0.01" value="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Discount</label>
                        <input type="number" name="discount" class="form-control" step="0.01" value="0">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total <span class="text-danger">*</span></label>
                        <input type="number" name="total" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partial</option>
                            <option value="refunded">Refunded</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Due Date</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Create Invoice
                        </button>
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection