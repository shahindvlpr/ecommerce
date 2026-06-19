@extends('layouts.admin')

@section('title', 'Payment Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-credit-card text-primary me-2"></i>Payment Settings
            </h4>
            <p class="text-muted small">Configure payment gateways</p>
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
            <form action="{{ route('admin.settings.payment') }}" method="POST">
                @csrf
                @method('POST')

                {{-- SSLCommerz Settings --}}
                <h6 class="fw-bold mb-3">SSLCommerz Configuration</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">SSLCommerz Enabled</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="sslcommerz_enabled" class="form-check-input" 
                                       id="sslcommerzEnabled" value="1" 
                                       {{ ($settings['payment']['sslcommerz_enabled'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sslcommerzEnabled">Enable SSLCommerz</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">COD Enabled</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="cod_enabled" class="form-check-input" 
                                       id="codEnabled" value="1" 
                                       {{ ($settings['payment']['cod_enabled'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="codEnabled">Enable Cash on Delivery</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">bKash Enabled</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="bkash_enabled" class="form-check-input" 
                                       id="bkashEnabled" value="1" 
                                       {{ ($settings['payment']['bkash_enabled'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="bkashEnabled">Enable bKash</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nagad Enabled</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="nagad_enabled" class="form-check-input" 
                                       id="nagadEnabled" value="1" 
                                       {{ ($settings['payment']['nagad_enabled'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="nagadEnabled">Enable Nagad</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store ID</label>
                            <input type="text" name="ssl_store_id" class="form-control" 
                                   value="{{ $settings['payment']['ssl_store_id'] ?? '' }}" 
                                   placeholder="Enter SSLCommerz Store ID">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Password</label>
                            <input type="password" name="ssl_store_password" class="form-control" 
                                   value="{{ $settings['payment']['ssl_store_password'] ?? '' }}" 
                                   placeholder="Enter SSLCommerz Store Password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mode</label>
                            <select name="ssl_mode" class="form-control">
                                <option value="sandbox" {{ ($settings['payment']['ssl_mode'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                                <option value="live" {{ ($settings['payment']['ssl_mode'] ?? 'sandbox') == 'live' ? 'selected' : '' }}>Live (Production)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Base URL</label>
                            <input type="text" name="ssl_base_url" class="form-control" 
                                   value="{{ $settings['payment']['ssl_base_url'] ?? 'https://sandbox.sslcommerz.com' }}" 
                                   placeholder="Enter SSLCommerz Base URL">
                        </div>
                    </div>
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Payment Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection