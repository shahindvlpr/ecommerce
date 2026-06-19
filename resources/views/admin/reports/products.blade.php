@extends('layouts.admin')

@section('title', 'Products Report - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-boxes text-primary me-2"></i>Products Report
    </h4>

    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total</h6>
                    <h5 class="fw-bold">{{ $totalProducts }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Active</h6>
                    <h5 class="fw-bold text-success">{{ $activeProducts }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Inactive</h6>
                    <h5 class="fw-bold text-danger">{{ $inactiveProducts }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Low Stock</h6>
                    <h5 class="fw-bold text-warning">{{ $lowStockProducts }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Out of Stock</h6>
                    <h5 class="fw-bold text-danger">{{ $outOfStockProducts }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $product->order_items_count ?? 0 }}</td>
                            <td>${{ number_format($product->order_items_sum_total ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">No products found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection