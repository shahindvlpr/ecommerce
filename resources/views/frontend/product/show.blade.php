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
        cursor: pointer;
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
        cursor: pointer;
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
        cursor: pointer;
    }
    .btn-primary-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .btn-primary-premium:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }
    .btn-outline-primary-premium {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-outline-primary-premium:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
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
        position: relative;
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

    /* ============================================
       REVIEW STYLES
    ============================================ */
    .review-card {
        background: white;
        border-radius: 1rem;
        padding: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .review-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .review-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }
    .review-avatar.small {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }
    .review-stars {
        color: #f59e0b;
        font-size: 0.9rem;
    }
    .review-stars .empty {
        color: #d1d5db;
    }
    .review-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .review-image:hover {
        transform: scale(1.05);
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }
    .verified-badge {
        background: #dcfce7;
        color: #16a34a;
        padding: 0.1rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.55rem;
        font-weight: 600;
    }
    .helpful-btn {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .helpful-btn:hover {
        color: #667eea;
        transform: scale(1.1);
    }

    /* ============================================
       REVIEW MODAL
    ============================================ */
    .star-rating i {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .star-rating i:hover {
        transform: scale(1.3);
    }
    .star-rating i.active {
        color: #f59e0b !important;
    }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
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
        .review-image {
            width: 45px;
            height: 45px;
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
                    @php
                        $imageMap = [
                            'iphone' => 'iphone.jpg',
                            'samsung' => 'samsung.jpg',
                            'nike' => 'nike.jpg',
                            'adidas' => 'adidas.jpg',
                            'coffee' => 'coffee.jpg',
                            'lamp' => 'lamp.jpg',
                            'book' => 'book.jpg',
                        ];
                        $mainImageUrl = $product->thumbnail_url;
                        if (str_contains($mainImageUrl, 'placehold.co')) {
                            $productName = strtolower($product->name);
                            foreach ($imageMap as $key => $file) {
                                if (str_contains($productName, $key)) {
                                    $mainImageUrl = asset('storage/products/' . $file);
                                    break;
                                }
                            }
                        }
                    @endphp
                    <img src="{{ $mainImageUrl }}" 
                         alt="{{ $product->name }}" 
                         id="mainProductImage"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/500x500/667eea/FFFFFF?text={{ urlencode($product->name) }}'">
                </div>
                
                <!-- Thumbnails -->
                @php
                    $galleryImageUrls = $product->gallery_images_url;
                    if (empty($galleryImageUrls) || (count($galleryImageUrls) == 1 && str_contains($galleryImageUrls[0], 'placehold.co'))) {
                        $galleryImageUrls = [];
                        $productName = strtolower($product->name);
                        foreach ($imageMap as $key => $file) {
                            if (str_contains($productName, $key)) {
                                $galleryImageUrls[] = asset('storage/products/' . $file);
                                break;
                            }
                        }
                        if (empty($galleryImageUrls)) {
                            $galleryImageUrls[] = 'https://placehold.co/70x70/764ba2/FFFFFF?text=' . urlencode(substr($product->name, 0, 3));
                        }
                    }
                @endphp

                @if(count($galleryImageUrls) > 1)
                <div class="thumbnails mt-3 d-flex gap-2 overflow-auto pb-2">
                    @foreach($galleryImageUrls as $index => $imgUrl)
                        @if(!empty($imgUrl))
                        <img src="{{ $imgUrl }}" 
                             alt="Thumbnail {{ $index + 1 }}" 
                             class="thumbnail-img {{ $index == 0 ? 'active' : '' }}" 
                             style="width: 70px; height: 70px; flex-shrink: 0; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage('{{ $imgUrl }}', this)"
                             onerror="this.src='https://placehold.co/70x70/764ba2/FFFFFF?text={{ $index+1 }}'">
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
            <h1 class="fw-bold mb-2" style="font-size: 1.8rem;">{{ $product->name }}</h1>
            
            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <div class="rating-stars">
                        @php $rating = round($product->rating ?? 0); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $rating ? '' : 'empty' }}"></i>
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
                
                @if($product->is_new ?? false)
                    <span class="badge bg-primary rounded-pill px-3 py-2">New</span>
                @endif
                @if($product->featured)
                    <span class="badge bg-warning rounded-pill px-3 py-2 text-dark">Featured</span>
                @endif
            </div>

            <div class="mb-3">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted text-decoration-line-through fs-4">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        <span class="fs-2 fw-bold text-primary">
                            ${{ number_format($product->sale_price, 2) }}
                        </span>
                        @php
                            $discount = 0;
                            if ($product->price > 0) {
                                $discount = round((($product->price - $product->sale_price) / $product->price) * 100, 2);
                            }
                        @endphp
                        @if($discount > 0)
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            Save {{ $discount }}%
                        </span>
                        @endif
                    </div>
                @else
                    <span class="fs-2 fw-bold text-primary">
                        ${{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            @if($product->short_description)
                <div class="mb-3 p-3 bg-light rounded-3">
                    <p class="mb-0 text-muted">{{ $product->short_description }}</p>
                </div>
            @endif

            @if($product->description)
                <div class="mb-4">
                    <p class="text-secondary" style="line-height: 1.8;">
                        {!! nl2br(e($product->description)) !!}
                    </p>
                </div>
            @endif

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

            @if($product->stock > 0)
            <div class="d-flex flex-wrap gap-3 align-items-center mb-4 p-3 bg-light rounded-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold">Qty:</span>
                    <div class="quantity-selector d-flex align-items-center">
                        <button type="button" onclick="decreaseQty()" aria-label="Decrease quantity">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               aria-label="Quantity">
                        <button type="button" onclick="increaseQty()" aria-label="Increase quantity">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <button onclick="addToCart(event)" class="btn btn-primary-premium px-5 py-3 flex-grow-1" id="addToCartBtn">
                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                </button>
                
                <button onclick="toggleWishlist(event)" 
                        class="btn {{ ($inWishlist ?? false) ? 'btn-danger' : 'btn-outline-danger' }} btn-lg" 
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
     PRODUCT REVIEWS (COMPLETE)
============================================ -->
<div class="mt-5" id="reviewsSection">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">
            <i class="fas fa-star text-warning me-2"></i>
            Customer Reviews ({{ $totalReviews ?? 0 }})
        </h4>
        @auth
            @if(isset($canReview) && $canReview)
                <button class="btn btn-primary-premium" onclick="openReviewModal()">
                    <i class="fas fa-pen me-2"></i> Write a Review
                </button>
            @elseif(isset($canReview) && !$canReview && auth()->check())
                @php
                    $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->exists();
                @endphp
                @if($hasReviewed)
                    <button class="btn btn-outline-secondary" disabled>
                        <i class="fas fa-check me-2"></i> Already Reviewed
                    </button>
                @else
                    <button class="btn btn-outline-secondary" disabled>
                        <i class="fas fa-lock me-2"></i> Purchase to Review
                    </button>
                @endif
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary-premium">
                <i class="fas fa-sign-in-alt me-2"></i> Login to Review
            </a>
        @endauth
    </div>

    <!-- Review Statistics -->
    @if(($totalReviews ?? 0) > 0)
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-4">
                <h2 class="fw-bold text-primary" style="font-size: 3rem;">
                    {{ number_format($product->rating ?? 0, 1) }}
                </h2>
                <div class="rating-stars mb-2" style="font-size: 1.2rem;">
                    @php $rating = round($product->rating ?? 0); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $rating ? '' : 'empty' }}"></i>
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
    @endif

    <!-- Reviews List -->
    <div id="reviewsList">
        @if(isset($reviews) && $reviews->count() > 0)
            @foreach($reviews as $review)
            <div class="review-card mb-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center gap-2">
                        <div class="review-avatar" style="background: {{ '#667eea' }};">
                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                @if($review->is_verified)
                                    <span class="verified-badge">
                                        <i class="fas fa-check-circle"></i> Verified Purchase
                                    </span>
                                @endif
                            </div>
                            <div class="review-stars" style="font-size: 0.85rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'empty' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>

                @if($review->title)
                    <h6 class="mt-2 mb-1">{{ $review->title }}</h6>
                @endif
                <p class="text-muted mb-2">{{ $review->comment }}</p>

                @if($review->images && count($review->images) > 0)
                    <div class="d-flex gap-2 flex-wrap mb-2">
                        @foreach($review->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="Review image"
                                 class="review-image"
                                 onclick="window.open('{{ asset('storage/' . $image) }}', '_blank')">
                        @endforeach
                    </div>
                @endif

                <div class="d-flex gap-3 align-items-center">
                    <button onclick="markHelpful({{ $review->id }})" class="btn btn-sm btn-outline-secondary helpful-btn">
                        <i class="fas fa-thumbs-up"></i> Helpful ({{ $review->helpful_count ?? 0 }})
                    </button>
                    <button onclick="reportReview({{ $review->id }})" class="btn btn-sm btn-outline-danger helpful-btn">
                        <i class="fas fa-flag"></i> Report
                    </button>
                </div>
            </div>
            @endforeach
            
            @if(isset($reviews) && $reviews->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $reviews->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-4">
                <i class="fas fa-comment fa-3x text-muted mb-3 d-block"></i>
                <h5>No reviews yet</h5>
                <p class="text-muted">Be the first to review this product!</p>
                @auth
                    @if(isset($canReview) && $canReview)
                        <button class="btn btn-primary-premium" onclick="openReviewModal()">
                            <i class="fas fa-pen me-2"></i> Write a Review
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary-premium">
                        <i class="fas fa-sign-in-alt me-2"></i> Login to Review
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>

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
                        @php
                            $relatedImageUrl = $related->thumbnail_url;
                            if (str_contains($relatedImageUrl, 'placehold.co')) {
                                $imageMap = [
                                    'iphone' => 'iphone.jpg',
                                    'samsung' => 'samsung.jpg',
                                    'nike' => 'nike.jpg',
                                    'adidas' => 'adidas.jpg',
                                    'coffee' => 'coffee.jpg',
                                    'lamp' => 'lamp.jpg',
                                    'book' => 'book.jpg',
                                ];
                                $productName = strtolower($related->name);
                                foreach ($imageMap as $key => $file) {
                                    if (str_contains($productName, $key)) {
                                        $relatedImageUrl = asset('storage/products/' . $file);
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <img src="{{ $relatedImageUrl }}" 
                             alt="{{ $related->name }}" 
                             loading="lazy"
                             onerror="this.src='https://placehold.co/300x200/667eea/FFFFFF?text={{ urlencode($related->name) }}'">
                        @if($related->sale_price && $related->sale_price < $related->price)
                            @php
                                $discount = 0;
                                if ($related->price > 0) {
                                    $discount = round((($related->price - $related->sale_price) / $related->price) * 100);
                                }
                            @endphp
                            @if($discount > 0)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2 rounded-pill px-3 py-2">
                                -{{ $discount }}%
                            </span>
                            @endif
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="product-title">{{ $related->name }}</h6>
                        <div class="rating-stars small mb-1">
                            @php $relatedRating = round($related->rating ?? 0); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $relatedRating ? '' : 'empty' }}" style="font-size: 0.7rem;"></i>
                            @endfor
                        </div>
                        <div class="mt-auto">
                            <p class="fw-bold text-primary mb-2">
                                @if($related->sale_price && $related->sale_price < $related->price)
                                    <span class="text-muted text-decoration-line-through me-1 small">
                                        ${{ number_format($related->price, 2) }}
                                    </span>
                                @endif
                                ${{ number_format($related->sale_price && $related->sale_price < $related->price ? $related->sale_price : $related->price, 2) }}
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

<!-- ============================================
     REVIEW MODAL
============================================ -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-pen text-primary me-2"></i> Write a Review
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-0">
                <form id="reviewForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Rating -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                        <div class="star-rating d-flex gap-3" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-value="{{ $i }}" style="font-size: 2rem; color: #d1d5db; cursor: pointer; transition: all 0.2s;"></i>
                            @endfor
                        </div>
                        <small class="text-muted" id="ratingText">Select a rating</small>
                        <input type="hidden" name="rating" id="ratingInput" value="0" required>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Review Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Summarize your experience...">
                    </div>

                    <!-- Comment -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Review <span class="text-danger">*</span></label>
                        <textarea name="comment" class="form-control" rows="4" placeholder="Share your experience with this product..." required></textarea>
                    </div>

                    <!-- Images -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Add Photos</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">You can upload up to 5 images (Max 2MB each)</small>
                    </div>

                    <button type="submit" class="btn btn-primary-premium w-100 py-2" id="submitReviewBtn">
                        <i class="fas fa-paper-plane me-2"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ============================================
    // 1. QUANTITY CONTROLS
    // ============================================
    let qty = 1;
    const maxStock = {{ $product->stock ?? 0 }};
    const quantityInput = document.getElementById('quantity');

    function increaseQty() {
        if (quantityInput) {
            let val = parseInt(quantityInput.value) || 1;
            if (val < maxStock) {
                val++;
                quantityInput.value = val;
            }
        }
    }

    function decreaseQty() {
        if (quantityInput) {
            let val = parseInt(quantityInput.value) || 1;
            if (val > 1) {
                val--;
                quantityInput.value = val;
            }
        }
    }

    // ============================================
    // 2. ADD TO CART
    // ============================================
    function addToCart(event) {
        const productId = {{ $product->id }};
        const quantity = document.getElementById('quantity')?.value || 1;
        const btn = document.getElementById('addToCartBtn');
        
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
    function toggleWishlist(event) {
        const productId = {{ $product->id }};
        const btn = document.getElementById('wishlistBtn');
        const isInWishlist = btn.classList.contains('btn-danger');
        
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
        }
        
        const url = isInWishlist 
            ? '{{ route("wishlist.remove", ["id" => $product->id]) }}'
            : '{{ route("wishlist.add", ["productId" => $product->id]) }}';
        const method = isInWishlist ? 'DELETE' : 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added' || data.success) {
                btn.className = 'btn btn-danger btn-lg';
                btn.innerHTML = '<i class="fas fa-heart"></i>';
                showNotification('❤️ Added to wishlist!', 'success');
            } else if (data.status === 'removed' || data.success === false) {
                btn.className = 'btn btn-outline-danger btn-lg';
                btn.innerHTML = '<i class="fas fa-heart"></i>';
                showNotification('💔 Removed from wishlist!', 'info');
            } else {
                if (isInWishlist) {
                    btn.className = 'btn btn-outline-danger btn-lg';
                    btn.innerHTML = '<i class="fas fa-heart"></i>';
                } else {
                    btn.className = 'btn btn-danger btn-lg';
                    btn.innerHTML = '<i class="fas fa-heart"></i>';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('❌ Something went wrong!', 'error');
            if (isInWishlist) {
                btn.className = 'btn btn-danger btn-lg';
            } else {
                btn.className = 'btn btn-outline-danger btn-lg';
            }
            btn.innerHTML = '<i class="fas fa-heart"></i>';
        })
        .finally(() => {
            if (btn) btn.disabled = false;
        });
    }

    // ============================================
    // 4. CHANGE MAIN IMAGE
    // ============================================
    function changeMainImage(src, element) {
        const mainImg = document.getElementById('mainProductImage');
        if (mainImg) {
            mainImg.src = src;
        }
        document.querySelectorAll('.thumbnail-img').forEach(el => {
            el.classList.remove('active');
        });
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
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="font-size: 1.2rem;"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: white; opacity: 0.7; cursor: pointer; margin-left: auto; font-size: 1rem; padding: 4px;">
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
    // 7. STAR RATING (Review Modal)
    // ============================================
    let selectedRating = 0;
    const stars = document.querySelectorAll('#starRating i');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            selectedRating = value;
            ratingInput.value = value;
            updateStars(value);
            const labels = ['', 'Terrible', 'Poor', 'Average', 'Good', 'Excellent'];
            ratingText.textContent = labels[value] || 'Select a rating';
        });

        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            updateStars(value);
        });

        star.addEventListener('mouseleave', function() {
            updateStars(selectedRating);
        });
    });

    function updateStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.dataset.value);
            if (starValue <= value) {
                star.style.color = '#f59e0b';
                star.style.transform = 'scale(1.2)';
            } else {
                star.style.color = '#d1d5db';
                star.style.transform = 'scale(1)';
            }
        });
    }

    // ============================================
    // 8. SUBMIT REVIEW
    // ============================================
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submitReviewBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
        btn.disabled = true;

        const formData = new FormData(this);

        fetch('{{ route("customer.reviews.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✅ ' + data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showNotification('❌ ' + data.message, 'error');
                btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Review';
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('❌ Something went wrong!', 'error');
            btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Review';
            btn.disabled = false;
        });
    });

    // ============================================
    // 9. OPEN REVIEW MODAL
    // ============================================
    function openReviewModal() {
        const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
        modal.show();
    }

    // ============================================
    // 10. MARK HELPFUL
    // ============================================
    function markHelpful(reviewId) {
        fetch(`/customer/reviews/${reviewId}/helpful`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✅ Thanks for your feedback!', 'success');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // ============================================
    // 11. REPORT REVIEW
    // ============================================
    function reportReview(reviewId) {
        if (!confirm('Are you sure you want to report this review?')) return;

        fetch(`/customer/reviews/${reviewId}/report`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✅ Review reported!', 'success');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // ============================================
    // 12. INITIALIZE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
        
        const firstThumb = document.querySelector('.thumbnail-img');
        if (firstThumb) {
            firstThumb.classList.add('active');
        }
        
        if (quantityInput) {
            quantityInput.addEventListener('change', function() {
                let val = parseInt(this.value) || 1;
                if (val < 1) this.value = 1;
                if (val > maxStock) this.value = maxStock;
            });
        }
    });

    console.log('%c🛍️ EktaMart Product Details Page Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
    console.log('%c📦 Product: {{ $product->name }}', 'color: #764ba2; font-size: 12px;');
    console.log('%c⭐ Reviews: {{ $totalReviews ?? 0 }}', 'color: #f59e0b; font-size: 12px;');
</script>
@endsection