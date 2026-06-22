@extends('vendor.layouts.app')

@section('title', 'Sales Report - Vendor Panel')
@section('page-title', 'Sales Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Sales Report</h5>
            <p class="text-muted small">Track your sales performance over time</p>
        </div>
        <a href="{{ route('vendor.reports.export') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel me-1"></i> Export Report
        </a>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">From Date</label>
                    <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">To Date</label>
                    <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-filter me-1"></i> Apply Filter
                        </button>
                        <a href="{{ route('vendor.reports.sales') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Total Sales</h6>
                    <h4 class="fw-bold text-primary">
                        ${{ number_format($sales->sum('total'), 2) }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Total Orders</h6>
                    <h4 class="fw-bold text-success">{{ $sales->sum('orders') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Average Order Value</h6>
                    <h4 class="fw-bold text-warning">
                        ${{ number_format($sales->sum('total') / max($sales->sum('orders'), 1), 2) }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Sales Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Date</th>
                            <th>Orders</th>
                            <th class="text-end pe-3">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-semibold">{{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}</span>
                            </td>
                            <td>{{ $sale->orders }}</td>
                            <td class="text-end pe-3">
                                <span class="fw-bold">${{ number_format($sale->total, 2) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <i class="fas fa-chart-bar fa-3x text-muted d-block mb-3"></i>
                                <h5 class="text-muted">No Sales Data</h5>
                                <p class="text-muted small">No sales found for the selected period</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($sales->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $sales->links() }}
            </div>
        @endif
    </div>
</div>
@endsection