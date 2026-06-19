@extends('layouts.admin')

@section('title', 'Payments - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-credit-card text-primary me-2"></i>Payments
            </h4>
            <p class="text-muted small">Manage all payments</p>
        </div>
        <a href="{{ route('admin.payments.export.excel') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-4 col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total</h6>
                    <h5 class="fw-bold">{{ $stats['total'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Pending</h6>
                    <h5 class="fw-bold text-warning">{{ $stats['pending'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Paid</h6>
                    <h5 class="fw-bold text-success">{{ $stats['paid'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Failed</h6>
                    <h5 class="fw-bold text-danger">{{ $stats['failed'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Refunded</h6>
                    <h5 class="fw-bold text-info">{{ $stats['refunded'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total Amount</h6>
                    <h5 class="fw-bold">${{ number_format($payments->sum('amount'), 0) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 gap-2 flex-wrap">
        <li class="nav-item">
            <a href="{{ route('admin.payments.index') }}" class="nav-link active">All</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.payments.pending') }}" class="nav-link">Pending</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.payments.paid') }}" class="nav-link">Paid</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.payments.failed') }}" class="nav-link">Failed</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.payments.refunded') }}" class="nav-link">Refunded</a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Transaction</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $payment->transaction_id ?? 'N/A' }}</code></td>
                            <td>#{{ $payment->order->order_number ?? $payment->order_id }}</td>
                            <td>{{ $payment->order->user->name ?? 'Guest' }}</td>
                            <td class="fw-bold">${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : ($payment->status == 'failed' ? 'danger' : 'info')) }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No payments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection