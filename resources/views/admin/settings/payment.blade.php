@extends('layouts.admin')

@section('title', 'Payment Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-credit-card text-primary me-2"></i>Payment Settings
        </h4>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">SSLCommerz Configuration</h6>
            <form action="{{ route('admin.settings.payment') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store ID</label>
                            <input type="text" name="ssl_store_id" class="form-control" 
                                   value="{{ config('services.sslcommerz.store_id') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Password</label>
                            <input type="password" name="ssl_store_password" class="form-control" 
                                   value="{{ config('services.sslcommerz.store_password') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mode</label>
                            <select name="ssl_mode" class="form-control">
                                <option value="sandbox" {{ config('services.sslcommerz.mode') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                <option value="live" {{ config('services.sslcommerz.mode') == 'live' ? 'selected' : '' }}>Live</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Base URL</label>
                            <input type="text" name="ssl_base_url" class="form-control" 
                                   value="{{ config('services.sslcommerz.base_url') }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Payment Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection