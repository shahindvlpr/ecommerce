@extends('layouts.admin')

@section('title', 'Sales Report - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-chart-line text-primary me-2"></i>Sales Report
    </h4>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Total Revenue</h6>
                    <h3 class="fw-bold">${{ number_format(\App\Models\Order::where('status', 'delivered')->sum('total') ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Total Orders</h6>
                    <h3 class="fw-bold">{{ \App\Models\Order::where('status', 'delivered')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Average Order</h6>
                    <h3 class="fw-bold">
                        ${{ number_format(\App\Models\Order::where('status', 'delivered')->avg('total') ?? 0, 2) }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">This Month</h6>
                    <h3 class="fw-bold">
                        ${{ number_format(\App\Models\Order::where('status', 'delivered')->whereMonth('created_at', now()->month)->sum('total') ?? 0, 2) }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Sales Chart</h5>
            <canvas id="salesChart" height="300"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sales ($)',
                data: [10000, 13000, 15000, 12000, 18000, 22000, 25000, 23000, 28000, 32000, 35000, 40000],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>
@endsection