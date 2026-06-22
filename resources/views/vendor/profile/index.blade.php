@extends('vendor.layouts.app')

@section('title', 'Profile - Vendor Panel')
@section('page-title', 'Profile')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">My Profile</h5>
            <p class="text-muted small">Manage your account and shop information</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- Profile Card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center">
                <div class="card-body py-4">
                    <div class="position-relative d-inline-block">
                        @if($vendor->shop_logo)
                            <img src="{{ asset('storage/' . $vendor->shop_logo) }}" 
                                 alt="{{ $vendor->shop_name }}" 
                                 class="rounded-circle img-fluid" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 120px; height: 120px; font-size: 40px; color: white;">
                                {{ strtoupper(substr($vendor->shop_name ?? $vendor->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="mt-3 mb-0 fw-bold">{{ $vendor->shop_name ?? $vendor->name }}</h5>
                    <p class="text-muted small">{{ $vendor->email }}</p>
                    <span class="badge {{ $vendor->is_vendor_approved ? 'bg-success' : 'bg-warning' }}">
                        {{ $vendor->is_vendor_approved ? 'Approved' : 'Pending Approval' }}
                    </span>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="fw-bold">{{ $vendor->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">Joined</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold">{{ $vendor->commission_rate ?? 10 }}%</div>
                            <small class="text-muted">Commission Rate</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h6 class="fw-bold">Edit Profile</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $vendor->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $vendor->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Shop Name</label>
                                <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" 
                                       value="{{ old('shop_name', $vendor->shop_name) }}" required>
                                @error('shop_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Shop Phone</label>
                                <input type="text" name="shop_phone" class="form-control @error('shop_phone') is-invalid @enderror" 
                                       value="{{ old('shop_phone', $vendor->shop_phone) }}">
                                @error('shop_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Shop Address</label>
                                <textarea name="shop_address" class="form-control @error('shop_address') is-invalid @enderror" 
                                          rows="2">{{ old('shop_address', $vendor->shop_address) }}</textarea>
                                @error('shop_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Shop Description</label>
                                <textarea name="shop_description" class="form-control @error('shop_description') is-invalid @enderror" 
                                          rows="3">{{ old('shop_description', $vendor->shop_description) }}</textarea>
                                @error('shop_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Shop Logo</label>
                                <input type="file" name="shop_logo" class="form-control @error('shop_logo') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Max 2MB. Allowed: JPG, PNG</small>
                                @error('shop_logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Shop Banner</label>
                                <input type="file" name="shop_banner" class="form-control @error('shop_banner') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Max 5MB. Recommended: 1200x400</small>
                                @error('shop_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h6 class="fw-semibold mb-3">Bank Information</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" 
                                       value="{{ old('bank_name', $vendor->bank_name) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Account Holder Name</label>
                                <input type="text" name="bank_account_holder" class="form-control" 
                                       value="{{ old('bank_account_holder', $vendor->bank_account_holder) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Account Number</label>
                                <input type="text" name="bank_account_number" class="form-control" 
                                       value="{{ old('bank_account_number', $vendor->bank_account_number) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Routing Number</label>
                                <input type="text" name="bank_routing_number" class="form-control" 
                                       value="{{ old('bank_routing_number', $vendor->bank_routing_number) }}">
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h6 class="fw-bold">Change Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-key me-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection