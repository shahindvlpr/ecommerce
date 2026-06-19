@extends('layouts.admin')

@section('title', 'SEO Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-search text-primary me-2"></i>SEO Settings
        </h4>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.seo') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" 
                                   value="EktaMart - Premium Ecommerce Platform">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">EktaMart is a premium multi-vendor ecommerce platform offering quality products with fast delivery and secure payments.</textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" 
                                   value="ecommerce, online shopping, multi-vendor, EktaMart">
                            <small class="text-muted">Comma separated keywords</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save SEO Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection