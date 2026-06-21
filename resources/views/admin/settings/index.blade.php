@extends('layouts.admin')

@section('title', 'General Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-primary bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-cog text-primary"></i>
                </span>
                General Settings
            </h4>
            <p class="text-muted small mb-0">Configure your store's general information and preferences</p>
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
                            @if(request()->routeIs('admin.settings.index'))
                                <span class="ms-auto">
                                    <i class="fas fa-check-circle text-primary"></i>
                                </span>
                            @endif
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
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-globe text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">General Settings</h6>
                            <p class="text-muted small mb-0">Update your store's basic information and preferences</p>
                        </div>
                        <span class="ms-auto badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> Live
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.general') }}" method="POST">
                        @csrf
                        @method('POST')

                        {{-- Basic Information --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>Basic Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="store_name" class="form-control" 
                                               id="store_name" placeholder="Store Name"
                                               value="{{ $settings['general']['store_name'] ?? 'EktaMart' }}">
                                        <label for="store_name">
                                            <i class="fas fa-store text-muted me-2"></i>Store Name
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="store_email" class="form-control" 
                                               id="store_email" placeholder="Store Email"
                                               value="{{ $settings['general']['store_email'] ?? '' }}">
                                        <label for="store_email">
                                            <i class="fas fa-envelope text-muted me-2"></i>Store Email
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="store_phone" class="form-control" 
                                               id="store_phone" placeholder="Store Phone"
                                               value="{{ $settings['general']['store_phone'] ?? '' }}">
                                        <label for="store_phone">
                                            <i class="fas fa-phone text-muted me-2"></i>Store Phone
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="currency" class="form-select" id="currency">
                                            <option value="USD" {{ ($settings['general']['currency'] ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                            <option value="BDT" {{ ($settings['general']['currency'] ?? 'USD') == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                            <option value="EUR" {{ ($settings['general']['currency'] ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                            <option value="GBP" {{ ($settings['general']['currency'] ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                        </select>
                                        <label for="currency">
                                            <i class="fas fa-money-bill-wave text-muted me-2"></i>Currency
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Advanced Settings --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-sliders-h text-primary me-2"></i>Advanced Settings
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="timezone" class="form-select" id="timezone">
                                            <option value="UTC" {{ ($settings['general']['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                            <option value="Asia/Dhaka" {{ ($settings['general']['timezone'] ?? 'UTC') == 'Asia/Dhaka' ? 'selected' : '' }}>Asia/Dhaka</option>
                                            <option value="America/New_York" {{ ($settings['general']['timezone'] ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                            <option value="Europe/London" {{ ($settings['general']['timezone'] ?? 'UTC') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                        </select>
                                        <label for="timezone">
                                            <i class="fas fa-clock text-muted me-2"></i>Time Zone
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="date_format" class="form-control" 
                                               id="date_format" placeholder="Date Format"
                                               value="{{ $settings['general']['date_format'] ?? 'Y-m-d' }}">
                                        <label for="date_format">
                                            <i class="fas fa-calendar text-muted me-2"></i>Date Format
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Address & Description --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>Store Location
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="store_address" class="form-control" 
                                                  id="store_address" placeholder="Store Address" 
                                                  rows="2" style="height: 80px;">{{ $settings['general']['store_address'] ?? '' }}</textarea>
                                        <label for="store_address">
                                            <i class="fas fa-map-pin text-muted me-2"></i>Store Address
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="store_description" class="form-control" 
                                                  id="store_description" placeholder="Store Description" 
                                                  rows="3" style="height: 100px;">{{ $settings['general']['store_description'] ?? '' }}</textarea>
                                        <label for="store_description">
                                            <i class="fas fa-align-left text-muted me-2"></i>Store Description
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
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
    .list-group-item.active {
        background: linear-gradient(135deg, #f3e8ff, #ede9fe) !important;
        border-color: transparent !important;
        color: #7c3aed !important;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.1);
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
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
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
</style>
@endpush
@endsection