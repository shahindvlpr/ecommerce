@extends('layouts.app')

@section('title', 'Shopping Cart - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
        --radius-sm: 0.75rem;
    }

    .page-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    .cart-header h2 {
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .cart-header h2 i {
        color: #667eea;
    }
    .cart-header .item-count {
        background: white;
        padding: 0.3rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4b5563;
        box-shadow: var(--shadow-sm);
    }

    /* ============================================
       CART ITEMS
    ============================================ */
    .cart-item {
        background: white;
        border-radius: var(--radius);
        padding: 1rem 1.2rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
    }
    .cart-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }
    
    .cart-item .item-number {
        position: absolute;
        top: -0.5rem;
        left: -0.5rem;
        background: var(--primary-gradient);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .cart-item .product-image {
        width: 80px;
        height: 80px;
        border-radius: 0.5rem;
        overflow: hidden;
        flex-shrink: 0;
        background: #f3f4f6;
    }
    .cart-item .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cart-item .product-info {
        flex: 1;
        min-width: 0;
    }
    .cart-item .product-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: #1a1a2e;
        margin-bottom: 0.1rem;
    }
    .cart-item .product-price {
        color: #667eea;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .cart-item .product-meta {
        color: #6b7280;
        font-size: 0.7rem;
    }
    .cart-item .product-meta .badge-stock {
        padding: 0.1rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
    }
    .cart-item .product-meta .badge-stock.in-stock {
        background: #dcfce7;
        color: #16a34a;
    }
    .cart-item .product-meta .badge-stock.out-stock {
        background: #fee2e2;
        color: #dc2626;
    }

    .cart-item .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .cart-item .quantity-control button {
        background: transparent;
        border: none;
        padding: 0.3rem 0.6rem;
        cursor: pointer;
        color: #4b5563;
        transition: all 0.3s ease;
        font-size: 0.8rem;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-item .quantity-control button:hover {
        background: #f3f4f6;
    }
    .cart-item .quantity-control button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .cart-item .quantity-control .qty {
        min-width: 30px;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.2rem 0;
    }

    .cart-item .item-total {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1a1a2e;
        min-width: 80px;
        text-align: right;
    }
    .cart-item .remove-btn {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 0.5rem;
        padding: 0.3rem 0.6rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.8rem;
    }
    .cart-item .remove-btn:hover {
        background: #dc2626;
        color: white;
        transform: scale(1.05);
    }

    /* ============================================
       CART SUMMARY
    ============================================ */
    .cart-summary {
        background: white;
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        position: sticky;
        top: 1.5rem;
    }
    .cart-summary h5 {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f3f4f6;
    }
    .cart-summary .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.3rem 0;
        font-size: 0.85rem;
        color: #4b5563;
    }
    .cart-summary .summary-row .free-shipping {
        color: #16a34a;
        font-weight: 600;
    }
    .cart-summary .summary-row.total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a2e;
        border-top: 2px solid #f3f4f6;
        padding-top: 0.6rem;
        margin-top: 0.3rem;
    }
    .cart-summary .summary-row.total .amount {
        color: #667eea;
        font-size: 1.2rem;
    }

    /* Shipping Progress Bar */
    .shipping-progress {
        margin: 1rem 0;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 0.75rem;
    }
    .shipping-progress .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.3rem;
    }
    .shipping-progress .progress-bar-custom {
        height: 6px;
        background: #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
    }
    .shipping-progress .progress-bar-custom .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 1rem;
        transition: width 0.6s ease;
    }

    .btn-checkout {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0.75rem;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-continue-shopping {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .btn-continue-shopping:hover {
        color: #764ba2;
        transform: translateX(-3px);
    }

    /* ============================================
       EMPTY CART
    ============================================ */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }
    .empty-cart .icon {
        font-size: 4rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }
    .empty-cart .icon i {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .empty-cart h4 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.3rem;
    }
    .empty-cart p {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 768px) {
        .cart-item {
            flex-wrap: wrap;
            padding: 0.8rem 1rem;
        }
        .cart-item .product-image {
            width: 60px;
            height: 60px;
        }
        .cart-item .item-total {
            min-width: auto;
            text-align: left;
        }
        .cart-summary {
            position: static;
            margin-top: 1rem;
        }
    }

    @media (max-width: 576px) {
        .cart-item {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        .cart-item .product-image {
            margin: 0 auto;
        }
        .cart-item .quantity-control {
            justify-content: center;
        }
        .cart-item .item-total {
            text-align: center;
        }
        .cart-item .remove-btn {
            align-self: center;
        }
        .cart-item .item-number {
            top: -0.3rem;
            left: -0.3rem;
            width: 20px;
            height: 20px;
            font-size: 0.6rem;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="cart-header">
            <h2>
                <i class="fas fa-shopping-cart"></i> Shopping Cart
                <span class="item-count">
                    <i class="fas fa-box me-1"></i>
                    {{ isset($cartItems) ? $cartItems->count() : 0 }} Items
                </span>
            </h2>
            <a href="{{ route('shop.index') }}" class="btn-continue-shopping">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>

        @if(isset($cartItems) && $cartItems->count() > 0)
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    @php 
                        $subtotal = 0; 
                        $itemCount = 0; 
                        $shipping = 10; 
                        $tax = 0;
                    @endphp
                    
                    @foreach($cartItems as $item)
                        @php 
                            $itemTotal = $item->price * $item->quantity;
                            $subtotal += $itemTotal; 
                            $itemCount++;
                        @endphp
                        <div class="cart-item" id="cart-item-{{ $item->id }}">
                            <span class="item-number">{{ $itemCount }}</span>
                            
                            <div class="product-image">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ asset('storage/products/' . $item->product->thumbnail) }}" 
                                         alt="{{ $item->product->name }}"
                                         onerror="this.src='https://via.placeholder.com/80x80/8b5cf6/FFFFFF?text=Product'">
                                @elseif($item->product && $item->product->images && count($item->product->images) > 0)
                                    <img src="{{ asset('storage/products/' . $item->product->images[0]) }}" 
                                         alt="{{ $item->product->name }}"
                                         onerror="this.src='https://via.placeholder.com/80x80/8b5cf6/FFFFFF?text=Product'">
                                @else
                                    <img src="https://via.placeholder.com/80x80/8b5cf6/FFFFFF?text=Product" 
                                         alt="{{ $item->product->name ?? 'Product' }}">
                                @endif
                            </div>
                            
                            <div class="product-info">
                                <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                                <div class="product-price">${{ number_format($item->price, 2) }}</div>
                                <div class="product-meta">
                                    @if($item->product && $item->product->category)
                                        {{ $item->product->category->name }}
                                    @endif
                                    <span class="mx-1">•</span>
                                    <span class="badge-stock {{ ($item->product && $item->product->stock > 0) ? 'in-stock' : 'out-stock' }}">
                                        {{ ($item->product && $item->product->stock > 0) ? '✓ In Stock' : 'Out of Stock' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3">
                                <div class="quantity-control">
                                    <button onclick="updateCart({{ $item->id }}, -1)" 
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                            title="Decrease quantity">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="qty" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button onclick="updateCart({{ $item->id }}, 1)" 
                                            {{ ($item->product && $item->quantity >= $item->product->stock) ? 'disabled' : '' }}
                                            title="Increase quantity">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="item-total">
                                    ${{ number_format($itemTotal, 2) }}
                                </div>
                                <button onclick="removeFromCart({{ $item->id }})" class="remove-btn" title="Remove item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4">
                    @php
                        $freeShippingThreshold = 100;
                        $shippingProgress = min(($subtotal / $freeShippingThreshold) * 100, 100);
                        $remainingForFree = max($freeShippingThreshold - $subtotal, 0);
                        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : 10;
                        $tax = $subtotal * 0.05;
                        $total = $subtotal + $shipping + $tax;
                    @endphp
                    
                    <div class="cart-summary">
                        <h5>Order Summary</h5>
                        
                        <!-- Shipping Progress Bar -->
                        @if($remainingForFree > 0)
                        <div class="shipping-progress">
                            <div class="progress-label">
                                <span>Free Shipping</span>
                                <span>${{ number_format($remainingForFree, 2) }} more</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $shippingProgress }}%;"></div>
                            </div>
                        </div>
                        @else
                        <div class="shipping-progress" style="background: #dcfce7;">
                            <div class="progress-label">
                                <span style="color: #16a34a;">
                                    <i class="fas fa-truck me-1"></i> Free Shipping
                                </span>
                                <span style="color: #16a34a;">✓ Eligible</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: 100%;"></div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>
                                @if($subtotal >= $freeShippingThreshold)
                                    <span class="free-shipping"><i class="fas fa-check-circle me-1"></i> Free</span>
                                @else
                                    ${{ number_format($shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (5%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="amount">${{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Checkout Button -->
                        <div class="mt-3">
                            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                                <i class="fas fa-credit-card me-2"></i> Proceed to Checkout
                            </a>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ route('shop.index') }}" class="btn-continue-shopping">
                                <i class="fas fa-arrow-left me-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="empty-cart">
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h4>Your Cart is Empty</h4>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('shop.index') }}" class="btn" style="background: var(--primary-gradient); color: white; border: none; border-radius: 0.75rem; padding: 0.6rem 1.8rem; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                    <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    // ============================================================
    // 1. UPDATE CART
    // ============================================================
    function updateCart(itemId, change) {
        const qtyElement = document.getElementById('qty-' + itemId);
        const currentQty = parseInt(qtyElement.textContent);
        const newQty = currentQty + change;
        
        if (newQty < 1) return;
        
        const btn = document.querySelector(`#cart-item-${itemId} .quantity-control button:${change > 0 ? 'last-child' : 'first-child'}`);
        if (btn) btn.disabled = true;
        
        fetch('{{ route("cart.update", ["id" => "ITEM_ID"]) }}'.replace('ITEM_ID', itemId), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showNotification(data.message || 'Failed to update cart', 'error');
                if (btn) btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Something went wrong!', 'error');
            if (btn) btn.disabled = false;
        });
    }

    // ============================================================
    // 2. REMOVE FROM CART
    // ============================================================
    function removeFromCart(itemId) {
        if (!confirm('Are you sure you want to remove this item from cart?')) return;
        
        fetch('{{ route("cart.remove", ["id" => "ITEM_ID"]) }}'.replace('ITEM_ID', itemId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById('cart-item-' + itemId);
                if (item) {
                    item.style.transform = 'scale(0.9)';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            } else {
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Something went wrong!', 'error');
        });
    }

    // ============================================================
    // 3. NOTIFICATION
    // ============================================================
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

    // ============================================================
    // 4. UPDATE CART COUNT (Global)
    // ============================================================
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

    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });

    console.log('%c🛒 EktaMart Cart Page Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
</script>
@endsection