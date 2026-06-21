@extends('layouts.admin')

@section('title', 'Profile - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-primary bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-user-cog text-primary"></i>
                </span>
                Profile Settings
            </h4>
            <p class="text-muted small mb-0">Manage your profile information and account settings</p>
        </div>
        <div class="d-flex gap-2">
            {{-- Edit Mode Toggle Button --}}
            <button class="btn btn-warning btn-sm px-3" id="editModeToggle" onclick="toggleEditMode()">
                <i class="fas fa-lock me-1" id="editModeIcon"></i>
                <span id="editModeText">Edit Mode</span>
            </button>
            <button class="btn btn-outline-secondary btn-sm px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm px-3">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </div>

    {{-- Edit Mode Status Alert --}}
    <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm rounded-3" id="editModeAlert" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-info-circle fs-5"></i>
            <span id="editModeMessage">🔒 Profile is in <strong>View Mode</strong>. Click the <strong>"Edit Mode"</strong> button to make changes.</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    {{-- ============================================================ --}}
    {{-- ALERT MESSAGES --}}
    {{-- ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle text-success fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle text-danger fs-5"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-times-circle text-danger fs-5 mt-1"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- ============================================================ --}}
        {{-- PROFILE CARD --}}
        {{-- ============================================================ --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Cover Image --}}
                <div class="position-relative" style="height: 120px; background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.4), rgba(124, 58, 237, 0.4));"></div>
                    
                    {{-- Edit Mode Badge on Profile Card --}}
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill" id="profileCardBadge" style="display: none;">
                            <i class="fas fa-edit me-1"></i> Editing
                        </span>
                    </div>
                </div>

                {{-- Profile Info --}}
                <div class="card-body text-center" style="margin-top: -60px;">
                    {{-- Avatar --}}
                    <div class="position-relative d-inline-block">
                        <div class="avatar-wrapper position-relative" style="width: 120px; height: 120px;">
                            @if($admin->avatar)
                                <img src="{{ asset('storage/avatars/' . $admin->avatar) }}" 
                                     alt="{{ $admin->name }}" 
                                     class="rounded-circle img-fluid border border-4 border-white shadow-sm"
                                     style="width: 120px; height: 120px; object-fit: cover; background: #f8f9fa;"
                                     id="avatarPreview">
                            @else
                                <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mx-auto border border-4 border-white shadow-sm"
                                     style="width: 120px; height: 120px; font-size: 48px; color: white; background: linear-gradient(135deg, #4f46e5, #7c3aed);"
                                     id="avatarPreview">
                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
                                <span class="d-block" style="width: 14px; height: 14px;"></span>
                            </span>
                        </div>
                    </div>

                    {{-- Name & Role --}}
                    <h5 class="mt-3 mb-1 fw-bold">{{ $admin->name }}</h5>
                    <p class="text-muted small mb-2">{{ $admin->email }}</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-user-shield me-1"></i> {{ ucfirst($admin->role) }}
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Active
                        </span>
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                            <i class="fas fa-calendar me-1"></i> {{ $admin->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    {{-- Stats --}}
                    <div class="row g-0 pt-3 border-top">
                        <div class="col-4">
                            <div class="fw-bold h5 mb-0">{{ $admin->created_at->format('d M') }}</div>
                            <small class="text-muted">Joined</small>
                        </div>
                        <div class="col-4 border-start">
                            <div class="fw-bold h5 mb-0">{{ \App\Models\Notification::where('user_id', $admin->id)->count() }}</div>
                            <small class="text-muted">Notifications</small>
                        </div>
                        <div class="col-4 border-start">
                            <div class="fw-bold h5 mb-0">{{ $admin->updated_at->diffForHumans() }}</div>
                            <small class="text-muted">Last Active</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary btn-sm flex-fill" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print Profile
                        </button>
                        <button class="btn btn-outline-success btn-sm flex-fill" onclick="exportProfile()">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <button class="btn btn-outline-danger btn-sm flex-fill" onclick="if(confirm('Are you sure?')) logout()">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- EDIT PROFILE FORM --}}
        {{-- ============================================================ --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-edit text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Edit Profile</h6>
                            <p class="text-muted small mb-0">Update your personal information and preferences</p>
                        </div>
                        <span class="ms-auto badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill" id="modeStatusBadge">
                            <i class="fas fa-eye me-1"></i> View Mode
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        {{-- Personal Information --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-user-circle text-primary me-2"></i>Personal Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               placeholder="Full Name"
                                               value="{{ old('name', $admin->name) }}" 
                                               required
                                               disabled>
                                        <label for="name">
                                            <i class="fas fa-user text-muted me-2"></i>Full Name
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               placeholder="Email Address"
                                               value="{{ old('email', $admin->email) }}" 
                                               required
                                               disabled>
                                        <label for="email">
                                            <i class="fas fa-envelope text-muted me-2"></i>Email Address
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               placeholder="Phone Number"
                                               value="{{ old('phone', $admin->phone) }}"
                                               disabled>
                                        <label for="phone">
                                            <i class="fas fa-phone text-muted me-2"></i>Phone Number
                                        </label>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="file" 
                                               name="avatar" 
                                               class="form-control @error('avatar') is-invalid @enderror" 
                                               id="avatar" 
                                               placeholder="Profile Picture"
                                               accept="image/*"
                                               disabled>
                                        <label for="avatar">
                                            <i class="fas fa-image text-muted me-2"></i>Profile Picture
                                        </label>
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Max 2MB. Allowed: JPG, PNG, GIF
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Bio --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-align-left text-primary me-2"></i>About You
                            </h6>
                            <div class="form-floating">
                                <textarea name="bio" 
                                          class="form-control @error('bio') is-invalid @enderror" 
                                          id="bio" 
                                          placeholder="Tell us about yourself" 
                                          rows="4" 
                                          style="height: 120px;"
                                          disabled>{{ old('bio', $admin->bio) }}</textarea>
                                <label for="bio">
                                    <i class="fas fa-pen text-muted me-2"></i>Bio
                                </label>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end mt-1">
                                <small class="text-muted" id="bioCounter">0/500</small>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4" id="saveButton" disabled>
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4" id="resetButton" disabled>
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <span class="text-muted small d-flex align-items-center ms-auto" id="editHint">
                                <i class="fas fa-lock me-1"></i> Click "Edit Mode" to enable editing
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- CHANGE PASSWORD CARD --}}
            {{-- ============================================================ --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-lock text-danger fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Change Password</h6>
                            <p class="text-muted small mb-0">Update your password to keep your account secure</p>
                        </div>
                        <span class="ms-auto badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                            <i class="fas fa-shield-alt me-1"></i> Security
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.password') }}" method="POST" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="password" 
                                           name="current_password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           placeholder="Current Password"
                                           required
                                           disabled>
                                    <label for="current_password">
                                        <i class="fas fa-key text-muted me-2"></i>Current Password
                                    </label>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           placeholder="New Password"
                                           required
                                           disabled>
                                    <label for="password">
                                        <i class="fas fa-lock text-muted me-2"></i>New Password
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="password-strength mt-1" style="height: 4px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div id="strengthBar" style="width: 0%; height: 100%; background: #dc2626; transition: all 0.3s ease;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           placeholder="Confirm Password"
                                           required
                                           disabled>
                                    <label for="password_confirmation">
                                        <i class="fas fa-check-circle text-muted me-2"></i>Confirm Password
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 pt-3 mt-2 border-top">
                            <button type="submit" class="btn btn-danger px-4" id="passwordSaveButton" disabled>
                                <i class="fas fa-key me-2"></i> Update Password
                            </button>
                            <span class="text-muted small d-flex align-items-center" id="passwordHint">
                                <i class="fas fa-lock me-1"></i> Click "Edit Mode" to change password
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
    }
    .avatar-wrapper {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .avatar-wrapper:hover {
        transform: scale(1.02);
    }
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .form-floating > .form-control,
    .form-floating > .form-select {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .form-floating > label {
        color: #6b7280;
    }
    .form-control:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
    }
    textarea:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .btn-danger {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-danger:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }
    .btn-danger:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .btn-warning.edit-mode-active {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #1f2937;
        border: none;
    }
    .btn-warning.edit-mode-active:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border-color: transparent;
    }
    .btn-outline-success:hover {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: white;
        border-color: transparent;
    }
    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: white;
        border-color: transparent;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06) !important;
    }
    .password-strength {
        transition: all 0.3s ease;
    }
    .disabled-overlay {
        opacity: 0.6;
        pointer-events: none;
    }
    .editable-active {
        opacity: 1 !important;
        pointer-events: auto !important;
    }
    #editModeAlert {
        transition: all 0.3s ease;
    }
</style>
@endpush

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    let isEditMode = false;

    document.addEventListener('DOMContentLoaded', function() {
        // ============================================================
        // AVATAR PREVIEW
        // ============================================================
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.querySelector('.avatar-wrapper img, .avatar-wrapper .rounded-circle');
        
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.querySelector('.avatar-wrapper img');
                        if (preview) {
                            preview.src = event.target.result;
                        } else {
                            const wrapper = document.querySelector('.avatar-wrapper');
                            const newImg = document.createElement('img');
                            newImg.src = event.target.result;
                            newImg.className = 'rounded-circle img-fluid border border-4 border-white shadow-sm';
                            newImg.style.cssText = 'width: 120px; height: 120px; object-fit: cover; background: #f8f9fa;';
                            wrapper.innerHTML = '';
                            wrapper.appendChild(newImg);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // ============================================================
        // BIO CHARACTER COUNTER
        // ============================================================
        const bioInput = document.getElementById('bio');
        const bioCounter = document.getElementById('bioCounter');
        
        if (bioInput && bioCounter) {
            bioInput.addEventListener('input', function() {
                const length = this.value.length;
                bioCounter.textContent = length + '/500';
                bioCounter.style.color = length > 450 ? '#dc2626' : length > 400 ? '#f59e0b' : '#6b7280';
            });
            bioCounter.textContent = bioInput.value.length + '/500';
        }

        // ============================================================
        // PASSWORD STRENGTH METER
        // ============================================================
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        
        if (passwordInput && strengthBar) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength += 25;
                if (/[a-z]/.test(password)) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 15;
                if (/[^a-zA-Z0-9]/.test(password)) strength += 10;
                
                strengthBar.style.width = strength + '%';
                
                if (strength <= 25) {
                    strengthBar.style.background = '#dc2626';
                } else if (strength <= 50) {
                    strengthBar.style.background = '#f59e0b';
                } else if (strength <= 75) {
                    strengthBar.style.background = '#3b82f6';
                } else {
                    strengthBar.style.background = '#22c55e';
                }
            });
        }

        // ============================================================
        // FORM VALIDATION
        // ============================================================
        const profileForm = document.getElementById('profileForm');
        profileForm.addEventListener('submit', function(e) {
            if (!isEditMode) {
                e.preventDefault();
                alert('Please enable Edit Mode first by clicking the "Edit Mode" button.');
                return false;
            }
            
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            
            if (!name) {
                e.preventDefault();
                alert('Please enter your full name.');
                document.getElementById('name').focus();
                return false;
            }
            
            if (!email || !email.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                document.getElementById('email').focus();
                return false;
            }
        });

        const passwordForm = document.getElementById('passwordForm');
        passwordForm.addEventListener('submit', function(e) {
            if (!isEditMode) {
                e.preventDefault();
                alert('Please enable Edit Mode first by clicking the "Edit Mode" button.');
                return false;
            }
            
            const current = document.getElementById('current_password').value;
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            
            if (!current) {
                e.preventDefault();
                alert('Please enter your current password.');
                document.getElementById('current_password').focus();
                return false;
            }
            
            if (!password || password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                document.getElementById('password').focus();
                return false;
            }
            
            if (password !== confirm) {
                e.preventDefault();
                alert('New password and confirm password do not match.');
                document.getElementById('password_confirmation').focus();
                return false;
            }
        });

        // ============================================================
        // KEYBOARD SHORTCUTS
        // ============================================================
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                toggleEditMode();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (isEditMode) {
                    document.getElementById('profileForm').submit();
                }
            }
        });

        console.log('%c👤 Profile Settings Loaded', 'color: #4f46e5; font-size: 14px; font-weight: bold;');
        console.log('🔒 Profile is in View Mode. Press Ctrl+E to enable editing.');
        console.log('💡 Tip: Press Ctrl+E to toggle Edit Mode');
    });

    // ============================================================
    // TOGGLE EDIT MODE FUNCTION
    // ============================================================
    function toggleEditMode() {
        isEditMode = !isEditMode;
        
        // Get all form elements
        const formInputs = document.querySelectorAll('#profileForm input, #profileForm textarea');
        const passwordInputs = document.querySelectorAll('#passwordForm input');
        const saveButton = document.getElementById('saveButton');
        const resetButton = document.getElementById('resetButton');
        const passwordSaveButton = document.getElementById('passwordSaveButton');
        const editModeToggle = document.getElementById('editModeToggle');
        const editModeIcon = document.getElementById('editModeIcon');
        const editModeText = document.getElementById('editModeText');
        const modeStatusBadge = document.getElementById('modeStatusBadge');
        const editHint = document.getElementById('editHint');
        const passwordHint = document.getElementById('passwordHint');
        const editModeAlert = document.getElementById('editModeAlert');
        const editModeMessage = document.getElementById('editModeMessage');
        const profileCardBadge = document.getElementById('profileCardBadge');
        
        if (isEditMode) {
            // Enable all inputs
            formInputs.forEach(input => {
                if (input.type !== 'file') {
                    input.disabled = false;
                } else {
                    input.disabled = false;
                }
            });
            
            passwordInputs.forEach(input => {
                input.disabled = false;
            });
            
            // Enable buttons
            saveButton.disabled = false;
            resetButton.disabled = false;
            passwordSaveButton.disabled = false;
            
            // Update toggle button
            editModeToggle.className = 'btn btn-warning btn-sm px-3 edit-mode-active';
            editModeIcon.className = 'fas fa-unlock me-1';
            editModeText.textContent = 'Lock Mode';
            editModeToggle.title = 'Disable editing mode';
            
            // Update badge
            modeStatusBadge.className = 'ms-auto badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill';
            modeStatusBadge.innerHTML = '<i class="fas fa-edit me-1"></i> Edit Mode';
            
            // Update hints
            editHint.innerHTML = '<i class="fas fa-edit text-success me-1"></i> Editing enabled - Click "Save" to apply changes';
            passwordHint.innerHTML = '<i class="fas fa-edit text-success me-1"></i> Editing enabled - Update password';
            
            // Update alert message
            editModeMessage.innerHTML = '✏️ Profile is in <strong>Edit Mode</strong>. You can now make changes to your profile. Don\'t forget to <strong>Save</strong> when done!';
            editModeAlert.className = 'alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3';
            
            // Show badge on profile card
            profileCardBadge.style.display = 'inline-block';
            
            // Remove disabled overlay
            document.querySelectorAll('.form-floating').forEach(el => {
                el.style.opacity = '1';
            });
            
        } else {
            // Disable all inputs
            formInputs.forEach(input => {
                if (input.type !== 'file') {
                    input.disabled = true;
                } else {
                    input.disabled = true;
                }
            });
            
            passwordInputs.forEach(input => {
                input.disabled = true;
            });
            
            // Disable buttons
            saveButton.disabled = true;
            resetButton.disabled = true;
            passwordSaveButton.disabled = true;
            
            // Update toggle button
            editModeToggle.className = 'btn btn-warning btn-sm px-3';
            editModeIcon.className = 'fas fa-lock me-1';
            editModeText.textContent = 'Edit Mode';
            editModeToggle.title = 'Enable editing mode';
            
            // Update badge
            modeStatusBadge.className = 'ms-auto badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill';
            modeStatusBadge.innerHTML = '<i class="fas fa-eye me-1"></i> View Mode';
            
            // Update hints
            editHint.innerHTML = '<i class="fas fa-lock me-1"></i> Click "Edit Mode" to enable editing';
            passwordHint.innerHTML = '<i class="fas fa-lock me-1"></i> Click "Edit Mode" to change password';
            
            // Update alert message
            editModeMessage.innerHTML = '🔒 Profile is in <strong>View Mode</strong>. Click the <strong>"Edit Mode"</strong> button to make changes.';
            editModeAlert.className = 'alert alert-info alert-dismissible fade show border-0 shadow-sm rounded-3';
            
            // Hide badge on profile card
            profileCardBadge.style.display = 'none';
            
            // Add disabled overlay
            document.querySelectorAll('.form-floating').forEach(el => {
                el.style.opacity = '0.7';
            });
        }
    }

    // ============================================================
    // EXPORT PROFILE
    // ============================================================
    function exportProfile() {
        const name = '{{ $admin->name }}';
        const email = '{{ $admin->email }}';
        const role = '{{ $admin->role }}';
        const joined = '{{ $admin->created_at->format("M d, Y") }}';
        
        const data = {
            name: name,
            email: email,
            role: role,
            joined: joined,
            exported_at: new Date().toISOString()
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'profile-' + name.replace(/\s+/g, '-').toLowerCase() + '.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    // ============================================================
    // LOGOUT
    // ============================================================
    function logout() {
        document.getElementById('logout-form')?.submit();
    }
</script>
@endpush
@endsection