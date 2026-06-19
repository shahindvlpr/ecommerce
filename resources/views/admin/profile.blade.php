@extends('layouts.admin')

@section('title', 'Admin Profile - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-user-circle text-primary me-2"></i>My Profile
        </h4>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Profile Card --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 text-center">
                <div class="card-body py-4">
                    <div class="position-relative d-inline-block">
                        <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 120px; height: 120px; font-size: 3rem; font-weight: 700; color: white; background: linear-gradient(135deg, #8b5cf6, #6366f1);">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-white">
                            <i class="fas fa-check-circle text-white" style="font-size: 0.7rem;"></i>
                        </span>
                    </div>
                    
                    <h5 class="mt-3 fw-bold">{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            <i class="fas fa-shield-alt me-1"></i> {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                        </span>
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Active
                        </span>
                        <span class="badge bg-info rounded-pill px-3 py-2">
                            <i class="fas fa-calendar-alt me-1"></i> Joined {{ Auth::user()->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <hr>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3">
                                <h6 class="mb-0 text-muted small">Total Orders</h6>
                                <span class="fw-bold">{{ \App\Models\Order::count() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3">
                                <h6 class="mb-0 text-muted small">Total Users</h6>
                                <span class="fw-bold">{{ \App\Models\User::count() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3">
                                <h6 class="mb-0 text-muted small">Total Products</h6>
                                <span class="fw-bold">{{ \App\Models\Product::count() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3">
                                <h6 class="mb-0 text-muted small">Total Revenue</h6>
                                <span class="fw-bold">${{ number_format(\App\Models\Order::sum('total') ?? 0, 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Account Information</h6>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">User ID</span>
                        <span class="fw-semibold">#{{ Auth::user()->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Username</span>
                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Email</span>
                        <span class="fw-semibold">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Role</span>
                        <span class="fw-semibold">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Joined</span>
                        <span class="fw-semibold">{{ Auth::user()->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Form --}}
        <div class="col-lg-8">
            {{-- Update Profile --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">
                        <i class="fas fa-user-edit text-primary me-2"></i>Update Profile Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                              rows="2" placeholder="Enter address">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">
                        <i class="fas fa-key text-primary me-2"></i>Change Password
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" 
                                           placeholder="Enter current password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter new password" required>
                                    <small class="text-muted">Minimum 8 characters</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                           placeholder="Confirm new password" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
}
</style>
@endsection