@extends('layouts.admin')

@section('title', 'Profile - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-user-cog text-primary me-2"></i>Profile Settings
            </h4>
            <p class="text-muted small">Manage your profile information</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Profile Card --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 rounded-4 text-center">
                <div class="card-body py-4">
                    <div class="position-relative d-inline-block">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/avatars/' . $admin->avatar) }}" 
                                 alt="{{ $admin->name }}" 
                                 class="rounded-circle img-fluid" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 120px; height: 120px; font-size: 40px; color: white;">
                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-white">
                            <span class="d-block" style="width: 12px; height: 12px;"></span>
                        </span>
                    </div>
                    <h5 class="mt-3 mb-0 fw-bold">{{ $admin->name }}</h5>
                    <p class="text-muted small">{{ $admin->email }}</p>
                    <span class="badge bg-primary">{{ ucfirst($admin->role) }}</span>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="fw-bold">{{ $admin->created_at->format('d M') }}</div>
                            <small class="text-muted">Joined</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold">{{ \App\Models\Notification::where('user_id', $admin->id)->count() }}</div>
                            <small class="text-muted">Notifications</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold">{{ $admin->updated_at->diffForHumans() }}</div>
                            <small class="text-muted">Last Active</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="card-title fw-bold">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Profile
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $admin->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $admin->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $admin->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="avatar" class="form-label fw-semibold">Profile Picture</label>
                                <input type="file" 
                                       class="form-control @error('avatar') is-invalid @enderror" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max 2MB. Allowed: JPG, PNG, GIF</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label fw-semibold">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" 
                                      name="bio" 
                                      rows="3">{{ old('bio', $admin->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password Card --}}
            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="card-title fw-bold">
                        <i class="fas fa-lock text-danger me-2"></i>Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label fw-semibold">Current Password</label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label fw-semibold">New Password</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-key me-1"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview avatar before upload
    document.getElementById('avatar')?.addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.querySelector('.rounded-circle');
            if (preview && preview.tagName === 'IMG') {
                preview.src = event.target.result;
            }
        };
        if (this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush