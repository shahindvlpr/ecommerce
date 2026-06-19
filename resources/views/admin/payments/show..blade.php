@extends('layouts.admin')

@section('title', 'Payment Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-credit-card text-primary me-2"></i>Payment Details
                <code>#{{ $payment->id }}</code>
            </h4>
            <p class="text-muted small">View payment information</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">Payment Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Transaction ID</label>
                            <p class="fw-semibold">{{ $payment->transaction_id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Amount</label>
                            <p class="fw-bold text-success">${{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Payment Method</label>
                            <p>{{ ucfirst($payment->payment_method) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Status</label>
                            <p>
                                <span class="badge bg-{{ $payment->status_badge }}">
                                    {{ $payment->status_label }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Payment Date</label>
                            <p>{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Order ID</label>
                            <p>#{{ $payment->order->order_number ?? $payment->order_id }}</p>
                        </div>
                    </div>

                    <hr>

                    <form action="{{ route('admin.payments.update-status', $payment) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        @method('POST')
                        <select name="status" class="form-control form-control-sm">
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">Order Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="text-muted small">Order #</label>
                        <p class="fw-semibold">#{{ $payment->order->order_number ?? $payment->order_id }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Customer</label>
                        <p>{{ $payment->order->user->name ?? 'Guest' }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Order Total</label>
                        <p class="fw-bold">${{ number_format($payment->order->total ?? 0, 2) }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Order Status</label>
                        <p>
                            <span class="badge bg-{{ $payment->order->status == 'delivered' ? 'success' : ($payment->order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($payment->order->status ?? 'pending') }}
                            </span>
                        </p>
                    </div>
                    <a href="{{ route('admin.orders.show', $payment->order) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> View Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection