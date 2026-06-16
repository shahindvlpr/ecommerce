@extends('layouts.app')

@section('title', 'About Us - EktaMart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">About <span style="color: #8b5cf6;">EktaMart</span></h1>
            <p class="lead text-muted">We are a premium ecommerce platform dedicated to providing the best shopping experience.</p>
            <hr class="my-4">
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-shipping-fast fa-3x text-purple-600 mb-3"></i>
                            <h5>Fast Delivery</h5>
                            <p class="text-muted">Get your products delivered within 24-48 hours</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-3x text-purple-600 mb-3"></i>
                            <h5>Secure Payments</h5>
                            <p class="text-muted">Your transactions are 100% secure</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-headset fa-3x text-purple-600 mb-3"></i>
                            <h5>24/7 Support</h5>
                            <p class="text-muted">Our team is always ready to help you</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection