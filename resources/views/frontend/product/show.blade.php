@extends('layouts.app')

@section('title', $product->name . ' - EktaMart')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Images -->
        <div class="col-md-6">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded-4"
                         id="mainProductImage">
                </div>
                @if(count($product->gallery_images) > 1)
                <div class="thumbnails mt-3 d-flex gap-2">
                    @foreach($product->gallery_images as $image)
                    <img src="{{ $image }}" 
                         alt="Thumbnail" 
                         class="thumbnail-img rounded-3" 
                         style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                         onclick="changeMainImage('{{ $image }}')">
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h1 class="fw-bold">{{ $product->name }}</h1>
            
            <!-- Rating -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="product-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $product->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    <span class="text-muted ms-2">({{ $totalReviews }} reviews)</span>
                </div>
                <span class="badge {{ $product->is_in_stock ? 'bg-success' : 'bg-danger' }}">
                    {{ $product->is_in_stock ? 'In Stock' : 'Out of Stock' }}
                </span>
                @if($product->is_new)
                    <span class="badge bg-primary">New</span>
                @endif
            </div>

            <!-- Price -->
            <div class="product-price mb-3">
                @if($product->is_on_sale)
                    <span class="text-muted text-decoration-line-through fs-5 me-2">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    <span class="fs-3 fw-bold text-primary">
                        ${{ number_format($product->sale_price, 2) }}
                    </span>
                    <span class="badge bg-danger ms-2">-{{ $product->discount_percentage }}%</span>
                @else
                    <span class="fs-3 fw-bold text-primary">
                        ${{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <!-- Short Description -->
            @if($product->short_description)
                <div class="product-short-description mb-3">
                    <p class="text-muted">{{ $product->short_description }}</p>
                </div>
            @endif

            <!-- Full Description -->
            @if($product->description)
                <div class="product-description mb-4">
                    <p>{!! nl2br($product->description) !!}</p>
                </div>
            @endif

            <!-- Stock Info -->
            <div class="stock-info mb-3">
                @if($product->stock > 0)
                    <p class="text-success">
                        <i class="fas fa-check-circle"></i> 
                        {{ $product->stock }} items in stock
                    </p>
                @else
                    <p class="text-danger">
                        <i class="fas fa-times-circle"></i> Out of stock
                    </p>
                @endif
            </div>

            <!-- Quantity & Add to Cart -->
            @if($product->is_in_stock)
            <div class="d-flex gap-3 align-items-center mb-4">
                <div class="quantity-selector d-flex align-items-center border rounded-3">
                    <button class="btn btn-outline-secondary border-0" onclick="decreaseQty()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                           class="form-control border-0 text-center" style="width: 60px;">
                    <button class="btn btn-outline-secondary border-0" onclick="increaseQty()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                
                <button onclick="addToCart()" class="btn btn-primary-premium px-4 py-2 flex-grow-1">
                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                </button>
                
                <button onclick="toggleWishlist()" class="btn {{ $inWishlist ? 'btn-danger' : 'btn-outline-danger' }} btn-lg" id="wishlistBtn">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            @endif

            <!-- Product Meta -->
            <div class="product-meta border-top pt-3">
                <p class="mb-1"><strong>Category:</strong> {{ $product->category->name ?? 'Uncategorized' }}</p>
                @if($product->brand)
                    <p class="mb-1"><strong>Brand:</strong> {{ $product->brand->name }}</p>
                @endif
                @if($product->sku)
                    <p class="mb-1"><strong>SKU:</strong> {{ $product->sku }}</p>
                @endif
                @if($product->barcode)
                    <p class="mb-1"><strong>Barcode:</strong> {{ $product->barcode }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Reviews Section -->
    @if($totalReviews > 0)
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Customer Reviews</h4>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center">
                        <h2 class="fw-bold text-primary">{{ number_format($product->rating, 1) }}</h2>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($product->rating) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <p class="text-muted">{{ $totalReviews }} reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        @for($i = 5; $i >= 1; $i--)
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="text-muted" style="width: 30px;">{{ $i }}★</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" 
                                         style="width: {{ $reviewPercentages[$i] ?? 0 }}%;"></div>
                                </div>
                                <span class="text-muted" style="width: 40px;">{{ $reviewPercentages[$i] ?? 0 }}%</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4">You May Also Like</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 col-sm-6">
                <div class="card product-card shadow-sm border-0 rounded-4">
                    <div class="product-image" style="height: 180px;">
                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <h6 class="product-title">{{ $related->name }}</h6>
                        <p class="fw-bold text-primary">${{ number_format($related->price, 2) }}</p>
                        <a href="{{ route('product.show', $related->slug) }}" class="btn btn-outline-primary btn-sm w-100">
                            View Product
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .main-image {
        border-radius: 1rem;
        overflow: hidden;
        background: #f8f9fa;
        text-align: center;
    }
    .main-image img {
        width: 100%;
        height: 400px;
        object-fit: contain;
    }
    .thumbnail-img {
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .thumbnail-img:hover {
        border-color: #667eea;
        transform: scale(1.05);
    }
    .quantity-selector {
        background: white;
    }
    .quantity-selector input::-webkit-inner-spin-button,
    .quantity-selector input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .quantity-selector input {
        -moz-appearance: textfield;
    }
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .product-image {
        overflow: hidden;
        border-radius: 1rem 1rem 0 0;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    .progress {
        background-color: #e5e7eb;
        border-radius: 1rem;
    }
    .progress-bar {
        border-radius: 1rem;
    }
</style>

<script>
    let qty = 1;
    const maxStock = {{ $product->stock }};

    function increaseQty() {
        const input = document.getElementById('quantity');
        qty = parseInt(input.value) + 1;
        if (qty > maxStock) qty = maxStock;
        input.value = qty;
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            qty = parseInt(input.value) - 1;
            input.value = qty;
        }
    }

    function addToCart() {
        const productId = {{ $product->id }};
        const quantity = document.getElementById('quantity').value;
        
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message || 'Product added to cart!');
                updateCartCount();
            } else {
                alert(data.message || 'Failed to add to cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }

function toggleWishlist() {
    const productId = {{ $product->id }};
    const btn = document.getElementById('wishlistBtn');
    
    fetch('{{ route("customer.wishlist.toggle", ["productId" => $product->id]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'added') {
            btn.className = 'btn btn-danger btn-lg';
            btn.innerHTML = '<i class="fas fa-heart"></i>';
            showToast('Added to wishlist!', 'success');
        } else if(data.status === 'removed') {
            btn.className = 'btn btn-outline-danger btn-lg';
            btn.innerHTML = '<i class="fas fa-heart"></i>';
            showToast('Removed from wishlist!', 'info');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#3b82f6'};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        animation: slideIn 0.3s ease;
        min-width: 200px;
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

    function changeMainImage(src) {
        document.getElementById('mainProductImage').src = src;
    }

    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartCount');
                if (badge) badge.textContent = data.count;
            });
    }

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });
</script>
@endsection