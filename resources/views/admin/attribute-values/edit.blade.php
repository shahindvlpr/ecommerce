@extends('layouts.admin')

@section('title', 'Edit Attribute Value - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-edit text-warning me-2"></i>Edit Attribute Value
            </h4>
            <p class="text-muted small">Update attribute value information</p>
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
            <form action="{{ route('admin.attribute-values.update', $attributeValue) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Attribute Selection --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Attribute <span class="text-danger">*</span></label>
                            <select name="attribute_id" class="form-control @error('attribute_id') is-invalid @enderror" required>
                                <option value="">-- Select Attribute --</option>
                                @foreach($attributes as $attribute)
                                    <option value="{{ $attribute->id }}" {{ old('attribute_id', $attributeValue->attribute_id) == $attribute->id ? 'selected' : '' }}>
                                        {{ $attribute->name }} ({{ ucfirst($attribute->type) }})
                                    </option>
                                @endforeach
                            </select>
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
                                   placeholder="e.g. Large, Red, Cotton" value="{{ old('value', $attributeValue->value) }}" required>
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
                                   placeholder="Display label (optional)" value="{{ old('label', $attributeValue->label) }}">
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
                                       style="width: 50px; padding: 0.2rem;" value="{{ old('color_code', $attributeValue->color_code ?? '#000000') }}">
                                <input type="text" class="form-control" placeholder="#FF0000" value="{{ old('color_code', $attributeValue->color_code) }}" 
                                       oninput="document.querySelector('input[name=\'color_code\']').value = this.value">
                            </div>
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
                                   placeholder="0" value="{{ old('sort_order', $attributeValue->sort_order ?? 0) }}">
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
                                       {{ old('is_active', $attributeValue->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="statusSwitch">
                                    <span id="statusLabel" class="badge {{ ($attributeValue->is_active ?? true) ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ($attributeValue->is_active ?? true) ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Image</label>
                            @if($attributeValue->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $attributeValue->image) }}" alt="{{ $attributeValue->value }}" 
                                         style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    <br>
                                    <small class="text-muted">Current image</small>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Value
                    </button>
                    <a href="{{ route('admin.attribute-values.index') }}" class="btn btn-outline-secondary btn-lg">
                        Cancel
                    </a>
                    
                    {{-- Delete Button --}}
                    <div class="ms-auto">
                        <button type="button" class="btn btn-outline-danger btn-lg" 
                                onclick="confirmDelete({{ $attributeValue->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Form (Hidden) --}}
<form id="delete-form-{{ $attributeValue->id }}" 
      action="{{ route('admin.attribute-values.destroy', $attributeValue) }}" 
      method="POST" 
      style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
    // 3. CONFIRM DELETE
    // ============================================================
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this attribute value? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    console.log('%c✏️ Edit Attribute Value Page Loaded', 'color: #f59e0b; font-size: 13px; font-weight: bold;');
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