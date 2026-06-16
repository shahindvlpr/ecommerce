@extends('layouts.app')

@section('title', 'Shop - EktaMart')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        @foreach($categories ?? [] as $category)
                        <li class="mb-2">
                            <a href="{{ route('shop.category', $category->slug) }}" class="text-decoration-none text-dark">
                                {{ $category->name }} <span class="badge bg-light text-muted">{{ $category->products_count ?? 0 }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <hr>
                    
                    <h5 class="fw-bold mb-3">Brands</h5>
                    <ul class="list-unstyled">
                        @foreach($brands ?? [] as $brand)
                        <li class="mb-2">
                            <a href="{{ route('shop.brand', $brand->slug) }}" class="text-decoration-none text-dark">
                                {{ $brand->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Products -->
        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($products ?? [] as $product)
                <div class="col-md-4 col-sm-6">
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
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4>No Products Found</h4>
                    <p class="text-muted">Check back later for new products.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $products->links() ?? '' }}
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 1rem;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
</style>
@endsection