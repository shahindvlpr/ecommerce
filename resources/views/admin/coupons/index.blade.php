@extends('layouts.admin')

@section('title', 'Coupons - EktaMart Admin')
@section('page-title', 'Coupons')
@section('icon', 'ticket-alt')

@section('content')
<div class="container-fluid">
    
    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-ticket-alt"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Coupons</span>
                        <h3 class="stats-value">{{ \App\Models\Coupon::count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> All Coupons</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Active</span>
                        <h3 class="stats-value">{{ \App\Models\Coupon::active()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-check-circle me-1"></i> Active</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-red">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-clock"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Expired</span>
                        <h3 class="stats-value">{{ \App\Models\Coupon::where('end_date', '<', now())->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-clock me-1"></i> Expired</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-orange">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-percent"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Percentage</span>
                        <h3 class="stats-value">{{ \App\Models\Coupon::where('type', 'percentage')->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-percent me-1"></i> % Off</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card premium-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-ticket-alt text-primary me-2"></i>Coupons List</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Add Coupon
                </a>
            </div>
        </div>
        <div class="card-body-custom">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table premium-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Discount</th>
                            <th>Min Order</th>
                            <th>Uses</th>
                            <th>Status</th>
                            <th>Valid Until</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td>#{{ $coupon->id }}</td>
                                <td>
                                    <span class="coupon-code">{{ $coupon->code }}</span>
                                </td>
                                <td>{{ $coupon->name }}</td>
                                <td>
                                    <span class="fw-bold text-primary">
                                        @if($coupon->type == 'percentage')
                                            {{ $coupon->value }}%
                                        @else
                                            ${{ number_format($coupon->value, 2) }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($coupon->min_order_amount)
                                        ${{ number_format($coupon->min_order_amount, 2) }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $coupon->used_count ?? 0 }} / {{ $coupon->usage_limit ?? '∞' }}
                                    </span>
                                </td>
                                <td>
                                    @if($coupon->is_valid)
                                        <span class="badge-status status-active">
                                            <span class="status-dot"></span> Active
                                        </span>
                                    @else
                                        <span class="badge-status status-inactive">
                                            <span class="status-dot"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->end_date)
                                        <span class="{{ $coupon->end_date->isPast() ? 'text-danger' : 'text-muted' }}">
                                            {{ $coupon->end_date->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('admin.coupons.show', $coupon) }}" 
                                           class="action-btn action-view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                           class="action-btn action-edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="action-btn action-status" title="Toggle Status">
                                                <i class="fas {{ $coupon->status ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" 
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-delete" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-ticket-alt"></i></div>
                                        <h6>No Coupons Found</h6>
                                        <p class="text-muted">Start by creating your first coupon.</p>
                                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 mt-2">
                                            <i class="fas fa-plus me-1"></i> Add Coupon
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($coupons->hasPages())
                <div class="pagination-wrapper">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ============================================================
   STATS CARDS
============================================================ */
.stats-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
    height: 100%;
}
.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}
.stats-card-inner {
    padding: 16px 20px 12px 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.stats-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.stats-content {
    flex: 1;
}
.stats-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    display: block;
}
.stats-value {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 2px 0 4px 0;
    line-height: 1.2;
}
.stats-footer {
    padding: 8px 20px 14px 20px;
    border-top: 1px solid var(--border-color);
    font-size: 12px;
    color: var(--text-muted);
}
.stats-card-purple .stats-icon { background: rgba(139,92,246,0.12); color: #8B5CF6; }
.stats-card-green .stats-icon { background: rgba(16,185,129,0.12); color: #10B981; }
.stats-card-red .stats-icon { background: rgba(239,68,68,0.12); color: #EF4444; }
.stats-card-orange .stats-icon { background: rgba(245,158,11,0.12); color: #F59E0B; }

/* ============================================================
   PREMIUM CARD
============================================================ */
.premium-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.card-header-custom {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
.card-header-custom h5 {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
}
.card-body-custom {
    padding: 20px;
}

/* ============================================================
   COUPON CODE
============================================================ */
.coupon-code {
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
    color: #fff;
    padding: 2px 12px;
    border-radius: 4px;
    font-family: monospace;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 1px;
}

/* ============================================================
   STATUS BADGE
============================================================ */
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

/* ============================================================
   ACTION BUTTONS
============================================================ */
.action-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    font-size: 13px;
}
.action-btn:hover {
    transform: translateY(-2px);
}
.action-view {
    background: rgba(59,130,246,0.1);
    color: #3B82F6;
}
.action-view:hover {
    background: #3B82F6;
    color: #fff;
}
.action-edit {
    background: rgba(245,158,11,0.1);
    color: #F59E0B;
}
.action-edit:hover {
    background: #F59E0B;
    color: #fff;
}
.action-delete {
    background: rgba(239,68,68,0.1);
    color: #EF4444;
}
.action-delete:hover {
    background: #EF4444;
    color: #fff;
}
.action-status {
    background: rgba(16,185,129,0.1);
    color: #10B981;
}
.action-status:hover {
    background: #10B981;
    color: #fff;
}

/* ============================================================
   EMPTY STATE
============================================================ */
.empty-state {
    text-align: center;
    padding: 50px 20px;
}
.empty-icon {
    font-size: 56px;
    color: var(--text-muted);
    opacity: 0.2;
    margin-bottom: 16px;
}
.empty-state h6 {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.empty-state p {
    color: var(--text-muted);
}

/* ============================================================
   PAGINATION
============================================================ */
.pagination-wrapper {
    margin-top: 16px;
}
.pagination-wrapper .pagination {
    justify-content: flex-end;
    margin: 0;
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .stats-card {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .stats-card .stats-value {
    color: #f1f5f9;
}
[data-theme="dark"] .premium-card {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .premium-table thead th {
    background: rgba(255,255,255,0.03);
    color: #7F77DD;
}
[data-theme="dark"] .premium-table tbody td {
    border-color: rgba(255,255,255,0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .coupon-code {
    background: linear-gradient(135deg, #7C3AED, #4F46E5);
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

    // Auto dismiss alert
    const alert = document.querySelector('.alert-success');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    }

    console.log('%c🎫 Coupons Module Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush