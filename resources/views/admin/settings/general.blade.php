@extends('layouts.admin')

@section('title', 'General Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-globe text-primary me-2"></i>General Settings
            </h4>
            <p class="text-muted small">Configure your store general settings</p>
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.general') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    {{-- Store Name --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" 
                                   value="{{ old('store_name', $settings['general']['store_name'] ?? config('app.name', 'EktaMart')) }}" 
                                   placeholder="Enter store name" required>
                            @error('store_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Store Email --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Email <span class="text-danger">*</span></label>
                            <input type="email" name="store_email" class="form-control @error('store_email') is-invalid @enderror" 
                                   value="{{ old('store_email', $settings['general']['store_email'] ?? '') }}" 
                                   placeholder="Enter store email" required>
                            @error('store_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Store Phone --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Phone</label>
                            <input type="text" name="store_phone" class="form-control @error('store_phone') is-invalid @enderror" 
                                   value="{{ old('store_phone', $settings['general']['store_phone'] ?? '') }}" 
                                   placeholder="Enter store phone number">
                            @error('store_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Default Currency <span class="text-danger">*</span></label>
                            <select name="currency" class="form-control @error('currency') is-invalid @enderror" required>
                                <option value="USD" {{ (old('currency', $settings['general']['currency'] ?? 'USD') == 'USD') ? 'selected' : '' }}>USD ($)</option>
                                <option value="BDT" {{ (old('currency', $settings['general']['currency'] ?? 'USD') == 'BDT') ? 'selected' : '' }}>BDT (৳)</option>
                                <option value="EUR" {{ (old('currency', $settings['general']['currency'] ?? 'USD') == 'EUR') ? 'selected' : '' }}>EUR (€)</option>
                                <option value="GBP" {{ (old('currency', $settings['general']['currency'] ?? 'USD') == 'GBP') ? 'selected' : '' }}>GBP (£)</option>
                                <option value="CAD" {{ (old('currency', $settings['general']['currency'] ?? 'USD') == 'CAD') ? 'selected' : '' }}>CAD ($)</option>
                                <option value="AUD" {{ (old('currency', $settings['general']['currency'] ?? 'USD') == 'AUD') ? 'selected' : '' }}>AUD ($)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Timezone --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Timezone <span class="text-danger">*</span></label>
                            <select name="timezone" class="form-control @error('timezone') is-invalid @enderror" required>
                                <option value="UTC" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'UTC') ? 'selected' : '' }}>UTC</option>
                                <option value="Asia/Dhaka" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'Asia/Dhaka') ? 'selected' : '' }}>Asia/Dhaka</option>
                                <option value="America/New_York" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'America/New_York') ? 'selected' : '' }}>America/New_York</option>
                                <option value="America/Los_Angeles" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'America/Los_Angeles') ? 'selected' : '' }}>America/Los_Angeles</option>
                                <option value="Europe/London" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'Europe/London') ? 'selected' : '' }}>Europe/London</option>
                                <option value="Europe/Paris" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'Europe/Paris') ? 'selected' : '' }}>Europe/Paris</option>
                                <option value="Asia/Tokyo" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'Asia/Tokyo') ? 'selected' : '' }}>Asia/Tokyo</option>
                                <option value="Australia/Sydney" {{ (old('timezone', $settings['general']['timezone'] ?? 'UTC') == 'Australia/Sydney') ? 'selected' : '' }}>Australia/Sydney</option>
                            </select>
                            @error('timezone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Store Address --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Address</label>
                            <textarea name="store_address" class="form-control @error('store_address') is-invalid @enderror" 
                                      rows="2" placeholder="Enter store address">{{ old('store_address', $settings['general']['store_address'] ?? '') }}</textarea>
                            @error('store_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Store Description --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Store Description</label>
                            <textarea name="store_description" class="form-control @error('store_description') is-invalid @enderror" 
                                      rows="2" placeholder="Enter store description">{{ old('store_description', $settings['general']['store_description'] ?? '') }}</textarea>
                            @error('store_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Save General Settings
                    </button>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    console.log('%c⚙️ General Settings Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
</script>

<style>
    .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.1);
    }
</style>
@endsection