@extends('layouts.admin')

@section('title', 'Low Stock Products - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Low Stock Products
    </h4>

    @if($products->count() > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>{{ $products->count() }}</strong> products are running low on stock.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $product->thumbnail_url ?? asset('images/default-product.png') }}" 
                                         alt="{{ $product->name }}" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                    <span>{{ $product->name }}</span>
                                </div>
                            </td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $product->stock <= 0 ? 'bg-danger' : ($product->stock <= 5 ? 'bg-warning' : 'bg-info') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                <i class="fas fa-check-circle fa-2x text-success d-block mb-2"></i>
                                All products have sufficient stock!
                            </td>
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