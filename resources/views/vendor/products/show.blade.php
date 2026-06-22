@extends('vendor.layouts.app')

@section('title', 'Product Details - Vendor Panel')
@section('page-title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
            <p class="text-muted small">Product details and information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('vendor.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Product Image --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 text-center">
                    <img src="{{ $product->thumbnail_url ?? asset('images/placeholder.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded-3" 
                         style="max-height: 350px; object-fit: cover;">
                </div>
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold">{{ $product->name }}</h5>
                            <span class="badge bg-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }} ms-1">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                            @if($product->featured)
                                <span class="badge bg-warning text-dark ms-1">
                                    <i class="fas fa-star me-1"></i> Featured
                                </span>
                            @endif
                        </div>
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                            <i class="fas fa-clock me-1"></i> {{ $product->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <h6 class="text-muted small">Price</h6>
                                @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                                    <h4 class="fw-bold text-danger">${{ number_format($product->sale_price, 2) }}</h4>
                                @else
                                    <h4 class="fw-bold">${{ number_format($product->price, 2) }}</h4>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <h6 class="text-muted small">Stock</h6>
                                <h4 class="fw-bold 
                                    @if($product->stock > 10) text-success
                                    @elseif($product->stock > 0) text-warning
                                    @else text-danger
                                    @endif">
                                    {{ $product->stock }} units
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6 class="fw-semibold">Description</h6>
                        <p class="text-muted">{{ $product->description ?? 'No description available' }}</p>
                    </div>

                    <div class="mt-3 pt-3 border-top">
                        <h6 class="fw-semibold">Product Information</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="fw-semibold" style="width: 120px;">Product ID</td>
                                <td>#{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">SKU</td>
                                <td>{{ $product->sku ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Vendor</td>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Created</td>
                                <td>{{ $product->created_at->format('F d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Last Updated</td>
                                <td>{{ $product->updated_at->diffForHumans() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection