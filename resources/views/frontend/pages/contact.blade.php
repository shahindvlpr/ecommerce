@extends('layouts.app')

@section('title', 'Contact Us - EktaMart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-4">Contact <span style="color: #8b5cf6;">Us</span></h1>
            <p class="text-center text-muted mb-5">Have questions? We'd love to hear from you.</p>
            
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-premium w-100">
                            <i class="fas fa-paper-plane me-2"></i> Send Message
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="row text-center">
                        <div class="col-md-4">
                            <i class="fas fa-phone fa-2x text-purple-600"></i>
                            <p class="mt-2">+880 1234 567890</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-envelope fa-2x text-purple-600"></i>
                            <p class="mt-2">support@ektamart.com</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-map-marker-alt fa-2x text-purple-600"></i>
                            <p class="mt-2">Dhaka, Bangladesh</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection