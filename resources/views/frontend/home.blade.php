@extends('layouts.app')

@section('title', 'EktaMart - Premium Ecommerce Platform')

@section('content')
<style>
    .hover-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 1rem;
        cursor: pointer;
        overflow: hidden;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .text-purple-600 {
        color: #8b5cf6;
    }
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        color: white;
        transition: all 0.3s ease;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-primary-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .product-img-wrapper {
        height: 200px;
        overflow: hidden;
        background: #f8f9fa;
        position: relative;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .hover-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }
    .product-price {
        font-weight: 700;
        color: #4f46e5;
        font-size: 1rem;
    }
    .product-title {
        font-size: 0.9rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.5rem;
    }
    .category-badge {
        background: #f3f4f6;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        color: #6b7280;
        display: inline-block;
    }
    .brand-logo-wrapper {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .brand-logo-wrapper img {
        max-height: 50px;
        max-width: 100%;
        object-fit: contain;
    }
    .category-icon-wrapper {
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .category-icon-wrapper i {
        font-size: 2.5rem;
    }
</style>

<div class="container py-5">
    
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-3" style="color: #1a1a2e;">
                Welcome to <span style="color: #8b5cf6;">EktaMart</span>
            </h1>
            <p class="lead text-muted">Your one-stop destination for premium products at unbeatable prices.</p>
            <div class="mt-4">
                <a href="{{ route('shop.index') }}" class="btn btn-primary-premium btn-lg me-2">
                    <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                </a>
                <a href="{{ route('about') }}" class="btn btn-outline-secondary btn-lg">Learn More</a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <div class="bg-light rounded-4 p-4">
                <i class="fas fa-shopping-cart fa-5x text-purple-600"></i>
                <h5 class="mt-3 text-muted">Shop with Confidence</h5>
            </div>
        </div>
    </div>
    
    <!-- Featured Products -->
    @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Featured Products</h2>
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-primary fw-bold">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm hover-card border-0">
                    <div class="product-img-wrapper">
                        @php
                            // Get product image safely
                            $imageUrl = 'https://via.placeholder.com/300x300/8b5cf6/FFFFFF?text=' . urlencode($product->name);
                            
                            if (!empty($product->thumbnail)) {
                                $imageUrl = asset('storage/products/' . $product->thumbnail);
                            } elseif (!empty($product->images)) {
                                if (is_array($product->images) && count($product->images) > 0) {
                                    $imageUrl = asset('storage/products/' . $product->images[0]);
                                } elseif (is_string($product->images)) {
                                    $images = json_decode($product->images, true);
                                    if (is_array($images) && count($images) > 0) {
                                        $imageUrl = asset('storage/products/' . $images[0]);
                                    }
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}"
                             loading="lazy"
                             onerror="this.src='https://via.placeholder.com/300x300/8b5cf6/FFFFFF?text={{ urlencode($product->name) }}'">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <span class="category-badge mb-1">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-primary-premium">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Categories -->
    @if(isset($categories) && $categories->isNotEmpty())
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Shop by Category</h2>
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-primary fw-bold">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-2 col-sm-4 col-6">
                <a href="{{ route('shop.category', $category->slug) }}" class="text-decoration-none">
                    <div class="card text-center h-100 hover-card border-0">
                        <div class="card-body">
                            <div class="category-icon-wrapper">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} text-purple-600"></i>
                                @else
                                    <i class="fas fa-folder-open text-muted"></i>
                                @endif
                            </div>
                            <h6 class="mt-2 fw-bold">{{ $category->name }}</h6>
                            <small class="text-muted">{{ $category->products_count ?? 0 }} Products</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Latest Products -->
    @if(isset($latestProducts) && $latestProducts->isNotEmpty())
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Latest Products</h2>
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-primary fw-bold">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($latestProducts as $product)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm hover-card border-0">
                    <div class="product-img-wrapper">
                        @php
                            // Get product image safely
                            $imageUrl = 'https://via.placeholder.com/300x300/8b5cf6/FFFFFF?text=' . urlencode($product->name);
                            
                            if (!empty($product->thumbnail)) {
                                $imageUrl = asset('storage/products/' . $product->thumbnail);
                            } elseif (!empty($product->images)) {
                                if (is_array($product->images) && count($product->images) > 0) {
                                    $imageUrl = asset('storage/products/' . $product->images[0]);
                                } elseif (is_string($product->images)) {
                                    $images = json_decode($product->images, true);
                                    if (is_array($images) && count($images) > 0) {
                                        $imageUrl = asset('storage/products/' . $images[0]);
                                    }
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}"
                             loading="lazy"
                             onerror="this.src='https://via.placeholder.com/300x300/8b5cf6/FFFFFF?text={{ urlencode($product->name) }}'">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <span class="category-badge mb-1">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-primary-premium">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Brands -->
    @if(isset($brands) && $brands->isNotEmpty())
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Top Brands</h2>
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-primary fw-bold">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($brands as $brand)
            <div class="col-md-2 col-sm-4 col-6">
                <a href="{{ route('shop.brand', $brand->slug) }}" class="text-decoration-none">
                    <div class="card text-center h-100 hover-card border-0">
                        <div class="card-body">
                            <div class="brand-logo-wrapper">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" 
                                         alt="{{ $brand->name }}" 
                                         loading="lazy"
                                         onerror="this.style.display='none'">
                                @else
                                    <i class="fas fa-trademark fa-3x text-muted"></i>
                                @endif
                            </div>
                            <h6 class="mt-2 fw-bold">{{ $brand->name }}</h6>
                            <small class="text-muted">{{ $brand->products_count ?? 0 }} Products</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection