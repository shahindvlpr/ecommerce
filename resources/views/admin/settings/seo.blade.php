@extends('layouts.admin')

@section('title', 'SEO Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-search text-primary me-2"></i>SEO Settings
            </h4>
            <p class="text-muted small">Optimize your store for search engines</p>
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
            <form action="{{ route('admin.settings.seo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" 
                                   value="{{ $settings['seo']['meta_title'] ?? 'EktaMart - Premium Ecommerce Platform' }}" 
                                   placeholder="Enter meta title">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" 
                                      placeholder="Enter meta description">{{ $settings['seo']['meta_description'] ?? 'EktaMart is a premium multi-vendor ecommerce platform offering quality products with fast delivery and secure payments.' }}</textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" 
                                   value="{{ $settings['seo']['meta_keywords'] ?? 'ecommerce, online shopping, multi-vendor, EktaMart' }}" 
                                   placeholder="Enter meta keywords">
                            <small class="text-muted">Comma separated keywords</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Image (Social Media Preview)</label>
                            @if(isset($settings['seo']['og_image']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['seo']['og_image']) }}" 
                                         alt="OG Image" style="max-width: 200px; max-height: 100px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    <br>
                                    <small class="text-muted">Current image</small>
                                </div>
                            @endif
                            <input type="file" name="og_image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: 1200x630px, max 2MB</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save SEO Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection