@extends('layouts.app')

@section('title', 'Shop - EktaMart')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('shop.category', $category->slug) }}" 
                               class="text-decoration-none text-dark">
                                {{ $category->name }}
                                <span class="badge bg-light text-muted">{{ $category->products_count ?? 0 }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <hr>
                    
                    <h5 class="fw-bold mb-3">Price Range</h5>
                    <div class="mb-3">
                        <input type="range" class="form-range" min="0" max="1000" step="10">
                    </div>
                    
                    <button class="btn btn-primary-premium w-100">Apply Filters</button>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-md-4 col-sm-6">
                    <div class="card product-card shadow-sm border-0 rounded-4">
                        <div class="product-image">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="card-img-top">
                            @if($product->is_on_sale)
                                <span class="sale-badge">-{{ $product->discount_percentage }}%</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="product-title">{{ $product->name }}</h6>
                            <p class="product-category text-muted small">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </p>
                            <div class="product-price">
                                @if($product->is_on_sale)
                                    <span class="text-muted text-decoration-line-through me-2">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="fw-bold text-primary">
                                        ${{ number_format($product->sale_price, 2) }}
                                    </span>
                                @else
                                    <span class="fw-bold text-primary">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <!-- Add to Cart Button -->
<button onclick="addToCart({{ $product->id }})" 
        class="btn btn-primary-premium btn-sm add-to-cart-btn"
        data-product-id="{{ $product->id }}">
    <i class="fas fa-shopping-cart"></i>
</button>

<!-- Wishlist Button -->
<button onclick="addToWishlist({{ $product->id }})" 
        class="btn btn-outline-danger btn-sm wishlist-btn"
        data-product-id="{{ $product->id }}">
    <i class="fas fa-heart"></i>
</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4>No Products Found</h4>
                </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .product-image {
        position: relative;
        overflow: hidden;
        height: 200px;
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
    .sale-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ef4444;
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.5rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        color: white;
    }
</style>

<script>
// ============================================
// 1. ADD TO CART FUNCTION
// ============================================
function addToCart(productId) {
    // Get the button that was clicked
    const button = event ? event.target.closest('button') : document.querySelector(`button[onclick*="addToCart(${productId})"]`);
    
    if (!button) {
        console.error('Button not found');
        return;
    }
    
    const originalText = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product added to cart successfully! 🛒', 'success');
            updateCartCount();
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Something went wrong! Please try again.', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// ============================================
// 2. ADD TO WISHLIST FUNCTION
// ============================================
function addToWishlist(productId) {
    // Get the button that was clicked
    const button = event ? event.target.closest('button') : document.querySelector(`button[onclick*="addToWishlist(${productId})"]`);
    
    if (button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
    }
    
    fetch('/customer/wishlist/add/' + productId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        showNotification(data.message || 'Product added to wishlist! ❤️', 'success');
        if (button) {
            button.innerHTML = '<i class="fas fa-heart" style="color: #ef4444;"></i>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to add to wishlist', 'error');
        if (button) {
            button.innerHTML = '<i class="fas fa-heart"></i>';
        }
    })
    .finally(() => {
        if (button) {
            button.disabled = false;
        }
    });
}

// ============================================
// 3. UPDATE CART COUNT FUNCTION
// ============================================
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartCount');
            if (badge) {
                const count = data.count || 0;
                badge.textContent = count;
                if (count > 0) {
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

// ============================================
// 4. NOTIFICATION FUNCTION
// ============================================
function showNotification(message, type = 'success') {
    // Remove existing notification
    const existing = document.querySelector('.custom-notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    
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
    
    const bgColor = colors[type] || colors.success;
    const icon = icons[type] || icons.success;
    
    notification.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: ${bgColor};
        color: white;
        padding: 14px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        z-index: 9999;
        font-weight: 500;
        font-size: 0.95rem;
        animation: slideInRight 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
    `;
    
    notification.innerHTML = `
        <i class="fas fa-${icon}" style="font-size: 1.2rem;"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="
            background: transparent;
            border: none;
            color: white;
            opacity: 0.7;
            cursor: pointer;
            margin-left: auto;
            font-size: 1rem;
        ">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 4000);
}

// ============================================
// 5. TOGGLE WISHLIST (for product detail page)
// ============================================
function toggleWishlist(productId) {
    const btn = document.getElementById('wishlistBtn');
    if (!btn) return;
    
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.disabled = true;
    
    fetch('/customer/wishlist/toggle/' + productId, {
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
            showNotification('Added to wishlist! ❤️', 'success');
        } else if (data.status === 'removed') {
            btn.className = 'btn btn-outline-danger btn-lg';
            btn.innerHTML = '<i class="fas fa-heart"></i>';
            showNotification('Removed from wishlist!', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Something went wrong!', 'error');
        btn.innerHTML = originalHtml;
    })
    .finally(() => {
        btn.disabled = false;
    });
}

// ============================================
// 6. INITIALIZE ON PAGE LOAD
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Update cart count on page load
    updateCartCount();
    
    // Add click event listeners to all add-to-cart buttons (if using class)
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            if (productId) {
                addToCart(productId);
            }
        });
    });
    
    // Add click event listeners to all wishlist buttons (if using class)
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            if (productId) {
                addToWishlist(productId);
            }
        });
    });
});

console.log('%c🛒 EktaMart Cart System Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
</script>
@endsection