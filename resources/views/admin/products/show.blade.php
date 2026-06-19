@extends('layouts.admin')

@section('title', 'Product Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-box text-primary me-2"></i>Product Details
            </h4>
            <p class="text-muted small">View complete product information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Product
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Product Image --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center p-4">
                    <img src="{{ $product->thumbnail_url }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded-3" 
                         style="max-height: 350px; width: 100%; object-fit: contain; background: #f8f9fa;">
                    
                    <div class="mt-3">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            @if($product->featured)
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                            @if($product->trending)
                                <span class="badge bg-info text-dark px-3 py-2">
                                    <i class="fas fa-fire"></i> Trending
                                </span>
                            @endif
                            <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                <i class="fas {{ $product->status ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Quick Stats</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Total Views</small>
                                <h6 class="fw-bold mb-0">{{ $product->views ?? 0 }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Total Reviews</small>
                                <h6 class="fw-bold mb-0">{{ $product->reviews_count ?? 0 }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Rating</small>
                                <h6 class="fw-bold mb-0">
                                    @if($product->rating > 0)
                                        {{ number_format($product->rating, 1) }} ⭐
                                    @else
                                        No Rating
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Created</small>
                                <h6 class="fw-bold mb-0">{{ $product->created_at->format('d M Y') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Information --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="fw-bold mb-3">{{ $product->name }}</h5>
                        <small class="text-muted">ID: #{{ $product->id }}</small>
                    </div>

                    <div class="row g-3">
                        {{-- Price --}}
                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold text-uppercase">Price</label>
                            <div class="p-2 bg-light rounded-3">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="text-decoration-line-through text-muted me-2">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="fw-bold text-danger">
                                        ${{ number_format($product->sale_price, 2) }}
                                    </span>
                                @else
                                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Stock --}}
                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold text-uppercase">Stock</label>
                            <div class="p-2 bg-light rounded-3">
                                @if($product->stock > 10)
                                    <span class="text-success fw-bold">{{ $product->stock }} units</span>
                                @elseif($product->stock > 0)
                                    <span class="text-warning fw-bold">{{ $product->stock }} units (Low Stock)</span>
                                @else
                                    <span class="text-danger fw-bold">Out of Stock</span>
                                @endif
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4">
                            <label class="text-muted small fw-semibold text-uppercase">Category</label>
                            <div class="p-2 bg-light rounded-3">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div class="col-md-4">
                            <label class="text-muted small fw-semibold text-uppercase">Brand</label>
                            <div class="p-2 bg-light rounded-3">
                                {{ $product->brand->name ?? 'N/A' }}
                            </div>
                        </div>

                        {{-- SKU --}}
                        <div class="col-md-4">
                            <label class="text-muted small fw-semibold text-uppercase">SKU</label>
                            <div class="p-2 bg-light rounded-3">
                                <code>{{ $product->sku ?? 'N/A' }}</code>
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <div class="col-md-12">
                            <label class="text-muted small fw-semibold text-uppercase">Short Description</label>
                            <div class="p-2 bg-light rounded-3">
                                {{ $product->short_description ?? 'No short description' }}
                            </div>
                        </div>

                        {{-- Full Description --}}
                        <div class="col-md-12">
                            <label class="text-muted small fw-semibold text-uppercase">Description</label>
                            <div class="p-3 bg-light rounded-3" style="max-height: 200px; overflow-y: auto;">
                                @if($product->description)
                                    <p class="mb-0">{{ $product->description }}</p>
                                @else
                                    <span class="text-muted">No description provided</span>
                                @endif
                            </div>
                        </div>

                        {{-- Meta Information --}}
                        <div class="col-md-12">
                            <hr>
                            <div class="row g-2 small">
                                <div class="col-md-4">
                                    <span class="text-muted">Created:</span>
                                    <strong>{{ $product->created_at->format('d M Y, h:i A') }}</strong>
                                </div>
                                <div class="col-md-4">
                                    <span class="text-muted">Last Updated:</span>
                                    <strong>{{ $product->updated_at->diffForHumans() }}</strong>
                                </div>
                                <div class="col-md-4">
                                    <span class="text-muted">Slug:</span>
                                    <code>{{ $product->slug }}</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                        <button type="button" class="btn btn-outline-success" onclick="toggleStatus({{ $product->id }})">
                            <i class="fas {{ $product->status ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            {{ $product->status ? 'Deactivate' : 'Activate' }}
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $product->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-auto">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Form (Hidden) --}}
<form id="delete-form-{{ $product->id }}" 
      action="{{ route('admin.products.destroy', $product) }}" 
      method="POST" 
      style="display: none;">
    @csrf
    @method('DELETE')
</form>

{{-- Toggle Status Form (Hidden) --}}
<form id="toggle-status-form-{{ $product->id }}" 
      action="{{ route('admin.products.toggle-status', $product) }}" 
      method="POST" 
      style="display: none;">
    @csrf
    @method('POST')
</form>

<script>
    // ============================================================
    // 1. CONFIRM DELETE
    // ============================================================
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // ============================================================
    // 2. TOGGLE STATUS
    // ============================================================
    function toggleStatus(id) {
        if (confirm('Are you sure you want to change this product status?')) {
            document.getElementById('toggle-status-form-' + id).submit();
        }
    }

    // ============================================================
    // 3. CONSOLE GREETING
    // ============================================================
    console.log('%c📦 Product Details Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log('%c📝 Product: {{ $product->name }}', 'color: #10b981; font-size: 12px;');
    console.log('%c💰 Price: ${{ number_format($product->price, 2) }}', 'color: #f59e0b; font-size: 12px;');
</script>

<style>
    .bg-light {
        background-color: #f8fafc !important;
    }
    .badge {
        font-weight: 600;
    }
    .card {
        transition: all 0.2s ease;
    }
    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
</style>
@endsection