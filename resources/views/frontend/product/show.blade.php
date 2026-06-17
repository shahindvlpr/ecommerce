@extends('layouts.app')

@section('title', $product->name . ' - EktaMart')

@section('content')
<style>
    .product-gallery {
        position: sticky;
        top: 100px;
    }
    .main-image {
        border-radius: 1rem;
        overflow: hidden;
        background: #f8f9fa;
        text-align: center;
        border: 1px solid #e5e7eb;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .main-image img {
        width: 100%;
        max-height: 450px;
        object-fit: contain;
        padding: 1rem;
        transition: transform 0.3s ease;
    }
    .main-image img:hover {
        transform: scale(1.02);
    }
    .thumbnail-img {
        border: 2px solid transparent;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        object-fit: cover;
    }
    .thumbnail-img:hover {
        border-color: #667eea;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }
    .thumbnail-img.active {
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .quantity-selector {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .quantity-selector input::-webkit-inner-spin-button,
    .quantity-selector input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .quantity-selector input {
        -moz-appearance: textfield;
        width: 50px;
        text-align: center;
        font-weight: 600;
        padding: 0.3rem 0;
        border: none;
        outline: none;
    }
    .quantity-selector button {
        padding: 0.3rem 0.8rem;
        background: transparent;
        border: none;
        transition: all 0.3s ease;
        color: #4b5563;
        font-weight: 600;
    }
    .quantity-selector button:hover {
        background: #f3f4f6;
        color: #667eea;
    }
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        color: white;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    .btn-primary-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .product-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .product-image {
        overflow: hidden;
        border-radius: 1rem 1rem 0 0;
        height: 200px;
        background: #f8f9fa;
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
    .product-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-weight: 600;
        font-size: 0.9rem;
        min-height: 2.4rem;
    }
    .rating-stars {
        color: #f59e0b;
        letter-spacing: 1px;
    }
    .rating-stars .empty {
        color: #d1d5db;
    }
    .progress {
        background-color: #f3f4f6;
        border-radius: 1rem;
        height: 8px;
    }
    .progress-bar {
        border-radius: 1rem;
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }
    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .breadcrumb-item a:hover {
        color: #4f46e5;
    }
    .stock-badge {
        padding: 0.35rem 0.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .stock-badge.in-stock {
        background: #dcfce7;
        color: #16a34a;
    }
    .stock-badge.out-stock {
        background: #fee2e2;
        color: #dc2626;
    }
    .stock-badge.low-stock {
        background: #fef3c7;
        color: #d97706;
    }
    @media (max-width: 768px) {
        .product-gallery {
            position: static;
        }
        .main-image {
            min-height: 250px;
        }
        .main-image img {
            max-height: 300px;
        }
        .product-image {
            height: 150px;
        }
    }
</style>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- ============================================
             PRODUCT IMAGES
        ============================================ -->
        <div class="col-lg-6">
            <div class="product-gallery">
                <!-- Main Image -->
                <div class="main-image">
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}" 
                         id="mainProductImage"
                         loading="lazy">
                </div>
                
<!-- Thumbnails -->
@php
    $galleryImages = $product->gallery_images ?? [];
    $hasGallery = !empty($galleryImages) && is_array($galleryImages) && count($galleryImages) > 1;
@endphp
@if($hasGallery)
<div class="thumbnails mt-3 d-flex gap-2 overflow-auto pb-2">
    @foreach($galleryImages as $index => $image)
        @if(!empty($image))
        <img src="{{ $image }}" 
             alt="Thumbnail {{ $index + 1 }}" 
             class="thumbnail-img {{ $index == 0 ? 'active' : '' }}" 
             style="width: 70px; height: 70px; flex-shrink: 0;"
             onclick="changeMainImage('{{ $image }}', this)">
        @endif
    @endforeach
</div>
@endif
            </div>
        </div>

        <!-- ============================================
             PRODUCT INFO
        ============================================ -->
        <div class="col-lg-6">
            <!-- Product Name -->
            <h1 class="fw-bold mb-2" style="font-size: 1.8rem;">{{ $product->name }}</h1>
            
            <!-- Rating & Stock -->
            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($product->rating) ? '' : 'empty' }}"></i>
                        @endfor
                    </div>
                    <span class="text-muted small">({{ $totalReviews ?? 0 }} reviews)</span>
                </div>
                
                @php
                    $stockClass = 'in-stock';
                    $stockText = 'In Stock';
                    if ($product->stock <= 0) {
                        $stockClass = 'out-stock';
                        $stockText = 'Out of Stock';
                    } elseif ($product->stock <= 10) {
                        $stockClass = 'low-stock';
                        $stockText = 'Low Stock (' . $product->stock . ' left)';
                    }
                @endphp
                <span class="stock-badge {{ $stockClass }}">
                    <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>
                    {{ $stockText }}
                </span>
                
                @if($product->is_new)
                    <span class="badge bg-primary rounded-pill px-3 py-2">New</span>
                @endif
                @if($product->featured)
                    <span class="badge bg-warning rounded-pill px-3 py-2 text-dark">Featured</span>
                @endif
            </div>

            <!-- Price -->
            <div class="mb-3">
                @if($product->is_on_sale)
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted text-decoration-line-through fs-4">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        <span class="fs-2 fw-bold text-primary">
                            ${{ number_format($product->sale_price, 2) }}
                        </span>
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            Save {{ $product->discount_percentage }}%
                        </span>
                    </div>
                @else
                    <span class="fs-2 fw-bold text-primary">
                        ${{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <!-- Short Description -->
            @if($product->short_description)
                <div class="mb-3 p-3 bg-light rounded-3">
                    <p class="mb-0 text-muted">{{ $product->short_description }}</p>
                </div>
            @endif

            <!-- Full Description -->
            @if($product->description)
                <div class="mb-4">
                    <p class="text-secondary" style="line-height: 1.8;">
                        {!! nl2br(e($product->description)) !!}
                    </p>
                </div>
            @endif

            <!-- Features / Highlights -->
            @if($product->attributes && is_array($product->attributes))
            <div class="mb-4">
                <h6 class="fw-bold mb-2"><i class="fas fa-list-check text-primary me-2"></i>Key Features</h6>
                <ul class="list-unstyled row g-2">
                    @foreach($product->attributes as $key => $value)
                        <li class="col-6">
                            <span class="badge bg-light text-dark border px-3 py-2 w-100 text-start">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                {{ $key }}: {{ $value }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Quantity & Add to Cart -->
            @if($product->is_in_stock)
            <div class="d-flex flex-wrap gap-3 align-items-center mb-4 p-3 bg-light rounded-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold">Qty:</span>
                    <div class="quantity-selector d-flex align-items-center">
                        <button onclick="decreaseQty()" aria-label="Decrease quantity">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               aria-label="Quantity">
                        <button onclick="increaseQty()" aria-label="Increase quantity">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <button onclick="addToCart()" class="btn btn-primary-premium px-5 py-3 flex-grow-1">
                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                </button>
                
                <button onclick="toggleWishlist()" 
                        class="btn {{ $inWishlist ? 'btn-danger' : 'btn-outline-danger' }} btn-lg" 
                        id="wishlistBtn"
                        style="border-radius: 0.75rem; width: 55px; height: 55px;">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            @else
            <div class="alert alert-danger rounded-3 mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                This product is currently out of stock. Please check back later.
            </div>
            @endif

            <!-- Product Meta -->
            <div class="product-meta border-top pt-3">
                <div class="row g-2 small">
                    <div class="col-md-6">
                        <span class="text-muted">Category:</span>
                        <strong>{{ $product->category->name ?? 'Uncategorized' }}</strong>
                    </div>
                    @if($product->brand)
                    <div class="col-md-6">
                        <span class="text-muted">Brand:</span>
                        <strong>{{ $product->brand->name }}</strong>
                    </div>
                    @endif
                    @if($product->sku)
                    <div class="col-md-6">
                        <span class="text-muted">SKU:</span>
                        <strong>{{ $product->sku }}</strong>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <span class="text-muted">Product ID:</span>
                        <strong>#{{ $product->id }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         PRODUCT REVIEWS
    ============================================ -->
    @if(isset($totalReviews) && $totalReviews > 0)
    <div class="mt-5">
        <h4 class="fw-bold mb-4">
            <i class="fas fa-star text-warning me-2"></i>
            Customer Reviews ({{ $totalReviews }})
        </h4>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 text-center p-4">
                    <h2 class="fw-bold text-primary" style="font-size: 3rem;">
                        {{ number_format($product->rating, 1) }}
                    </h2>
                    <div class="rating-stars mb-2" style="font-size: 1.2rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($product->rating) ? '' : 'empty' }}"></i>
                        @endfor
                    </div>
                    <p class="text-muted">{{ $totalReviews }} reviews</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    @php
                        $reviewPercentages = $reviewPercentages ?? [];
                    @endphp
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $percentage = $reviewPercentages[$i] ?? 0;
                        @endphp
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="text-muted" style="width: 35px; font-weight: 600;">{{ $i }}★</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" style="width: {{ $percentage }}%;"></div>
                            </div>
                            <span class="text-muted" style="width: 45px; font-weight: 500;">{{ $percentage }}%</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- ============================================
         RELATED PRODUCTS
    ============================================ -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">
                <i class="fas fa-sync-alt text-primary me-2"></i>
                You May Also Like
            </h3>
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-primary fw-bold">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 col-sm-6">
                <div class="card product-card shadow-sm border-0 rounded-4 h-100">
                    <div class="product-image">
                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}" loading="lazy">
                        @if($related->is_on_sale)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2 rounded-pill px-3 py-2">
                                -{{ $related->discount_percentage }}%
                            </span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="product-title">{{ $related->name }}</h6>
                        <div class="rating-stars small mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($related->rating) ? '' : 'empty' }}" style="font-size: 0.7rem;"></i>
                            @endfor
                        </div>
                        <div class="mt-auto">
                            <p class="fw-bold text-primary mb-2">
                                @if($related->is_on_sale)
                                    <span class="text-muted text-decoration-line-through me-1 small">
                                        ${{ number_format($related->price, 2) }}
                                    </span>
                                @endif
                                ${{ number_format($related->is_on_sale ? $related->sale_price : $related->price, 2) }}
                            </p>
                            <a href="{{ route('product.show', $related->slug) }}" 
                               class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                                <i class="fas fa-eye me-1"></i> View Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    // ============================================
    // 1. QUANTITY CONTROLS
    // ============================================
    let qty = 1;
    const maxStock = {{ $product->stock ?? 0 }};

    function increaseQty() {
        const input = document.getElementById('quantity');
        if (input) {
            qty = parseInt(input.value) + 1;
            if (qty > maxStock) qty = maxStock;
            input.value = qty;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (input && parseInt(input.value) > 1) {
            qty = parseInt(input.value) - 1;
            input.value = qty;
        }
    }

    // ============================================
    // 2. ADD TO CART
    // ============================================
    function addToCart() {
        const productId = {{ $product->id }};
        const quantity = document.getElementById('quantity')?.value || 1;
        const btn = event?.target?.closest('button');
        
        if (btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Adding...';
            btn.disabled = true;
        }
        
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
            if (data.success) {
                showNotification('✅ ' + (data.message || 'Product added to cart!'), 'success');
                updateCartCount();
            } else {
                showNotification('❌ ' + (data.message || 'Failed to add to cart'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('❌ Something went wrong! Please try again.', 'error');
        })
        .finally(() => {
            if (btn) {
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i> Add to Cart';
                btn.disabled = false;
            }
        });
    }

    // ============================================
    // 3. TOGGLE WISHLIST
    // ============================================
    function toggleWishlist() {
        const productId = {{ $product->id }};
        const btn = document.getElementById('wishlistBtn');
        
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
        }
        
        fetch('{{ route("customer.wishlist.toggle", ["productId" => $product->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                btn.className = 'btn btn-danger btn-lg';
                btn.innerHTML = '<i class="fas fa-heart"></i>';
                showNotification('❤️ Added to wishlist!', 'success');
            } else if (data.status === 'removed') {
                btn.className = 'btn btn-outline-danger btn-lg';
                btn.innerHTML = '<i class="fas fa-heart"></i>';
                showNotification('💔 Removed from wishlist!', 'info');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('❌ Something went wrong!', 'error');
        })
        .finally(() => {
            if (btn) btn.disabled = false;
        });
    }

    // ============================================
    // 4. CHANGE MAIN IMAGE
    // ============================================
    function changeMainImage(src, element) {
        document.getElementById('mainProductImage').src = src;
        
        // Remove active class from all thumbnails
        document.querySelectorAll('.thumbnail-img').forEach(el => {
            el.classList.remove('active');
        });
        
        // Add active class to clicked thumbnail
        if (element) {
            element.classList.add('active');
        }
    }

    // ============================================
    // 5. UPDATE CART COUNT
    // ============================================
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartCount');
                if (badge) {
                    badge.textContent = data.count || 0;
                    badge.style.display = data.count > 0 ? 'inline-block' : 'none';
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }

    // ============================================
    // 6. NOTIFICATION
    // ============================================
    function showNotification(message, type = 'success') {
        const existing = document.querySelector('.custom-notification');
        if (existing) existing.remove();
        
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };
        
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        
        const notification = document.createElement('div');
        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: ${colors[type] || colors.success};
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            z-index: 9999;
            font-weight: 500;
            font-size: 0.95rem;
            animation: slideInRight 0.4s ease;
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
        `;
        notification.innerHTML = `
            <i class="fas fa-${icons[type] || icons.success}" style="font-size: 1.2rem;"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" style="
                background: transparent;
                border: none;
                color: white;
                opacity: 0.7;
                cursor: pointer;
                margin-left: auto;
                font-size: 1rem;
                padding: 4px;
            ">
                <i class="fas fa-times"></i>
            </button>
        `;
        document.body.appendChild(notification);
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }
        }, 4000);
    }

    // ============================================
    // 7. INITIALIZE ON PAGE LOAD
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
        
        // Auto-select first thumbnail
        const firstThumb = document.querySelector('.thumbnail-img');
        if (firstThumb) {
            firstThumb.classList.add('active');
        }
    });

    console.log('%c🛍️ EktaMart Product Details Page Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
    console.log('%c📦 Product: {{ $product->name }}', 'color: #764ba2; font-size: 12px;');
</script>
@endsection