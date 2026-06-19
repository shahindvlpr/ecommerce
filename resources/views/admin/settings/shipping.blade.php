@extends('layouts.admin')

@section('title', 'Shipping Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-truck text-primary me-2"></i>Shipping Settings
            </h4>
            <p class="text-muted small">Configure shipping options</p>
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
            <form action="{{ route('admin.settings.shipping') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Free Shipping Threshold</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="free_shipping_threshold" class="form-control" 
                                       value="{{ $settings['shipping']['free_shipping_threshold'] ?? 100 }}" 
                                       placeholder="100" step="0.01">
                            </div>
                            <small class="text-muted">Orders above this amount get free shipping</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Standard Shipping Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="standard_shipping_cost" class="form-control" 
                                       value="{{ $settings['shipping']['standard_shipping_cost'] ?? 10 }}" 
                                       placeholder="10" step="0.01">
                            </div>
                            <small class="text-muted">Default shipping cost for all orders</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Shipping Zones</label>
                            <textarea name="shipping_zones" class="form-control" rows="6" 
                                      placeholder="City: Cost per delivery&#10;Example:&#10;Dhaka: 5&#10;Chittagong: 8&#10;Rajshahi: 10&#10;Other: 15">{{ $settings['shipping']['shipping_zones'] ?? '' }}</textarea>
                            <small class="text-muted">Format: City: Cost (per delivery). One per line.</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Shipping Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection