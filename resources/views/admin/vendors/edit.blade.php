@extends('layouts.admin')

@section('title', 'Edit Vendor - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-store text-warning me-2"></i>Edit Vendor
            </h4>
            <p class="text-muted small">Update vendor information</p>
        </div>
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Vendors
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Basic Info -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone ?? '') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="status" class="form-check-input" 
                                       id="statusSwitch" value="1" 
                                       {{ old('status', $user->status) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="statusSwitch">
                                    <span id="statusLabel" class="badge {{ $user->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Vendor Specific Fields -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Description</label>
                            <textarea name="store_description" class="form-control @error('store_description') is-invalid @enderror" 
                                      rows="3" placeholder="Describe your store">{{ old('store_description', $user->store_description ?? '') }}</textarea>
                            @error('store_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                      rows="2" placeholder="Enter address">{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Leave empty to keep current password">
                            <small class="text-muted">Minimum 8 characters. Leave empty to keep current password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Vendor
                    </button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('statusSwitch')?.addEventListener('change', function() {
        const label = document.getElementById('statusLabel');
        if (this.checked) {
            label.textContent = 'Active';
            label.className = 'badge bg-success';
        } else {
            label.textContent = 'Inactive';
            label.className = 'badge bg-secondary';
        }
    });

    console.log('%c✏️ Edit Vendor Page Loaded', 'color: #f59e0b; font-size: 13px; font-weight: bold;');
</script>

<style>
    .form-check-input:checked {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
    }
</style>
@endsection