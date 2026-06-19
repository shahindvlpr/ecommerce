@extends('layouts.admin')

@section('title', 'Edit Category - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-edit text-warning me-2"></i>Edit Category
            </h4>
            <p class="text-muted small">Update category information for your store</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
        </div>
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   placeholder="Enter category name" 
                                   value="{{ old('name', $category->name) }}" 
                                   required
                                   id="categoryName">
                            <small class="text-muted">This will be displayed on the frontend</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug</label>
                            <input type="text" name="slug" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   placeholder="auto-generated from name" 
                                   value="{{ old('slug', $category->slug) }}"
                                   id="categorySlug">
                            <small class="text-muted">Leave empty to auto-generate from name</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text" id="iconPreview">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}"></i>
                                    @else
                                        <i class="fas fa-folder-open"></i>
                                    @endif
                                </span>
                                <input type="text" name="icon" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       placeholder="e.g. fas fa-laptop" 
                                       value="{{ old('icon', $category->icon) }}"
                                       id="categoryIcon"
                                       oninput="updateIconPreview(this.value)">
                            </div>
                            <small class="text-muted">
                                Current: <code>{{ $category->icon ?? 'No icon' }}</code>
                                <br>
                                <a href="https://fontawesome.com/icons" target="_blank" class="text-primary">
                                    <i class="fas fa-external-link-alt"></i> Browse FontAwesome Icons
                                </a>
                            </small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="status" class="form-check-input" 
                                       id="statusSwitch" value="1" 
                                       {{ old('status', $category->status) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="statusSwitch">
                                    <span id="statusLabel" class="badge {{ $category->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $category->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </div>
                            <small class="text-muted">Active categories will be visible on the frontend</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Category description (optional)">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Category Image --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category Image</label>
                            
                            @if($category->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         style="max-width: 200px; max-height: 150px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    <br>
                                    <small class="text-muted">Current image</small>
                                </div>
                            @endif
                            
                            <input type="file" name="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Recommended: 400x400px, max 2MB. Leave empty to keep current image.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-lg">
                        Cancel
                    </a>
                    
                    {{-- Danger Zone --}}
                    <div class="ms-auto">
                        <button type="button" class="btn btn-outline-danger btn-lg" 
                                onclick="confirmDelete({{ $category->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Form (Hidden) --}}
    <form id="delete-form-{{ $category->id }}" 
          action="{{ route('admin.categories.destroy', $category) }}" 
          method="POST" 
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    // ============================================================
    // 1. AUTO-GENERATE SLUG FROM NAME
    // ============================================================
    document.getElementById('categoryName')?.addEventListener('input', function() {
        const slugInput = document.getElementById('categorySlug');
        if (slugInput && !slugInput.value) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });

    // ============================================================
    // 2. ICON PREVIEW
    // ============================================================
    function updateIconPreview(iconClass) {
        const preview = document.getElementById('iconPreview');
        if (preview) {
            if (iconClass && iconClass.trim()) {
                preview.innerHTML = `<i class="${iconClass.trim()}"></i>`;
            } else {
                preview.innerHTML = '<i class="fas fa-folder-open"></i>';
            }
        }
    }

    // ============================================================
    // 3. STATUS TOGGLE
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
    // 4. CONFIRM DELETE
    // ============================================================
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // ============================================================
    // 5. CONSOLE GREETING
    // ============================================================
    console.log('%c✏️ Edit Category Page Loaded', 'color: #f59e0b; font-size: 13px; font-weight: bold;');
    console.log('%c📁 Category: {{ $category->name }}', 'color: #8b5cf6; font-size: 12px;');
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
    .input-group-text {
        background: #f8fafc;
        border-right: none;
        min-width: 45px;
        justify-content: center;
    }
    .input-group .form-control {
        border-left: none;
    }
    .input-group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
    .input-group .form-control:focus + .input-group-text {
        border-color: #8b5cf6;
    }
</style>
@endsection