@extends('layouts.admin')

@section('title', 'Coupon Details - EktaMart Admin')
@section('page-title', 'Coupon Details')
@section('icon', 'ticket-alt')

@section('content')
<div class="container-fluid">
    
    {{-- Back Button --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Coupons
                    </a>
                </div>
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-ticket-alt me-1"></i> Coupon Details
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- ============================================================
             LEFT COLUMN - COUPON INFORMATION
        ============================================================ --}}
        <div class="col-xl-4 col-lg-5">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Coupon Information</h5>
                </div>
                <div class="detail-card-body">
                    {{-- Coupon Display --}}
                    <div class="coupon-display text-center mb-4">
                        <div class="coupon-code-display">{{ $coupon->code }}</div>
                        <div class="coupon-discount-display">
                            @if($coupon->type == 'percentage')
                                {{ $coupon->value }}% OFF
                            @else
                                ${{ number_format($coupon->value, 2) }} OFF
                            @endif
                        </div>
                        <div class="coupon-status-badge mt-2">
                            @if($coupon->is_valid)
                                <span class="badge-status status-active">
                                    <span class="status-dot"></span> Active
                                </span>
                            @else
                                <span class="badge-status status-inactive">
                                    <span class="status-dot"></span> Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="detail-info-item">
                        <span class="detail-info-label">Name</span>
                        <span class="detail-info-value">{{ $coupon->name }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Type</span>
                        <span class="detail-info-value">
                            <span class="badge bg-secondary">{{ ucfirst($coupon->type) }}</span>
                        </span>
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
                        <span class="detail-info-label">Minimum Order</span>
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
                            @if($coupon->usage_limit)
                                <span class="text-muted small">
                                    ({{ round((($coupon->used_count ?? 0) / $coupon->usage_limit) * 100) }}% used)
                                </span>
                            @endif
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
                        <form action="{{ route('admin.coupons.duplicate', $coupon) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm rounded-pill w-100 text-white">
                                <i class="fas fa-copy me-1"></i> Duplicate Coupon
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

        {{-- ============================================================
             RIGHT COLUMN - USAGE STATISTICS
        ============================================================ --}}
        <div class="col-xl-8 col-lg-7">
            {{-- Usage Statistics --}}
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

                    {{-- Usage Progress Bar --}}
                    @if($coupon->usage_limit)
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Usage Progress</span>
                                <span class="fw-semibold">{{ $coupon->used_count ?? 0 }} / {{ $coupon->usage_limit }}</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar bg-primary" 
                                     role="progressbar" 
                                     style="width: {{ min(100, round((($coupon->used_count ?? 0) / $coupon->usage_limit) * 100)) }}%; border-radius: 10px;"
                                     aria-valuenow="{{ round((($coupon->used_count ?? 0) / $coupon->usage_limit) * 100) }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Usage History --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-history text-primary me-2"></i>Usage History</h5>
                    <span class="badge bg-secondary">Coming Soon</span>
                </div>
                <div class="detail-card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block" style="opacity:0.3;"></i>
                        <p class="text-muted">No usage history available yet.</p>
                        <p class="text-muted small">Usage history will appear here once customers start using this coupon.</p>
                    </div>
                </div>
            </div>

            {{-- Coupon Rules Preview --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-list-check text-primary me-2"></i>Coupon Rules</h5>
                </div>
                <div class="detail-card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="rule-item">
                                <i class="fas fa-tag text-primary"></i>
                                <div>
                                    <span class="rule-label">Type</span>
                                    <span class="rule-value">{{ ucfirst($coupon->type) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="rule-item">
                                <i class="fas fa-percent text-primary"></i>
                                <div>
                                    <span class="rule-label">Discount</span>
                                    <span class="rule-value">
                                        @if($coupon->type == 'percentage')
                                            {{ $coupon->value }}%
                                        @else
                                            ${{ number_format($coupon->value, 2) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($coupon->min_order_amount)
                        <div class="col-md-6">
                            <div class="rule-item">
                                <i class="fas fa-dollar-sign text-primary"></i>
                                <div>
                                    <span class="rule-label">Min Order</span>
                                    <span class="rule-value">${{ number_format($coupon->min_order_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($coupon->max_discount)
                        <div class="col-md-6">
                            <div class="rule-item">
                                <i class="fas fa-arrow-up text-primary"></i>
                                <div>
                                    <span class="rule-label">Max Discount</span>
                                    <span class="rule-value">${{ number_format($coupon->max_discount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($coupon->usage_limit)
                        <div class="col-md-6">
                            <div class="rule-item">
                                <i class="fas fa-users text-primary"></i>
                                <div>
                                    <span class="rule-label">Usage Limit</span>
                                    <span class="rule-value">{{ $coupon->usage_limit }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($coupon->per_user_limit)
                        <div class="col-md-6">
                            <div class="rule-item">
                                <i class="fas fa-user text-primary"></i>
                                <div>
                                    <span class="rule-label">Per User</span>
                                    <span class="rule-value">{{ $coupon->per_user_limit }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ============================================================
   DETAIL CARD
============================================================ */
.detail-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    /* height: 100%; */
}
.detail-card:hover {
    box-shadow: var(--shadow-md);
}
.detail-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
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

/* ============================================================
   COUPON DISPLAY
============================================================ */
.coupon-display {
    background: linear-gradient(135deg, #1a1730, #2d2a4a);
    border-radius: 12px;
    padding: 24px 20px;
}
.coupon-code-display {
    font-size: 28px;
    font-weight: 700;
    color: #8B5CF6;
    font-family: monospace;
    letter-spacing: 3px;
}
.coupon-discount-display {
    font-size: 20px;
    font-weight: 600;
    color: #10B981;
    margin-top: 4px;
}
.coupon-status-badge {
    margin-top: 8px;
}

/* ============================================================
   DETAIL INFO ITEMS
============================================================ */
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

/* ============================================================
   STATUS BADGE
============================================================ */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px;
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

/* ============================================================
   STAT MINI CARD
============================================================ */
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

/* ============================================================
   RULE ITEMS
============================================================ */
.rule-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: var(--bg-body);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}
.rule-item i {
    font-size: 16px;
    width: 20px;
}
.rule-label {
    font-size: 10px;
    text-transform: uppercase;
    color: var(--text-muted);
    display: block;
    letter-spacing: 0.3px;
}
.rule-value {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    display: block;
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .detail-card-body {
        padding: 16px;
    }
    .coupon-code-display {
        font-size: 22px;
    }
    .coupon-discount-display {
        font-size: 17px;
    }
    .stat-mini-value {
        font-size: 22px;
    }
}

@media (max-width: 576px) {
    .detail-card-body {
        padding: 12px;
    }
    .coupon-code-display {
        font-size: 18px;
        letter-spacing: 1px;
    }
    .coupon-discount-display {
        font-size: 15px;
    }
    .rule-item {
        padding: 6px 10px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .coupon-display {
    background: linear-gradient(135deg, #0f0c29, #1a1730);
}
[data-theme="dark"] .stat-mini-card {
    background: rgba(255,255,255,0.03);
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .rule-item {
    background: rgba(255,255,255,0.03);
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .detail-info-value {
    color: #e2e0f0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================================
    // DELETE CONFIRMATION
    // ============================================================
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('⚠️ Are you sure you want to delete this coupon?\n\nThis action cannot be undone.')) {
                this.submit();
            }
        });
    });

    // ============================================================
    // COPY COUPON CODE
    // ============================================================
    const couponCode = document.querySelector('.coupon-code-display');
    if (couponCode) {
        couponCode.style.cursor = 'pointer';
        couponCode.title = 'Click to copy coupon code';
        couponCode.addEventListener('click', function() {
            const code = this.textContent;
            navigator.clipboard.writeText(code).then(() => {
                // Show toast notification
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed;
                    top: 90px;
                    right: 30px;
                    background: #10B981;
                    color: white;
                    padding: 12px 20px;
                    border-radius: 10px;
                    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
                    z-index: 9999;
                    font-weight: 500;
                    font-size: 0.9rem;
                    animation: slideInRight 0.4s ease;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                `;
                toast.innerHTML = `
                    <i class="fas fa-check-circle"></i>
                    <span>Coupon code copied: <strong>${code}</strong></span>
                `;
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            });
        });
    }

    console.log('%c🎫 Coupon Details Page Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush