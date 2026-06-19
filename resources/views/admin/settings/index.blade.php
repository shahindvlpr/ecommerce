@extends('layouts.admin')

@section('title', 'Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-cog text-primary me-2"></i>Settings
    </h4>

    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.settings.index') }}" 
                           class="list-group-item list-group-item-action active">
                            <i class="fas fa-globe me-2"></i> General
                        </a>
                        <a href="{{ route('admin.settings.payment') }}" 
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-credit-card me-2"></i> Payment
                        </a>
                        <a href="{{ route('admin.settings.shipping') }}" 
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-truck me-2"></i> Shipping
                        </a>
                        <a href="{{ route('admin.settings.email') }}" 
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-envelope me-2"></i> Email
                        </a>
                        <a href="{{ route('admin.settings.seo') }}" 
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-search me-2"></i> SEO
                        </a>
                        <a href="{{ route('admin.settings.social') }}" 
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-share-alt me-2"></i> Social
                        </a>
                        <a href="{{ route('admin.settings.clear-cache') }}" 
                           class="list-group-item list-group-item-action text-danger"
                           onclick="event.preventDefault(); document.getElementById('clear-cache-form').submit();">
                            <i class="fas fa-broom me-2"></i> Clear Cache
                        </a>
                        <form id="clear-cache-form" action="{{ route('admin.settings.clear-cache') }}" method="POST" style="display:none;">
                            @csrf
                            @method('POST')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="col-lg-9">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">General Settings</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.general') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Store Name</label>
                                    <input type="text" name="store_name" class="form-control" 
                                           value="{{ $settings['general']['store_name'] ?? 'EktaMart' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Store Email</label>
                                    <input type="email" name="store_email" class="form-control" 
                                           value="{{ $settings['general']['store_email'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Store Phone</label>
                                    <input type="text" name="store_phone" class="form-control" 
                                           value="{{ $settings['general']['store_phone'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Currency</label>
                                    <select name="currency" class="form-control">
                                        <option value="USD" {{ ($settings['general']['currency'] ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                        <option value="BDT" {{ ($settings['general']['currency'] ?? 'USD') == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                        <option value="EUR" {{ ($settings['general']['currency'] ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                        <option value="GBP" {{ ($settings['general']['currency'] ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Time Zone</label>
                                    <select name="timezone" class="form-control">
                                        <option value="UTC" {{ ($settings['general']['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                        <option value="Asia/Dhaka" {{ ($settings['general']['timezone'] ?? 'UTC') == 'Asia/Dhaka' ? 'selected' : '' }}>Asia/Dhaka</option>
                                        <option value="America/New_York" {{ ($settings['general']['timezone'] ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                        <option value="Europe/London" {{ ($settings['general']['timezone'] ?? 'UTC') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Store Address</label>
                                    <textarea name="store_address" class="form-control" rows="2">{{ $settings['general']['store_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Store Description</label>
                                    <textarea name="store_description" class="form-control" rows="3">{{ $settings['general']['store_description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection