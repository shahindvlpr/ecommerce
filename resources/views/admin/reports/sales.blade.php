@extends('layouts.admin')

@section('title', 'Sales Report - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-chart-line text-primary me-2"></i>Sales Report
            </h4>
            <p class="text-muted small">View sales performance</p>
        </div>
        <a href="{{ route('admin.reports.export.sales') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export Report
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total Revenue</h6>
                    <h3 class="fw-bold text-success">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total Orders</h6>
                    <h3 class="fw-bold">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Average Order Value</h6>
                    <h3 class="fw-bold">${{ number_format($averageOrderValue, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Date Range</h6>
                    <h6 class="fw-bold">{{ $startDate }} to {{ $endDate }}</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Sales Chart</h6>
            <canvas id="salesChart" height="300"></canvas>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-3">
            <h6 class="fw-bold">Top Selling Products</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Total Sold</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->total_sold }}</td>
                            <td class="fw-bold">${{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(item => item.date),
            datasets: [{
                label: 'Revenue ($)',
                data: salesData.map(item => item.total_revenue),
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection