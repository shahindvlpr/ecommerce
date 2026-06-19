@extends('layouts.admin')

@section('title', 'Social Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-share-alt text-primary me-2"></i>Social Settings
            </h4>
            <p class="text-muted small">Configure social media links</p>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.social') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fab fa-facebook text-primary me-2"></i>Facebook
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                <input type="url" name="facebook" class="form-control" 
                                       value="{{ $settings['social']['facebook'] ?? '' }}" 
                                       placeholder="https://facebook.com/your-page">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fab fa-twitter text-info me-2"></i>Twitter / X
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                <input type="url" name="twitter" class="form-control" 
                                       value="{{ $settings['social']['twitter'] ?? '' }}" 
                                       placeholder="https://twitter.com/your-handle">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fab fa-instagram text-danger me-2"></i>Instagram
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                <input type="url" name="instagram" class="form-control" 
                                       value="{{ $settings['social']['instagram'] ?? '' }}" 
                                       placeholder="https://instagram.com/your-profile">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fab fa-youtube text-danger me-2"></i>YouTube
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                <input type="url" name="youtube" class="form-control" 
                                       value="{{ $settings['social']['youtube'] ?? '' }}" 
                                       placeholder="https://youtube.com/your-channel">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fab fa-linkedin text-primary me-2"></i>LinkedIn
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                <input type="url" name="linkedin" class="form-control" 
                                       value="{{ $settings['social']['linkedin'] ?? '' }}" 
                                       placeholder="https://linkedin.com/company/your-company">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fab fa-whatsapp text-success me-2"></i>WhatsApp
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                <input type="url" name="whatsapp" class="form-control" 
                                       value="{{ $settings['social']['whatsapp'] ?? '' }}" 
                                       placeholder="https://wa.me/your-number">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Social Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection