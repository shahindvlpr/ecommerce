@extends('layouts.admin')

@section('title', 'Return #' . $return->id . ' - Details')
@section('page-title', 'Return Details')
@section('icon', 'undo-alt')

@section('content')
<div class="container-fluid">
    
    {{-- Back Button --}}
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.returns.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Back to Returns
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column - Return Info --}}
        <div class="col-xl-4 col-lg-5">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Return Information</h5>
                </div>
                <div class="detail-card-body">
                    <div class="detail-info-item">
                        <span class="detail-info-label">Return #</span>
                        <span class="detail-info-value fw-bold text-primary">#{{ $return->return_number ?? $return->id }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Order #</span>
                        <span class="detail-info-value">
                            <a href="{{ route('admin.orders.show', $return->order_id) }}" class="text-primary">
                                #{{ $return->order_id }}
                            </a>
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Customer</span>
                        <span class="detail-info-value">{{ $return->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Reason</span>
                        <span class="detail-info-value">
                            <span class="badge bg-secondary">{{ $return->reason_label ?? $return->reason }}</span>
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Status</span>
                        <span class="detail-info-value">
                            <span class="badge bg-{{ $return->status_badge }}">{{ $return->status_label }}</span>
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Refund Amount</span>
                        <span class="detail-info-value fw-bold text-success">${{ number_format($return->refund_amount ?? 0, 2) }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Requested Date</span>
                        <span class="detail-info-value">{{ $return->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @if($return->approved_at)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Approved Date</span>
                        <span class="detail-info-value">{{ $return->approved_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                    @if($return->completed_at)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Completed Date</span>
                        <span class="detail-info-value">{{ $return->completed_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Status Update --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-edit text-primary me-2"></i>Update Status</h5>
                </div>
                <div class="detail-card-body">
                    <form action="{{ route('admin.returns.update-status', $return->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $return->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="completed" {{ $return->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $return->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Refund Amount</label>
                            <input type="number" name="refund_amount" class="form-control" 
                                   value="{{ $return->refund_amount }}" step="0.01" min="0">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="2">{{ $return->admin_notes }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">
                            <i class="fas fa-save me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Column - Order Items --}}
        <div class="col-xl-8 col-lg-7">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-box text-primary me-2"></i>Order Items</h5>
                    <span class="badge bg-primary">{{ $return->order->items->count() ?? 0 }} Items</span>
                </div>
                <div class="detail-card-body p-0">
                    <div class="table-responsive">
                        <table class="table detail-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($return->order->items ?? [] as $item)
                                    <tr>
                                        <td>#{{ $item->id }}</td>
                                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price ?? 0, 2) }}</td>
                                        <td class="fw-semibold">${{ number_format(($item->price ?? 0) * ($item->quantity ?? 0), 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Admin Notes --}}
            @if($return->admin_notes)
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-sticky-note text-primary me-2"></i>Admin Notes</h5>
                </div>
                <div class="detail-card-body">
                    <p class="mb-0">{{ $return->admin_notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
.detail-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    height: 100%;
}
.detail-card:hover {
    box-shadow: var(--shadow-md);
}
.detail-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
}
.detail-card-header h5 {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
}
.detail-card-body {
    padding: 20px;
}
.detail-info-item {
    padding: 8px 0;
    border-bottom: 1px solid var(--border-color);
}
.detail-info-item:last-child {
    border-bottom: none;
}
.detail-info-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    display: block;
    letter-spacing: 0.3px;
}
.detail-info-value {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    display: block;
    margin-top: 2px;
}
.detail-table {
    margin: 0;
    font-size: 13px;
}
.detail-table thead th {
    background: var(--bg-body);
    color: var(--text-muted);
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
}
.detail-table tbody td {
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
}
.detail-table tbody tr:last-child td {
    border-bottom: none;
}
</style>
@endpush