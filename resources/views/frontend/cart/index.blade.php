@extends('layouts.app')

@section('title', 'Shopping Cart - EktaMart')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-shopping-cart" style="color: #667eea;"></i> Shopping Cart
    </h2>

    @if($cart && $cart->count() > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                        <div class="cart-item d-flex align-items-center gap-3 py-3 border-bottom">
                            <div class="product-image" style="width: 80px; height: 80px; overflow: hidden; border-radius: 0.5rem;">
                                <img src="{{ $item->product->image_url }}" 
                                     alt="{{ $item->product->name }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0">{{ $item->product->name }}</h6>
                                <p class="text-muted small">${{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="quantity-selector d-flex align-items-center border rounded-3">
                                    <button class="btn btn-sm btn-outline-secondary border-0" onclick="updateCart({{ $item->id }}, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="px-3">{{ $item->quantity }}</span>
                                    <button class="btn btn-sm btn-outline-secondary border-0" onclick="updateCart({{ $item->id }}, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <span class="fw-bold text-primary">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                <button onclick="removeFromCart({{ $item->id }})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @php $total += $item->price * $item->quantity; @endphp
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Order Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax</span>
                            <span>${{ number_format($tax ?? 0, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary fs-5">${{ number_format($total + ($shipping ?? 0) + ($tax ?? 0), 2) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-primary-premium w-100 py-2">
                            <i class="fas fa-credit-card me-2"></i> Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h4>Your cart is empty</h4>
            <p class="text-muted">Start shopping to add items to your cart</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary-premium">
                <i class="fas fa-shopping-bag me-2"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
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
    .cart-item {
        transition: all 0.3s ease;
    }
    .cart-item:hover {
        background: #f8f9fa;
        border-radius: 0.5rem;
    }
</style>

<script>
    function updateCart(itemId, change) {
        fetch('{{ route("cart.update") }}/' + itemId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                change: change
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function removeFromCart(itemId) {
        if(confirm('Are you sure you want to remove this item?')) {
            fetch('{{ route("cart.remove") }}/' + itemId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
@endsection