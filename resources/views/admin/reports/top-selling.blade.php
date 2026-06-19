@extends('layouts.admin')

@section('title', 'Top Selling Products - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-trophy text-primary me-2"></i>Top Selling Products
        </h4>
        <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Reports
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Total Sold</th>
                            <th>Revenue</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $product)
                        <tr>
                            <td>
                                <span class="badge {{ $loop->iteration <= 3 ? 'bg-warning' : 'bg-secondary' }} rounded-circle" style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                                    {{ $loop->iteration }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" 
                                         width="40" height="40" style="object-fit:cover; border-radius:8px;">
                                    {{ $product->name }}
                                </div>
                            </td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->total_sold ?? 0 }}</td>
                            <td class="fw-bold text-success">${{ number_format($product->revenue ?? 0, 2) }}</td>
                            <td>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($product->rating ?? 0) ? '' : 'empty' }}" style="color: {{ $i <= round($product->rating ?? 0) ? '#f59e0b' : '#d1d5db' }};"></i>
                                    @endfor
                                    <span class="text-muted">({{ $product->rating ?? 0 }})</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No data available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection