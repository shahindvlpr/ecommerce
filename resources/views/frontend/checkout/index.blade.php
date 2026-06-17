@extends('layouts.app')

@section('title', 'Checkout - EktaMart')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-credit-card" style="color: #667eea;"></i> Checkout
    </h2>

    <div class="row g-4">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf

                <!-- Shipping Address -->
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> Shipping Address
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Address</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ Auth::user()->address ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">City</label>
                                <input type="text" name="city" class="form-control" value="{{ Auth::user()->city ?? '' }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">State</label>
                                <input type="text" name="state" class="form-control" value="{{ Auth::user()->state ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ Auth::user()->postal_code ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-credit-card" style="color: #667eea;"></i> Payment Method
                        </h5>
                        <div class="d-flex gap-3">
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="cod" id="cod" checked>
                                <label for="cod" class="payment-label">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                    <span>Cash on Delivery</span>
                                </label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="bkash" id="bkash">
                                <label for="bkash" class="payment-label">
                                    <i class="fas fa-mobile-alt fa-2x"></i>
                                    <span>bKash</span>
                                </label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" name="payment_method" value="nagad" id="nagad">
                                <label for="nagad" class="payment-label">
                                    <i class="fas fa-mobile-alt fa-2x"></i>
                                    <span>Nagad</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-premium w-100 py-3 mt-3">
                    <i class="fas fa-check-circle me-2"></i> Place Order
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                    @php $total += $item->price * $item->quantity; @endphp
                    @endforeach
                    
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>${{ number_format(($shipping ?? 0), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>${{ number_format(($tax ?? 0), 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-primary fs-5">${{ number_format($total + ($shipping ?? 0) + ($tax ?? 0), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    .payment-option {
        flex: 1;
    }
    .payment-option input[type="radio"] {
        display: none;
    }
    .payment-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem;
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
    }
    .payment-label span {
        margin-top: 0.3rem;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>
@endsection