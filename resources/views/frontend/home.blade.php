@extends('layouts.app')

@section('title', 'EktaMart - Premium Ecommerce Platform')

@section('content')
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
    @if($featuredProducts->isNotEmpty())
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Featured Products</h2>
            <a href="{{ route('shop.index') }}" class="text-decoration-none">View All →</a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="text-muted small">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-primary-premium">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Categories -->
    @if($categories->isNotEmpty())
    <div class="mb-5">
        <h2 class="mb-3">Shop by Category</h2>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-2 col-sm-4 col-6">
                <a href="{{ route('shop.category', $category->slug) }}" class="text-decoration-none">
                    <div class="card text-center h-100 hover-card">
                        <div class="card-body">
                            @if($category->icon)
                                <i class="{{ $category->icon }} fa-3x text-purple-600"></i>
                            @else
                                <i class="fas fa-folder-open fa-3x text-muted"></i>
                            @endif
                            <h6 class="mt-2">{{ $category->name }}</h6>
                            <small class="text-muted">{{ $category->products_count }} Products</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Latest Products -->
    @if($latestProducts->isNotEmpty())
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Latest Products</h2>
            <a href="{{ route('shop.index') }}" class="text-decoration-none">View All →</a>
        </div>
        <div class="row g-4">
            @foreach($latestProducts as $product)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="text-muted small">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-primary-premium">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Brands -->
    @if($brands->isNotEmpty())
    <div class="mb-5">
        <h2 class="mb-3">Top Brands</h2>
        <div class="row g-4">
            @foreach($brands as $brand)
            <div class="col-md-2 col-sm-4 col-6">
                <a href="{{ route('shop.brand', $brand->slug) }}" class="text-decoration-none">
                    <div class="card text-center h-100 hover-card">
                        <div class="card-body">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="height: 50px; width: 100%; object-fit: contain;">
                            @else
                                <i class="fas fa-trademark fa-3x text-muted"></i>
                            @endif
                            <h6 class="mt-2">{{ $brand->name }}</h6>
                            <small class="text-muted">{{ $brand->products_count }} Products</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 1rem;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .text-purple-600 {
        color: #8b5cf6;
    }
</style>
@endsection