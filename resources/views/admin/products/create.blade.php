@extends('layouts.admin')

@section('title', 'Create Product - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-plus-circle text-primary me-2"></i>Create Product
            </h4>
            <p class="text-muted small">Add a new product to your store</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   placeholder="Enter product name" 
                                   value="{{ old('name') }}" 
                                   required
                                   id="productName">
                            <small class="text-muted">This will be displayed on the frontend</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug</label>
                            <input type="text" name="slug" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   placeholder="auto-generated from name" 
                                   value="{{ old('slug') }}"
                                   id="productSlug">
                            <small class="text-muted">Leave empty to auto-generate from name</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Brand</label>
                            <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SKU -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">SKU</label>
                            <input type="text" name="sku" 
                                   class="form-control @error('sku') is-invalid @enderror" 
                                   placeholder="Product SKU" 
                                   value="{{ old('sku') }}">
                            <small class="text-muted">Unique product identifier</small>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   placeholder="0.00" 
                                   value="{{ old('price') }}" 
                                   step="0.01" 
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sale Price -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sale Price</label>
                            <input type="number" name="sale_price" 
                                   class="form-control @error('sale_price') is-invalid @enderror" 
                                   placeholder="0.00" 
                                   value="{{ old('sale_price') }}" 
                                   step="0.01">
                            <small class="text-muted">Leave empty if not on sale</small>
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   placeholder="0" 
                                   value="{{ old('stock', 0) }}" 
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="status" class="form-check-input" 
                                       id="statusSwitch" value="1" 
                                       {{ old('status') !== '0' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="statusSwitch">
                                    <span id="statusLabel" class="badge bg-success">Active</span>
                                </label>
                            </div>
                            <small class="text-muted">Inactive products won't be visible on the store</small>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Short Description</label>
                            <input type="text" name="short_description" 
                                   class="form-control @error('short_description') is-invalid @enderror" 
                                   placeholder="Brief product description (max 500 characters)" 
                                   value="{{ old('short_description') }}">
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Full Description -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="5" 
                                      placeholder="Full product description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Featured & Trending -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Featured Product</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="featured" class="form-check-input" 
                                       id="featuredSwitch" value="1" 
                                       {{ old('featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="featuredSwitch">
                                    {{ old('featured') ? 'Yes' : 'No' }}
                                </label>
                            </div>
                            <small class="text-muted">Featured products will be highlighted on the homepage</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trending Product</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="trending" class="form-check-input" 
                                       id="trendingSwitch" value="1" 
                                       {{ old('trending') ? 'checked' : '' }}>
                                <label class="form-check-label" for="trendingSwitch">
                                    {{ old('trending') ? 'Yes' : 'No' }}
                                </label>
                            </div>
                            <small class="text-muted">Trending products will appear in trending sections</small>
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Image</label>
                            <input type="file" name="thumbnail" 
                                   class="form-control @error('thumbnail') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Recommended: 500x500px, max 2MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Create Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ============================================================
    // 1. AUTO-GENERATE SLUG FROM NAME
    // ============================================================
    document.getElementById('productName')?.addEventListener('input', function() {
        const slugInput = document.getElementById('productSlug');
        if (slugInput && !slugInput.value) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });

    // ============================================================
    // 2. STATUS TOGGLE
    // ============================================================
    document.getElementById('statusSwitch')?.addEventListener('change', function() {
        const label = document.getElementById('statusLabel');
        if (this.checked) {
            label.textContent = 'Active';
            label.className = 'badge bg-success';
        } else {
            label.textContent = 'Inactive';
            label.className = 'badge bg-secondary';
        }
    });

    // ============================================================
    // 3. FEATURED & TRENDING TOGGLE (Visual Feedback)
    // ============================================================
    document.getElementById('featuredSwitch')?.addEventListener('change', function() {
        const label = this.nextElementSibling;
        label.textContent = this.checked ? 'Yes' : 'No';
    });

    document.getElementById('trendingSwitch')?.addEventListener('change', function() {
        const label = this.nextElementSibling;
        label.textContent = this.checked ? 'Yes' : 'No';
    });

    // ============================================================
    // 4. CONSOLE GREETING
    // ============================================================
    console.log('%c📦 Create Product Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
</script>

<style>
    .form-check-input:checked {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
    }
    .form-check-input:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }
</style>
@endsection