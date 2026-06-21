@extends('layouts.admin')

@section('title', 'Shipping Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-info bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-truck text-info"></i>
                </span>
                Shipping Settings
            </h4>
            <p class="text-muted small mb-0">Configure shipping methods, rates, and delivery options</p>
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
                            @if(request()->routeIs('admin.settings.shipping'))
                                <span class="ms-auto">
                                    <i class="fas fa-check-circle text-info"></i>
                                </span>
                            @endif
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
                        <div class="bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-truck text-info fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Shipping Configuration</h6>
                            <p class="text-muted small mb-0">Setup shipping methods, rates, and delivery zones</p>
                        </div>
                        <span class="ms-auto">
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                <i class="fas fa-circle text-info me-1" style="font-size: 8px;"></i> 
                                {{ count(array_filter($settings['shipping'] ?? [])) }} Methods
                            </span>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.shipping') }}" method="POST" id="shippingForm">
                        @csrf
                        @method('POST')

                        {{-- Shipping Methods --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-box text-info me-2"></i>Shipping Methods
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="free_shipping_enabled" id="freeShipping"
                                               {{ ($settings['shipping']['free_shipping_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="freeShipping">
                                            <i class="fas fa-gift text-success me-2"></i>Free Shipping
                                        </label>
                                        <p class="text-muted small mb-0">Enable free shipping for eligible orders</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="flat_rate_enabled" id="flatRate"
                                               {{ ($settings['shipping']['flat_rate_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="flatRate">
                                            <i class="fas fa-dollar-sign text-primary me-2"></i>Flat Rate
                                        </label>
                                        <p class="text-muted small mb-0">Enable flat rate shipping for all orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Shipping Rates --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-sliders-h text-info me-2"></i>Shipping Rates
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" 
                                               name="free_shipping_min" 
                                               class="form-control @error('free_shipping_min') is-invalid @enderror" 
                                               id="free_shipping_min" 
                                               placeholder="Min Order for Free Shipping"
                                               value="{{ old('free_shipping_min', $settings['shipping']['free_shipping_min'] ?? 100) }}" 
                                               step="0.01"
                                               min="0">
                                        <label for="free_shipping_min">
                                            <i class="fas fa-gift text-muted me-2"></i>Min Order (Free Shipping)
                                        </label>
                                        <div class="form-text">
                                            <small>Minimum order amount to qualify for free shipping</small>
                                        </div>
                                        @error('free_shipping_min')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" 
                                               name="flat_rate_amount" 
                                               class="form-control @error('flat_rate_amount') is-invalid @enderror" 
                                               id="flat_rate_amount" 
                                               placeholder="Flat Rate Amount"
                                               value="{{ old('flat_rate_amount', $settings['shipping']['flat_rate_amount'] ?? 10) }}" 
                                               step="0.01"
                                               min="0">
                                        <label for="flat_rate_amount">
                                            <i class="fas fa-dollar-sign text-muted me-2"></i>Flat Rate Amount
                                        </label>
                                        <div class="form-text">
                                            <small>Fixed shipping cost for all orders</small>
                                        </div>
                                        @error('flat_rate_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Shipping Zones --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-map-marked-alt text-info me-2"></i>Shipping Zones
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="shipping_zones" 
                                                  class="form-control @error('shipping_zones') is-invalid @enderror" 
                                                  id="shipping_zones" 
                                                  placeholder="Shipping Zones" 
                                                  rows="3" 
                                                  style="height: 100px;">{{ old('shipping_zones', $settings['shipping']['shipping_zones'] ?? 'Domestic, International') }}</textarea>
                                        <label for="shipping_zones">
                                            <i class="fas fa-globe-asia text-muted me-2"></i>Shipping Zones
                                        </label>
                                        @error('shipping_zones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <small>Enter shipping zones separated by commas (e.g., Domestic, International, Europe, Asia)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Additional Shipping Options --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-clock text-info me-2"></i>Delivery Options
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="express_delivery_enabled" id="expressDelivery"
                                               {{ ($settings['shipping']['express_delivery_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="expressDelivery">
                                            <i class="fas fa-rocket text-warning me-2"></i>Express Delivery
                                        </label>
                                        <p class="text-muted small mb-0">Enable express/priority delivery option</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="tracking_enabled" id="trackingEnabled"
                                               {{ ($settings['shipping']['tracking_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="trackingEnabled">
                                            <i class="fas fa-search-location text-primary me-2"></i>Order Tracking
                                        </label>
                                        <p class="text-muted small mb-0">Enable order tracking for customers</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-info px-4 text-white">
                                <i class="fas fa-save me-2"></i> Save Shipping Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Quick Shipping Guides --}}
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-gift text-success me-2"></i>Free Shipping
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Trigger:</strong> Order total ≥ Min Order<br>
                                <strong>Benefit:</strong> Zero shipping cost<br>
                                <strong>Note:</strong> Boosts conversion rates
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-dollar-sign text-primary me-2"></i>Flat Rate
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Rate:</strong> Fixed amount per order<br>
                                <strong>Benefit:</strong> Simple and predictable<br>
                                <strong>Note:</strong> Best for small businesses
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>Best Practices
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Tip 1:</strong> Offer free shipping on high-value orders<br>
                                <strong>Tip 2:</strong> Test different rates<br>
                                <strong>Tip 3:</strong> Be transparent with costs
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
        background: linear-gradient(135deg, #e0f2fe, #bae6fd) !important;
        border-color: transparent !important;
        color: #0369a1 !important;
        box-shadow: 0 2px 8px rgba(6, 182, 212, 0.15);
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
        border-color: #06b6d4;
        box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
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
        background-color: #06b6d4;
        border-color: #06b6d4;
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
        const form = document.getElementById('shippingForm');
        form.addEventListener('submit', function(e) {
            // Validate free shipping min if free shipping is enabled
            const freeShippingEnabled = document.getElementById('freeShipping').checked;
            const freeShippingMin = document.getElementById('free_shipping_min').value;
            
            if (freeShippingEnabled && (parseFloat(freeShippingMin) < 0 || freeShippingMin === '')) {
                e.preventDefault();
                alert('Please enter a valid minimum order amount for free shipping.');
                return false;
            }

            // Validate flat rate if flat rate is enabled
            const flatRateEnabled = document.getElementById('flatRate').checked;
            const flatRateAmount = document.getElementById('flat_rate_amount').value;
            
            if (flatRateEnabled && (parseFloat(flatRateAmount) < 0 || flatRateAmount === '')) {
                e.preventDefault();
                alert('Please enter a valid flat rate amount.');
                return false;
            }

            // Validate shipping zones
            const shippingZones = document.getElementById('shipping_zones').value.trim();
            if (!shippingZones) {
                e.preventDefault();
                alert('Please enter at least one shipping zone.');
                return false;
            }
        });

        // Toggle rate fields visibility
        function toggleRateFields() {
            const freeShippingEnabled = document.getElementById('freeShipping').checked;
            const flatRateEnabled = document.getElementById('flatRate').checked;
            
            document.getElementById('free_shipping_min').closest('.col-md-6').style.opacity = freeShippingEnabled ? '1' : '0.5';
            document.getElementById('free_shipping_min').disabled = !freeShippingEnabled;
            
            document.getElementById('flat_rate_amount').closest('.col-md-6').style.opacity = flatRateEnabled ? '1' : '0.5';
            document.getElementById('flat_rate_amount').disabled = !flatRateEnabled;
        }

        document.getElementById('freeShipping')?.addEventListener('change', toggleRateFields);
        document.getElementById('flatRate')?.addEventListener('change', toggleRateFields);
        toggleRateFields();

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('shippingForm').submit();
            }
        });

        console.log('%c🚚 Shipping Settings Loaded', 'color: #06b6d4; font-size: 14px; font-weight: bold;');
        console.log(`%c📦 Free Shipping: ${document.getElementById('freeShipping').checked ? 'Enabled' : 'Disabled'}`, 'color: #6b7280; font-size: 12px;');
        console.log(`%c💰 Flat Rate: ${document.getElementById('flatRate').checked ? 'Enabled' : 'Disabled'}`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Press Ctrl+S to save settings');
    });
</script>
@endpush
@endsection