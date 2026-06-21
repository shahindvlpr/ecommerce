@extends('layouts.admin')

@section('title', 'Returns - EktaMart Admin')
@section('page-title', 'Returns Management')
@section('icon', 'undo-alt')

@section('content')
<div class="container-fluid">
    
    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-undo-alt"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Returns</span>
                        <h3 class="stats-value">{{ \App\Models\ProductReturn::count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> All Time</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-orange">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-clock"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Pending</span>
                        <h3 class="stats-value">{{ \App\Models\ProductReturn::pending()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-clock me-1"></i> Needs Action</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Completed</span>
                        <h3 class="stats-value">{{ \App\Models\ProductReturn::completed()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-check-circle me-1"></i> Finished</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-red">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-times-circle"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Rejected</span>
                        <h3 class="stats-value">{{ \App\Models\ProductReturn::rejected()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-times-circle me-1"></i> Declined</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-tabs">
                <a href="{{ route('admin.returns.index') }}" 
                   class="filter-tab {{ request()->routeIs('admin.returns.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> All
                </a>
                <a href="{{ route('admin.returns.pending') }}" 
                   class="filter-tab {{ request()->routeIs('admin.returns.pending') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Pending
                    <span class="badge bg-warning">{{ \App\Models\ProductReturn::pending()->count() }}</span>
                </a>
                <a href="{{ route('admin.returns.approved') }}" 
                   class="filter-tab {{ request()->routeIs('admin.returns.approved') ? 'active' : '' }}">
                    <i class="fas fa-check"></i> Approved
                </a>
                <a href="{{ route('admin.returns.completed') }}" 
                   class="filter-tab {{ request()->routeIs('admin.returns.completed') ? 'active' : '' }}">
                    <i class="fas fa-check-double"></i> Completed
                </a>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card premium-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-undo-alt text-primary me-2"></i>Returns List</h5>
            <div class="d-flex gap-2">
                <span class="badge bg-primary">{{ $returns->total() }} Total</span>
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
                            <th>Return #</th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Reason</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returns as $return)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ $return->return_number ?? $return->id }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $return->order_id) }}" class="text-primary">
                                        #{{ $return->order_id }}
                                    </a>
                                </td>
                                <td>{{ $return->user->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $return->reason_label ?? $return->reason }}</span>
                                </td>
                                <td class="fw-semibold">${{ number_format($return->refund_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $return->status_badge }}">
                                        {{ $return->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <span title="{{ $return->created_at->format('d M Y, h:i A') }}">
                                        {{ $return->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-group">
                                        <a href="{{ route('admin.returns.show', $return->id) }}" 
                                           class="action-btn action-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.returns.destroy', $return->id) }}" 
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
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-undo-alt"></i></div>
                                        <h6>No Returns Found</h6>
                                        <p class="text-muted">No return requests have been submitted yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($returns->hasPages())
                <div class="pagination-wrapper">
                    {{ $returns->links() }}
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
.stats-card-orange .stats-icon { background: rgba(245,158,11,0.12); color: #F59E0B; }
.stats-card-green .stats-icon { background: rgba(16,185,129,0.12); color: #10B981; }
.stats-card-red .stats-icon { background: rgba(239,68,68,0.12); color: #EF4444; }

/* ============================================================
   FILTER TABS
============================================================ */
.filter-tabs {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    background: var(--bg-card);
    padding: 6px;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}
.filter-tab {
    padding: 8px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.filter-tab:hover {
    background: var(--bg-body);
    color: var(--text-primary);
}
.filter-tab.active {
    background: var(--primary);
    color: #fff;
}
.filter-tab .badge {
    font-size: 10px;
    padding: 2px 8px;
}

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
   PREMIUM TABLE
============================================================ */
.premium-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.premium-table thead th {
    background: var(--bg-body);
    color: var(--text-muted);
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 12px;
    border-bottom: 2px solid var(--border-color);
}
.premium-table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    vertical-align: middle;
}
.premium-table tbody tr:hover {
    background: rgba(139,92,246,0.02);
}
.premium-table tbody tr:last-child td {
    border-bottom: none;
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
.action-delete {
    background: rgba(239,68,68,0.1);
    color: #EF4444;
}
.action-delete:hover {
    background: #EF4444;
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
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .filter-tabs {
        flex-wrap: wrap;
    }
    .filter-tab {
        flex: 1;
        justify-content: center;
        font-size: 12px;
        padding: 6px 12px;
    }
    .card-header-custom {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    .card-header-custom .badge {
        align-self: flex-start;
    }
    .card-body-custom {
        padding: 12px;
    }
    .premium-table {
        font-size: 12px;
    }
    .premium-table thead th,
    .premium-table tbody td {
        padding: 6px 8px;
    }
    .stats-card-inner {
        padding: 12px 16px 8px 16px;
        gap: 10px;
    }
    .stats-icon {
        width: 38px;
        height: 38px;
        font-size: 15px;
    }
    .stats-value {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .filter-tab {
        font-size: 11px;
        padding: 4px 10px;
    }
    .action-btn {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }
    .stats-card-inner {
        padding: 10px 12px 6px 12px;
        gap: 8px;
    }
    .stats-icon {
        width: 32px;
        height: 32px;
        font-size: 13px;
    }
    .stats-value {
        font-size: 16px;
    }
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
[data-theme="dark"] .filter-tabs {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .filter-tab {
    color: #9896b0;
}
[data-theme="dark"] .filter-tab:hover {
    background: rgba(255,255,255,0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .premium-table thead th {
    background: rgba(255,255,255,0.03);
    color: #7F77DD;
}
[data-theme="dark"] .premium-table tbody td {
    border-color: rgba(255,255,255,0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .card-header-custom {
    border-bottom-color: rgba(255,255,255,0.04);
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
            if (confirm('⚠️ Are you sure you want to delete this return request?\n\nThis action cannot be undone.')) {
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

    console.log('%c📦 Returns Module Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush