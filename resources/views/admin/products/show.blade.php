@extends('layouts.admin')

@section('title', 'Product Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-box text-primary me-2"></i>Product Details
        </h4>
        <div>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" 
                         class="img-fluid rounded-3" style="max-height: 300px; object-fit: contain;">
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $product->name }}</h5>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Price</label>
                            <p class="fw-bold">${{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Sale Price</label>
                            <p class="fw-bold">${{ number_format($product->sale_price ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Stock</label>
                            <p>
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->stock }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Category</label>
                            <p>{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Brand</label>
                            <p>{{ $product->brand->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">SKU</label>
                            <p>{{ $product->sku ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small">Status</label>
                            <p>
                                <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                                @if($product->featured)
                                    <span class="badge bg-warning">Featured</span>
                                @endif
                                @if($product->trending)
                                    <span class="badge bg-info">Trending</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small">Short Description</label>
                            <p>{{ $product->short_description ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small">Description</label>
                            <p>{{ $product->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection