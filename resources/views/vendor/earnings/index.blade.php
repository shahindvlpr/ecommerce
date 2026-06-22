@extends('vendor.layouts.app')

@section('title', 'Earnings - Vendor Panel')
@section('page-title', 'Earnings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">My Earnings</h5>
            <p class="text-muted small">Track your sales earnings and withdrawals</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Total Earnings</h6>
                    <h4 class="fw-bold text-success">${{ number_format($stats['total_earnings'], 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Pending</h6>
                    <h4 class="fw-bold text-warning">${{ number_format($stats['pending_earnings'], 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Total Withdrawn</h6>
                    <h4 class="fw-bold text-primary">${{ number_format($stats['total_withdrawn'], 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Pending Withdrawals</h6>
                    <h4 class="fw-bold text-danger">${{ number_format($stats['pending_withdrawals'], 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Earnings List --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-history text-primary me-2"></i>Earnings History
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Order</th>
                                    <th>Amount</th>
                                    <th>Commission</th>
                                    <th>Net</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($earnings as $earning)
                                <tr>
                                    <td class="ps-3">{{ $loop->iteration }}</td>
                                    <td>#{{ $earning->order->order_number ?? $earning->order_id }}</td>
                                    <td>${{ number_format($earning->amount, 2) }}</td>
                                    <td>${{ number_format($earning->commission, 2) }}</td>
                                    <td class="fw-bold">${{ number_format($earning->net_amount, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($earning->status == 'paid') bg-success
                                            @elseif($earning->status == 'pending') bg-warning
                                            @elseif($earning->status == 'processing') bg-info
                                            @else bg-danger
                                            @endif
                                            rounded-pill px-3 py-2">
                                            {{ ucfirst($earning->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <small>{{ $earning->created_at->format('M d, Y') }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-money-bill-wave fa-3x text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Earnings Yet</h5>
                                        <p class="text-muted small">Start selling products to earn money</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($earnings->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $earnings->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Withdraw Form --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-hand-holding-usd text-primary me-2"></i>Request Withdrawal
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Available Balance: <strong>${{ number_format($stats['pending_earnings'], 2) }}</strong>
                    </div>

                    <form action="{{ route('vendor.earnings.request-withdraw') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Amount</label>
                            <input type="number" name="amount" class="form-control" 
                                   placeholder="Enter amount" min="100" 
                                   max="{{ $stats['pending_earnings'] }}" required>
                            <small class="text-muted">Min: $100</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="bkash">bKash</option>
                                <option value="nagad">Nagad</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Account Details</label>
                            <textarea name="account_details" class="form-control" rows="2" 
                                      placeholder="Enter account details" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" 
                                      placeholder="Any additional notes"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-1"></i> Submit Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
    }
</style>
@endpush
@endsection