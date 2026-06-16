@extends('layouts.app')

@section('title', 'My Profile - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
    }

    .page-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .profile-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    .profile-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .profile-avatar-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        font-weight: 700;
        margin: 0 auto 0.8rem;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #4b5563;
        margin-bottom: 0.2rem;
    }
    .form-control {
        border-radius: 0.6rem;
        border: 1.5px solid #e5e7eb;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .form-control:disabled {
        background: #f9fafb;
        cursor: not-allowed;
    }

    .btn-save {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0.6rem;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        color: white;
    }

    @media (max-width: 576px) {
        .profile-card { padding: 1rem; }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card text-center">
                    <div class="profile-avatar-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h5 style="font-weight: 700; font-size: 1.1rem;">{{ Auth::user()->name }}</h5>
                    <p style="color: #6b7280; font-size: 0.8rem;">{{ Auth::user()->email }}</p>
                    <span class="badge" style="background: var(--primary-gradient); color: white; padding: 0.2rem 1rem; border-radius: 2rem;">Customer</span>
                </div>

                <form method="POST" action="{{ route('customer.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="profile-card">
                        <h6 style="font-weight: 700; font-size: 0.9rem; margin-bottom: 1rem;">
                            <i class="fas fa-user" style="color: #667eea;"></i> Personal Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ Auth::user()->country ?? 'Bangladesh' }}">
                            </div>
                        </div>
                    </div>

                    <div class="profile-card">
                        <h6 style="font-weight: 700; font-size: 0.9rem; margin-bottom: 1rem;">
                            <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> Address Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ Auth::user()->address ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ Auth::user()->city ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="{{ Auth::user()->state ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ Auth::user()->postal_code ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection