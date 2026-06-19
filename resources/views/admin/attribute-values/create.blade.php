@extends('layouts.admin')

@section('title', 'Create Attribute Value - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-plus-circle text-primary me-2"></i>Create Attribute Value
            </h4>
            <p class="text-muted small">Add a new value for an attribute</p>
        </div>
        <a href="{{ route('admin.attribute-values.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Values
        </a>
    </div>

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
            <form action="{{ route('admin.attribute-values.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Attribute Selection --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Attribute <span class="text-danger">*</span></label>
                            <select name="attribute_id" class="form-control @error('attribute_id') is-invalid @enderror" required>
                                <option value="">-- Select Attribute --</option>
                                @foreach($attributes as $attribute)
                                    <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                        {{ $attribute->name }} ({{ ucfirst($attribute->type) }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select which attribute this value belongs to</small>
                            @error('attribute_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Value Name --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Value <span class="text-danger">*</span></label>
                            <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" 
                                   placeholder="e.g. Large, Red, Cotton" value="{{ old('value') }}" required>
                            <small class="text-muted">The actual value (e.g. Red, XL, Cotton)</small>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Label (Optional) --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Display Label</label>
                            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" 
                                   placeholder="Display label (optional)" value="{{ old('label') }}">
                            <small class="text-muted">Leave empty to use the value as label</small>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Color Code --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Color Code</label>
                            <div class="input-group">
                                <input type="color" name="color_code" class="form-control form-control-color @error('color_code') is-invalid @enderror" 
                                       style="width: 50px; padding: 0.2rem;" value="{{ old('color_code', '#000000') }}">
                                <input type="text" class="form-control" placeholder="#FF0000" value="{{ old('color_code') }}" 
                                       oninput="document.querySelector('input[name=\'color_code\']').value = this.value">
                            </div>
                            <small class="text-muted">Color code for color attributes (e.g. #FF0000)</small>
                            @error('color_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                   placeholder="0" value="{{ old('sort_order', 0) }}">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="is_active" class="form-check-input" 
                                       id="statusSwitch" value="1" 
                                       {{ old('is_active') !== '0' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="statusSwitch">
                                    <span id="statusLabel" class="badge bg-success">Active</span>
                                </label>
                            </div>
                            <small class="text-muted">Inactive values won't be visible on the store</small>
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Image (Optional)</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Recommended: 100x100px, max 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Create Value
                    </button>
                    <a href="{{ route('admin.attribute-values.index') }}" class="btn btn-outline-secondary btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ============================================================
    // 1. STATUS TOGGLE
    // ============================================================
    document.getElementById('statusSwitch')?.addEventListener('change', function() {
        const label = document.getElementById('statusLabel');
        if (this.checked) {
            label.textContent = 'Active';
            label.className = 'badge bg-success';
        } else {
            label.textContent = 'Inactive';
            label.className = 'badge bg-secondary';
        }
    });

    // ============================================================
    // 2. COLOR CODE SYNC
    // ============================================================
    document.querySelector('input[type="color"]')?.addEventListener('input', function() {
        const textInput = document.querySelector('input[type="text"][placeholder="#FF0000"]');
        if (textInput) {
            textInput.value = this.value;
        }
    });

    // ============================================================
    // 3. CONSOLE GREETING
    // ============================================================
    console.log('%c🏷️ Create Attribute Value Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
</script>

<style>
    .form-check-input:checked {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
    }
    .form-check-input:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }
    .form-control-color {
        padding: 0.2rem;
        height: 38px;
        cursor: pointer;
    }
</style>
@endsection