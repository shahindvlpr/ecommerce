@extends('layouts.app')

@section('title', 'Shop - EktaMart')

@section('content')
<style>
.shop-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:12px}
.product-card{background:#fff;border:0.5px solid #e5e7eb;border-radius:12px;overflow:hidden;transition:all .25s;height:100%}
.product-card:hover{border-color:#b0a8f0;box-shadow:0 4px 20px rgba(83,74,183,.08)}
.product-image{position:relative;overflow:hidden;height:200px;background:#f8f9fa}
.product-image img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
.product-card:hover .product-image img{transform:scale(1.04)}
.badge-sale{position:absolute;top:8px;left:8px;background:#dc2626;color:#fff;font-size:11px;padding:3px 8px;border-radius:20px;font-weight:600}
.badge-new{position:absolute;top:8px;left:8px;background:#059669;color:#fff;font-size:11px;padding:3px 8px;border-radius:20px;font-weight:600}
.wishlist-overlay{position:absolute;bottom:8px;right:8px;width:32px;height:32px;background:#fff;border:0.5px solid #e5e7eb;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;opacity:0;transition:opacity .2s}
.product-card:hover .wishlist-overlay{opacity:1}
.card-body{padding:12px}
.card-category{font-size:11px;color:#6b7280;margin-bottom:3px}
.card-title{font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:6px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.4rem}
.stars{color:#f59e0b;font-size:11px;margin-bottom:8px}
.stars .empty{color:#d1d5db}
.price-main{font-size:16px;font-weight:700;color:#4f46e5}
.price-old{font-size:12px;color:#9ca3af;text-decoration:line-through;margin-left:4px}
.btn-cart-sm{background:linear-gradient(135deg,#667eea,#764ba2);border:none;border-radius:8px;color:#fff;padding:7px 10px;cursor:pointer;font-size:12px}
.btn-view-sm{border:1px solid #e5e7eb;border-radius:8px;background:#fff;color:#374151;padding:7px 12px;cursor:pointer;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
.btn-view-sm:hover{background:#f9fafb}
.sidebar-card{background:#fff;border:0.5px solid #e5e7eb;border-radius:12px;padding:1.25rem}
.sidebar-label{font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.75rem}
.cat-link{display:flex;align-items:center;justify-content:space-between;padding:6px 8px;border-radius:8px;font-size:13px;color:#374151;text-decoration:none;margin-bottom:2px}
.cat-link:hover,.cat-link.active{background:#eef2ff;color:#4f46e5}
.stock-low{font-size:11px;color:#d97706;background:#fef3c7;padding:2px 7px;border-radius:20px;display:inline-block;margin-bottom:6px}
</style>

<div class="container py-4">
    <div class="row g-4">

        {{-- SIDEBAR --}}
        <div class="col-lg-3">
            <div class="sidebar-card mb-3">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search products...">
                </div>

                <div class="sidebar-label">Categories</div>
                <a href="{{ route('shop.index') }}" class="cat-link active">
                    All Products <span class="badge bg-light text-muted">{{ $products->total() }}</span>
                </a>
                @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="cat-link">
                    {{ $category->name }}
                    <span class="badge bg-light text-muted">{{ $category->products_count ?? 0 }}</span>
                </a>
                @endforeach
            </div>

            <div class="sidebar-card mb-3">
                <div class="sidebar-label">Price Range</div>
                <div class="d-flex justify-content-between small text-muted mb-2">
                    <span>$0</span><span id="priceVal">$1000</span>
                </div>
                <input type="range" class="form-range" min="0" max="10000" value="1000" 
                       oninput="document.getElementById('priceVal').textContent='$'+this.value">
                <button class="btn btn-sm w-100 mt-2" 
                        style="background:#534AB7;color:#fff;border-radius:8px">Apply Filter</button>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-label">Brands</div>
                @foreach($brands ?? [] as $brand)
                <label class="d-flex align-items-center gap-2 mb-2" style="font-size:13px;cursor:pointer">
                    <input type="checkbox" style="accent-color:#534AB7"> {{ $brand->name }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- PRODUCTS --}}
        <div class="col-lg-9">
            <div class="shop-header">
                <div>
                    <h5 class="fw-bold mb-0">All Products</h5>
                    <small class="text-muted">{{ $products->total() }} products found</small>
                </div>
                <select class="form-select form-select-sm" style="width:auto">
                    <option>Sort: Featured</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest First</option>
                    <option>Best Rating</option>
                </select>
            </div>

            <div class="row g-3">
                @forelse($products as $product)
                @php
                    $productImages = $product->images ?? [];
                    $imgUrl = !empty($productImages)
                        ? asset('storage/products/' . $productImages[0])
                        : 'https://placehold.co/300x300/667eea/FFFFFF?text=' . urlencode($product->name);
                @endphp
                <div class="col-md-4 col-sm-6">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $imgUrl }}"
                                 alt="{{ $product->name }}"
                                 loading="lazy"
                                 onerror="this.src='https://placehold.co/300x300/667eea/FFFFFF?text={{ urlencode($product->name) }}'">

                            @if($product->is_on_sale)
                                <span class="badge-sale">-{{ $product->discount_percentage }}%</span>
                            @elseif($product->is_new ?? false)
                                <span class="badge-new">New</span>
                            @endif

                            <button class="wishlist-overlay" onclick="addToWishlist({{ $product->id }})"
                                    aria-label="Add to wishlist">
                                <i class="fas fa-heart" style="font-size:13px;color:#6b7280"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="card-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                            <div class="card-title">{{ $product->name }}</div>

                            <div class="stars mb-2">
                                @php $r = round($product->rating ?? 0); @endphp
                                @for($i=1;$i<=5;$i++)
                                    <i class="fas fa-star {{ $i<=$r ? '' : 'empty' }}"></i>
                                @endfor
                                <span class="text-muted ms-1" style="font-size:11px">({{ $product->reviews_count ?? 0 }})</span>
                            </div>

                            @if($product->stock > 0 && $product->stock <= 5)
                                <div class="stock-low">Only {{ $product->stock }} left!</div>
                            @endif

                            <div class="d-flex align-items-baseline mb-2">
                                <span class="price-main">
                                    ${{ number_format($product->sale_price ?? $product->price, 2) }}
                                </span>
                                @if($product->is_on_sale)
                                    <span class="price-old">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn-view-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button onclick="addToCart({{ $product->id }})" class="btn-cart-sm"
                                        data-product-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3 d-block"></i>
                    <h5>No Products Found</h5>
                    <p class="text-muted">Try adjusting your filters</p>
                </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

{{-- TOAST --}}
<div id="toast" style="display:none;position:fixed;bottom:24px;right:24px;background:#534AB7;color:#fff;padding:12px 20px;border-radius:10px;font-size:13px;z-index:9999;align-items:center;gap:10px">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg"></span>
</div>

<script>
function addToCart(productId) {
    const btn = event.target.closest('button');
    const original = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.disabled = true;

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: JSON.stringify({product_id: productId, quantity: 1})
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Added to cart!');
            updateCartCount();
        } else {
            showToast(data.message || 'Failed!');
        }
    })
    .catch(() => showToast('Something went wrong!'))
    .finally(() => { btn.innerHTML = original; btn.disabled = false; });
}

function addToWishlist(productId) {
    fetch('/customer/wishlist/add/' + productId, {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    })
    .then(r => r.json())
    .then(data => showToast(data.message || 'Added to wishlist!'))
    .catch(() => showToast('Failed!'));
}

function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('cartCount');
            if (badge) { badge.textContent = data.count || 0; badge.style.display = data.count > 0 ? 'inline-block' : 'none'; }
        });
}

function showToast(msg) {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.style.display = 'flex';
    setTimeout(() => t.style.display = 'none', 2500);
}

document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
@endsection