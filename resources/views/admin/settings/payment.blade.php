@extends('layouts.admin')

@section('title', 'Payment Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-success bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-credit-card text-success"></i>
                </span>
                Payment Settings
            </h4>
            <p class="text-muted small mb-0">Configure your payment gateway and transaction settings</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </button>
        </div>
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
        {{-- SIDEBAR --}}
        {{-- ============================================================ --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-2">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.settings.index') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                            <span class="bg-primary bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-globe text-primary"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">General</span>
                                <small class="text-muted">Store information</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.payment') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.payment') ? 'active' : '' }}">
                            <span class="bg-success bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-credit-card text-success"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Payment</span>
                                <small class="text-muted">Gateway settings</small>
                            </div>
                            @if(request()->routeIs('admin.settings.payment'))
                                <span class="ms-auto">
                                    <i class="fas fa-check-circle text-success"></i>
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('admin.settings.shipping') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.shipping') ? 'active' : '' }}">
                            <span class="bg-info bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-truck text-info"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Shipping</span>
                                <small class="text-muted">Delivery methods</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.email') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.email') ? 'active' : '' }}">
                            <span class="bg-warning bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-envelope text-warning"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Email</span>
                                <small class="text-muted">SMTP configuration</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.seo') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.seo') ? 'active' : '' }}">
                            <span class="bg-purple bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-search text-purple"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">SEO</span>
                                <small class="text-muted">Meta &amp; optimization</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.social') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">
                            <span class="bg-pink bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-share-alt text-pink"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Social</span>
                                <small class="text-muted">Social media links</small>
                            </div>
                        </a>

                        <hr class="my-2">

                        <a href="#" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 text-danger"
                           onclick="event.preventDefault(); if(confirm('Clear all cache?')) document.getElementById('clear-cache-form').submit();">
                            <span class="bg-danger bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-broom text-danger"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Clear Cache</span>
                                <small class="text-muted">Clear application cache</small>
                            </div>
                        </a>
                        <form id="clear-cache-form" action="{{ route('admin.settings.clear-cache') }}" method="POST" style="display:none;">
                            @csrf
                            @method('POST')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MAIN CONTENT --}}
        {{-- ============================================================ --}}
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-credit-card text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Payment Configuration</h6>
                            <p class="text-muted small mb-0">Setup your payment gateways and transaction preferences</p>
                        </div>
                        <span class="ms-auto">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                                {{ count(array_filter($settings['payment'] ?? [])) }} Gateways
                            </span>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.payment') }}" method="POST" id="paymentForm">
                        @csrf
                        @method('POST')

                        {{-- Payment Gateways --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-plug text-success me-2"></i>Payment Gateways
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="paypal_enabled" id="paypalEnabled"
                                               {{ ($settings['payment']['paypal_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="paypalEnabled">
                                            <i class="fab fa-paypal text-primary me-2"></i>PayPal
                                        </label>
                                        <p class="text-muted small mb-0">Enable PayPal payment gateway</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="stripe_enabled" id="stripeEnabled"
                                               {{ ($settings['payment']['stripe_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="stripeEnabled">
                                            <i class="fab fa-stripe text-primary me-2"></i>Stripe
                                        </label>
                                        <p class="text-muted small mb-0">Enable Stripe payment gateway</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="cod_enabled" id="codEnabled"
                                               {{ ($settings['payment']['cod_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="codEnabled">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i>Cash on Delivery
                                        </label>
                                        <p class="text-muted small mb-0">Enable Cash on Delivery option</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="bank_enabled" id="bankEnabled"
                                               {{ ($settings['payment']['bank_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="bankEnabled">
                                            <i class="fas fa-university text-info me-2"></i>Bank Transfer
                                        </label>
                                        <p class="text-muted small mb-0">Enable Bank Transfer payment</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- API Keys --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-key text-warning me-2"></i>API Credentials
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="paypal_client_id" 
                                               class="form-control @error('paypal_client_id') is-invalid @enderror" 
                                               id="paypal_client_id" 
                                               placeholder="PayPal Client ID"
                                               value="{{ old('paypal_client_id', $settings['payment']['paypal_client_id'] ?? '') }}">
                                        <label for="paypal_client_id">
                                            <i class="fab fa-paypal text-muted me-2"></i>PayPal Client ID
                                        </label>
                                        @error('paypal_client_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" 
                                               name="paypal_secret" 
                                               class="form-control @error('paypal_secret') is-invalid @enderror" 
                                               id="paypal_secret" 
                                               placeholder="PayPal Secret"
                                               value="{{ old('paypal_secret', $settings['payment']['paypal_secret'] ?? '') }}">
                                        <label for="paypal_secret">
                                            <i class="fas fa-key text-muted me-2"></i>PayPal Secret
                                        </label>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <small>Leave blank to keep current secret</small>
                                        </div>
                                        @error('paypal_secret')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="stripe_key" 
                                               class="form-control @error('stripe_key') is-invalid @enderror" 
                                               id="stripe_key" 
                                               placeholder="Stripe Publishable Key"
                                               value="{{ old('stripe_key', $settings['payment']['stripe_key'] ?? '') }}">
                                        <label for="stripe_key">
                                            <i class="fab fa-stripe text-muted me-2"></i>Stripe Publishable Key
                                        </label>
                                        @error('stripe_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" 
                                               name="stripe_secret" 
                                               class="form-control @error('stripe_secret') is-invalid @enderror" 
                                               id="stripe_secret" 
                                               placeholder="Stripe Secret Key"
                                               value="{{ old('stripe_secret', $settings['payment']['stripe_secret'] ?? '') }}">
                                        <label for="stripe_secret">
                                            <i class="fas fa-key text-muted me-2"></i>Stripe Secret Key
                                        </label>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <small>Leave blank to keep current secret</small>
                                        </div>
                                        @error('stripe_secret')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Transaction Settings --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-exchange-alt text-info me-2"></i>Transaction Settings
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" 
                                               name="tax_rate" 
                                               class="form-control @error('tax_rate') is-invalid @enderror" 
                                               id="tax_rate" 
                                               placeholder="Tax Rate"
                                               value="{{ old('tax_rate', $settings['payment']['tax_rate'] ?? 0) }}" 
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <label for="tax_rate">
                                            <i class="fas fa-percent text-muted me-2"></i>Tax Rate (%)
                                        </label>
                                        @error('tax_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" 
                                               name="currency_decimal" 
                                               class="form-control @error('currency_decimal') is-invalid @enderror" 
                                               id="currency_decimal" 
                                               placeholder="Decimal Places"
                                               value="{{ old('currency_decimal', $settings['payment']['currency_decimal'] ?? 2) }}"
                                               min="0"
                                               max="4">
                                        <label for="currency_decimal">
                                            <i class="fas fa-fill-drip text-muted me-2"></i>Decimal Places
                                        </label>
                                        @error('currency_decimal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i> Save Payment Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Quick Payment Guides --}}
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fab fa-paypal text-primary me-2"></i>PayPal
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Mode:</strong> Sandbox / Live<br>
                                <strong>Currency:</strong> USD, EUR, GBP<br>
                                <strong>Note:</strong> Get API credentials from PayPal Developer Dashboard
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fab fa-stripe text-primary me-2"></i>Stripe
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Mode:</strong> Test / Live<br>
                                <strong>Currency:</strong> Multiple<br>
                                <strong>Note:</strong> Get API keys from Stripe Dashboard
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-info-circle text-info me-2"></i>Tips
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Test Mode:</strong> Use sandbox keys for testing<br>
                                <strong>Security:</strong> Never share API keys<br>
                                <strong>Update:</strong> Regularly update API credentials
                            </p>
                        </div>
                    </div>
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
    .list-group-item.active {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
        border-color: transparent !important;
        color: #065f46 !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
    }
    .list-group-item-action {
        transition: all 0.3s ease;
    }
    .list-group-item-action:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }
    .list-group-item-action.active:hover {
        transform: translateX(4px);
    }
    .bg-purple {
        background: #7c3aed;
    }
    .text-purple {
        color: #7c3aed;
    }
    .bg-pink {
        background: #ec4899;
    }
    .text-pink {
        color: #ec4899;
    }
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    .form-floating > .form-control,
    .form-floating > .form-select {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .form-floating > label {
        color: #6b7280;
    }
    .sticky-top {
        z-index: 10;
    }
    .form-check.form-switch {
        background: #f9fafb;
        transition: all 0.3s ease;
    }
    .form-check.form-switch:hover {
        background: #f3f4f6;
    }
    .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }
</style>
@endpush

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.getElementById('paymentForm');
        form.addEventListener('submit', function(e) {
            // Validate PayPal credentials if PayPal is enabled
            const paypalEnabled = document.getElementById('paypalEnabled').checked;
            const paypalClientId = document.getElementById('paypal_client_id').value.trim();
            const paypalSecret = document.getElementById('paypal_secret').value.trim();
            
            if (paypalEnabled && (!paypalClientId || !paypalSecret)) {
                e.preventDefault();
                alert('Please fill in both PayPal Client ID and Secret when PayPal is enabled.');
                return false;
            }

            // Validate Stripe credentials if Stripe is enabled
            const stripeEnabled = document.getElementById('stripeEnabled').checked;
            const stripeKey = document.getElementById('stripe_key').value.trim();
            const stripeSecret = document.getElementById('stripe_secret').value.trim();
            
            if (stripeEnabled && (!stripeKey || !stripeSecret)) {
                e.preventDefault();
                alert('Please fill in both Stripe Publishable Key and Secret Key when Stripe is enabled.');
                return false;
            }

            // Validate tax rate
            const taxRate = document.getElementById('tax_rate').value;
            if (taxRate < 0 || taxRate > 100) {
                e.preventDefault();
                alert('Tax rate must be between 0 and 100.');
                return false;
            }
        });

        // Toggle API fields visibility
        function toggleApiFields() {
            const paypalEnabled = document.getElementById('paypalEnabled').checked;
            const stripeEnabled = document.getElementById('stripeEnabled').checked;
            
            document.getElementById('paypal_client_id').closest('.col-md-6').style.opacity = paypalEnabled ? '1' : '0.5';
            document.getElementById('paypal_secret').closest('.col-md-6').style.opacity = paypalEnabled ? '1' : '0.5';
            document.getElementById('stripe_key').closest('.col-md-6').style.opacity = stripeEnabled ? '1' : '0.5';
            document.getElementById('stripe_secret').closest('.col-md-6').style.opacity = stripeEnabled ? '1' : '0.5';
        }

        document.getElementById('paypalEnabled')?.addEventListener('change', toggleApiFields);
        document.getElementById('stripeEnabled')?.addEventListener('change', toggleApiFields);
        toggleApiFields();

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('paymentForm').submit();
            }
        });

        console.log('%c💳 Payment Settings Loaded', 'color: #10b981; font-size: 14px; font-weight: bold;');
        console.log(`%c🏦 Active Gateways: ${document.querySelectorAll('.form-check-input:checked').length}`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Press Ctrl+S to save settings');
    });
</script>
@endpush
@endsection