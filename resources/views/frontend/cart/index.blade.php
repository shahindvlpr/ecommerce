@extends('layouts.app')

@section('title', 'Shopping Cart - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
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
    }
    .cart-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
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
    }
    .cart-item .quantity-control button:hover {
        background: #f3f4f6;
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

    /* Cart Summary */
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
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="cart-header">
            <h2>
                <i class="fas fa-shopping-cart"></i> Shopping Cart
                <span class="item-count">
                    <i class="fas fa-box me-1"></i>
                    {{ isset($cart) ? $cart->count() : 0 }} Items
                </span>
            </h2>
            <a href="{{ route('shop.index') }}" class="btn-continue-shopping">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>

        @if(isset($cart) && $cart->count() > 0)
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    @php $subtotal = 0; @endphp
                    @foreach($cart as $item)
                        @php $subtotal += $item->price * $item->quantity; @endphp
                        <div class="cart-item" id="cart-item-{{ $item->id }}">
                            <div class="product-image">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                                @else
                                    <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/80x80/8b5cf6/FFFFFF?text=Product' }}" alt="{{ $item->product->name ?? 'Product' }}">
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                                <div class="product-price">${{ number_format($item->price, 2) }}</div>
                                <div class="product-meta">
                                    @if($item->product->category)
                                        {{ $item->product->category->name }}
                                    @endif
                                    @if($item->product && $item->product->is_in_stock)
                                        <span class="text-success ms-2">✓ In Stock</span>
                                    @else
                                        <span class="text-danger ms-2">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="quantity-control">
                                    <button onclick="updateCart({{ $item->id }}, -1)" title="Decrease quantity">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="qty" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button onclick="updateCart({{ $item->id }}, 1)" title="Increase quantity">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="item-total">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
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
                    <div class="cart-summary">
                        <h5>Order Summary</h5>
                        
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>
                                @if($subtotal > 100)
                                    <span class="text-success">Free</span>
                                @else
                                    ${{ number_format($shipping ?? 10, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (5%)</span>
                            <span>${{ number_format($tax ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="amount">${{ number_format($total ?? 0, 2) }}</span>
                        </div>

                        <!-- ✅ Checkout Button - GET method -->
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
    function updateCart(itemId, change) {
        const qtyElement = document.getElementById('qty-' + itemId);
        const currentQty = parseInt(qtyElement.textContent);
        const newQty = currentQty + change;
        
        if (newQty < 1) return;
        
        fetch('/cart/update/' + itemId, {
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
                alert(data.message || 'Failed to update cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function removeFromCart(itemId) {
        if (!confirm('Are you sure you want to remove this item from cart?')) return;
        
        fetch('/cart/remove/' + itemId, {
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
                alert(data.message || 'Failed to remove item');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartCount');
                if (badge) {
                    badge.textContent = data.count || 0;
                    badge.style.display = data.count > 0 ? 'inline-block' : 'none';
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endsection