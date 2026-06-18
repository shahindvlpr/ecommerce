@extends('layouts.app')

@section('title', 'Checkout - EktaMart')

@section('content')
<style>
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        color: white;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .payment-option {
        flex: 1;
        min-width: 100px;
    }
    .payment-option input[type="radio"] {
        display: none;
    }
    .payment-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem 0.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    .payment-option input[type="radio"]:checked + .payment-label {
        border-color: #667eea;
        background: #f5f3ff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .payment-label:hover {
        border-color: #667eea;
        transform: translateY(-2px);
    }
    .payment-label i {
        color: #667eea;
        font-size: 1.8rem;
    }
    .payment-label span {
        margin-top: 0.3rem;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .checkout-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    .checkout-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.4rem 0;
        font-size: 0.9rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .summary-item:last-child {
        border-bottom: none;
    }
    .summary-total {
        font-size: 1.1rem;
        font-weight: 700;
        padding-top: 0.8rem;
        border-top: 2px solid #e5e7eb;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
    }
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
    }
</style>

<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="fas fa-credit-card" style="color: #667eea;"></i> Checkout
        </h2>
        <span class="badge bg-light text-dark ms-3 px-3 py-2">
            {{ $cart->count() }} Items
        </span>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- ============================================
             CHECKOUT FORM
        ============================================ -->
        <div class="col-lg-8">
            <form method="POST" action="{{ route('checkout.process') }}" id="checkoutForm">
                @csrf

                <!-- Shipping Address -->
                <div class="card checkout-card mb-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> Shipping Address
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $user->phone ?? '') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="2" required>{{ old('address', $user->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $user->city ?? '') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                                       value="{{ old('state', $user->state ?? '') }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code', $user->postal_code ?? '') }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" 
                                       value="{{ old('country', $user->country ?? 'Bangladesh') }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Order Notes</label>
                                <textarea name="notes" class="form-control" rows="2" 
                                          placeholder="Any special instructions?">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card checkout-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-credit-card" style="color: #667eea;"></i> Payment Method <span class="text-danger">*</span>
                        </h5>
                        
                        <div class="d-flex flex-wrap gap-3">
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="cod" id="cod" checked>
                                <label for="cod" class="payment-label">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>Cash on Delivery</span>
                                </label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="bkash" id="bkash">
                                <label for="bkash" class="payment-label">
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>bKash</span>
                                </label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="nagad" id="nagad">
                                <label for="nagad" class="payment-label">
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>Nagad</span>
                                </label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="sslcommerz" id="sslcommerz">
                                <label for="sslcommerz" class="payment-label">
                                    <i class="fas fa-credit-card"></i>
                                    <span>SSLCommerz</span>
                                </label>
                            </div>
                        </div>
                        @error('payment_method')
                            <div class="text-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-premium w-100 py-3 mt-3" id="placeOrderBtn">
                    <i class="fas fa-check-circle me-2"></i> Place Order
                </button>
            </form>
        </div>

        <!-- ============================================
             ORDER SUMMARY
        ============================================ -->
        <div class="col-lg-4">
            <div class="card checkout-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    
                    @php 
                        $subtotal = 0; 
                        $itemCount = 0;
                    @endphp
                    
                    @foreach($cart as $item)
                        @php 
                            $itemTotal = $item->price * $item->quantity;
                            $subtotal += $itemTotal;
                            $itemCount++;
                        @endphp
                        <div class="summary-item">
                            <span>
                                {{ $item->product->name ?? 'Product' }} 
                                <span class="text-muted">× {{ $item->quantity }}</span>
                            </span>
                            <span class="fw-bold">${{ number_format($itemTotal, 2) }}</span>
                        </div>
                    @endforeach
                    
                    <div class="summary-item mt-2">
                        <span>Subtotal ({{ $itemCount }} items)</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>
                            @if($shipping > 0)
                                ${{ number_format($shipping, 2) }}
                            @else
                                <span class="text-success">Free</span>
                            @endif
                        </span>
                    </div>
                    <div class="summary-item">
                        <span>Tax (5%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="summary-total d-flex justify-content-between">
                        <span>Total</span>
                        <span class="text-primary" style="font-size: 1.3rem;">${{ number_format($total, 2) }}</span>
                    </div>

                    <hr>
                    <div class="text-center">
                        <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted">
                            <i class="fas fa-arrow-left me-1"></i> Return to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('placeOrderBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
        btn.disabled = true;
    });
</script>
@endsection