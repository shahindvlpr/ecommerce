@extends('layouts.admin')

@section('title', 'Shipping Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-truck text-primary me-2"></i>Shipping Settings
        </h4>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.shipping') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Free Shipping Threshold</label>
                            <input type="number" name="free_shipping_threshold" class="form-control" 
                                   value="100" step="0.01">
                            <small class="text-muted">Orders above this amount get free shipping</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Standard Shipping Cost</label>
                            <input type="number" name="standard_shipping_cost" class="form-control" 
                                   value="10" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Shipping Zones</label>
                            <textarea name="shipping_zones" class="form-control" rows="5" 
                                      placeholder="City: Cost per zone">Dhaka: 5
Chittagong: 8
Rajshahi: 10
Other: 15</textarea>
                            <small class="text-muted">Format: City: Cost (per delivery)</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Shipping Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection