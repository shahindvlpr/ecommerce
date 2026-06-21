@extends('layouts.admin')

@section('title', 'Coupon Details - EktaMart Admin')
@section('page-title', 'Coupon Details')
@section('icon', 'ticket-alt')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Back to Coupons
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column - Basic Info --}}
        <div class="col-xl-4 col-lg-5">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Coupon Information</h5>
                </div>
                <div class="detail-card-body">
                    <div class="text-center mb-4">
                        <div class="coupon-display">
                            <span class="coupon-big-code">{{ $coupon->code }}</span>
                            <span class="coupon-big-discount">
                                @if($coupon->type == 'percentage')
                                    {{ $coupon->value }}% OFF
                                @else
                                    ${{ number_format($coupon->value, 2) }} OFF
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="detail-info-item">
                        <span class="detail-info-label">Name</span>
                        <span class="detail-info-value">{{ $coupon->name }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Status</span>
                        <span class="detail-info-value">
                            @if($coupon->is_valid)
                                <span class="badge-status status-active">
                                    <span class="status-dot"></span> Active
                                </span>
                            @else
                                <span class="badge-status status-inactive">
                                    <span class="status-dot"></span> Inactive
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Type</span>
                        <span class="detail-info-value">{{ ucfirst($coupon->type) }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Discount Value</span>
                        <span class="detail-info-value fw-bold text-primary">
                            @if($coupon->type == 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ${{ number_format($coupon->value, 2) }}
                            @endif
                        </span>
                    </div>
                    @if($coupon->max_discount)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Max Discount</span>
                        <span class="detail-info-value">${{ number_format($coupon->max_discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="detail-info-item">
                        <span class="detail-info-label">Min Order</span>
                        <span class="detail-info-value">
                            @if($coupon->min_order_amount)
                                ${{ number_format($coupon->min_order_amount, 2) }}
                            @else
                                <span class="text-muted">No minimum</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Usage</span>
                        <span class="detail-info-value">
                            {{ $coupon->used_count ?? 0 }} / {{ $coupon->usage_limit ?? '∞' }}
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Per User Limit</span>
                        <span class="detail-info-value">{{ $coupon->per_user_limit ?? 'Unlimited' }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Valid From</span>
                        <span class="detail-info-value">
                            @if($coupon->start_date)
                                {{ $coupon->start_date->format('d M Y') }}
                            @else
                                <span class="text-muted">Immediate</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Valid Until</span>
                        <span class="detail-info-value">
                            @if($coupon->end_date)
                                <span class="{{ $coupon->end_date->isPast() ? 'text-danger' : '' }}">
                                    {{ $coupon->end_date->format('d M Y') }}
                                    @if($coupon->end_date->isPast())
                                        <span class="badge bg-danger ms-1">Expired</span>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Created</span>
                        <span class="detail-info-value">{{ $coupon->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Last Updated</span>
                        <span class="detail-info-value">{{ $coupon->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
                </div>
                <div class="detail-card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                           class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit me-1"></i> Edit Coupon
                        </a>
                        <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn {{ $coupon->status ? 'btn-danger' : 'btn-success' }} btn-sm rounded-pill w-100">
                                <i class="fas {{ $coupon->status ? 'fa-pause' : 'fa-play' }} me-1"></i>
                                {{ $coupon->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill w-100">
                                <i class="fas fa-trash-alt me-1"></i> Delete Coupon
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Usage Stats --}}
        <div class="col-xl-8 col-lg-7">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-chart-bar text-primary me-2"></i>Usage Statistics</h5>
                </div>
                <div class="detail-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="stat-mini-card">
                                <div class="stat-mini-value">{{ $coupon->used_count ?? 0 }}</div>
                                <div class="stat-mini-label">Total Uses</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-mini-card">
                                <div class="stat-mini-value">{{ $coupon->usage_limit ?? '∞' }}</div>
                                <div class="stat-mini-label">Usage Limit</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-mini-card">
                                <div class="stat-mini-value">
                                    @if($coupon->usage_limit)
                                        {{ round((($coupon->used_count ?? 0) / $coupon->usage_limit) * 100) }}%
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="stat-mini-label">Utilization</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Usage History (if any) --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-history text-primary me-2"></i>Usage History</h5>
                </div>
                <div class="detail-card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block" style="opacity:0.3;"></i>
                        <p class="text-muted">No usage history available yet.</p>
                    </div>
                </div>
            </div>
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

.coupon-display {
    background: linear-gradient(135deg, #1a1730, #2d2a4a);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}
.coupon-big-code {
    font-size: 28px;
    font-weight: 700;
    color: #8B5CF6;
    font-family: monospace;
    letter-spacing: 2px;
    display: block;
}
.coupon-big-discount {
    font-size: 18px;
    font-weight: 600;
    color: #10B981;
    display: block;
    margin-top: 4px;
}

.stat-mini-card {
    background: var(--bg-body);
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    border: 1px solid var(--border-color);
}
.stat-mini-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary);
}
.stat-mini-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-top: 2px;
    letter-spacing: 0.3px;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.status-active {
    background: #dcfce7;
    color: #16a34a;
}
.status-active .status-dot {
    background: #16a34a;
}
.status-inactive {
    background: #fee2e2;
    color: #dc2626;
}
.status-inactive .status-dot {
    background: #dc2626;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('⚠️ Are you sure you want to delete this coupon?\n\nThis action cannot be undone.')) {
                this.submit();
            }
        });
    });

    console.log('%c🎫 Coupon Details Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush