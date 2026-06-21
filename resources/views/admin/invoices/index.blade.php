@extends('layouts.admin')

@section('title', 'Invoices - EktaMart Admin')
@section('page-title', 'Invoices')
@section('icon', 'file-invoice')

@section('content')
<div class="container-fluid">
    
    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-file-invoice"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Invoices</span>
                        <h3 class="stats-value">{{ \App\Models\Invoice::count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> All Time</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Paid</span>
                        <h3 class="stats-value">{{ \App\Models\Invoice::paid()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-check-circle me-1"></i> Completed</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-red">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-clock"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Unpaid</span>
                        <h3 class="stats-value">{{ \App\Models\Invoice::unpaid()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-clock me-1"></i> Pending</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-orange">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Overdue</span>
                        <h3 class="stats-value">{{ \App\Models\Invoice::overdue()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-exclamation-triangle me-1"></i> Needs Attention</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-tabs">
                <a href="{{ route('admin.invoices.index') }}" 
                   class="filter-tab {{ request()->routeIs('admin.invoices.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> All
                </a>
                <a href="{{ route('admin.invoices.unpaid') }}" 
                   class="filter-tab {{ request()->routeIs('admin.invoices.unpaid') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Unpaid
                    <span class="badge bg-danger">{{ \App\Models\Invoice::unpaid()->count() }}</span>
                </a>
                <a href="{{ route('admin.invoices.paid') }}" 
                   class="filter-tab {{ request()->routeIs('admin.invoices.paid') ? 'active' : '' }}">
                    <i class="fas fa-check"></i> Paid
                </a>
                <a href="{{ route('admin.invoices.overdue') }}" 
                   class="filter-tab {{ request()->routeIs('admin.invoices.overdue') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle"></i> Overdue
                </a>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card premium-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-file-invoice text-primary me-2"></i>Invoices List</h5>
            <div class="d-flex gap-2">
                <span class="badge bg-primary">{{ $invoices->total() }} Total</span>
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
                            <th>Invoice #</th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">{{ $invoice->invoice_number }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $invoice->order_id) }}" class="text-primary">
                                        #{{ $invoice->order_id }}
                                    </a>
                                </td>
                                <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                                <td class="fw-semibold">${{ number_format($invoice->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status_badge }}">
                                        {{ $invoice->status_label }}
                                    </span>
                                    @if($invoice->isOverdue())
                                        <span class="badge bg-danger ms-1">Overdue</span>
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->due_date)
                                        <span class="{{ $invoice->isOverdue() ? 'text-danger' : 'text-muted' }}">
                                            {{ $invoice->due_date->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-group">
                                        <a href="{{ route('admin.invoices.show', $invoice->id) }}" 
                                           class="action-btn action-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" 
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
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-file-invoice"></i></div>
                                        <h6>No Invoices Found</h6>
                                        <p class="text-muted">No invoices have been generated yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div class="pagination-wrapper">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
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

.pagination-wrapper {
    margin-top: 16px;
}
.pagination-wrapper .pagination {
    justify-content: flex-end;
    margin: 0;
}
</style>
@endpush