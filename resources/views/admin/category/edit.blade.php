{{-- resources/views/admin/category/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Category - EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-5">
    
    <style>
        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slide-left {
            animation: slideInLeft 0.5s ease-out forwards;
        }
        
        /* Category Card */
        .category-card {
            border: none;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        /* Card Header */
        .card-header-premium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .card-header-premium h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        /* Form Controls */
        .form-control, .form-select {
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            font-weight: 500;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .required-field::after {
            content: '*';
            color: #ef4444;
            margin-left: 0.25rem;
        }
        
        /* Image Preview Section */
        .current-image-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .current-image {
            max-width: 120px;
            max-height: 120px;
            border-radius: 1rem;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .current-image:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .image-preview-container {
            border: 2px dashed #cbd5e1;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #f8fafc;
        }
        
        .image-preview-container:hover {
            border-color: #f59e0b;
            background: #fffbeb;
        }
        
        .preview-img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 0.75rem;
            margin-top: 1rem;
            display: none;
        }
        
        /* Status Badge Styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .badge-active {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .form-check-input:checked {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
        }
        
        /* Button Styles */
        .btn-premium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: white;
        }
        
        .btn-secondary-custom {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-secondary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(71, 85, 105, 0.3);
            color: white;
        }
        
        /* Alert Styles */
        .alert-premium {
            border-radius: 1rem;
            border: none;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            font-weight: 500;
            animation: slideInLeft 0.5s ease-out;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-custom .breadcrumb-item a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .breadcrumb-custom .breadcrumb-item a:hover {
            color: #d97706;
        }
        
        .breadcrumb-custom .breadcrumb-item.active {
            color: #64748b;
            font-weight: 500;
        }
        
        /* Loading Spinner */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }
        
        .spinner-sm {
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .card-header-premium {
                flex-direction: column;
                text-align: center;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .action-buttons button,
            .action-buttons a {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <div class="animate-slide-left">
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">
                        <i class="fas fa-tags me-1"></i> Categories
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-edit me-1"></i> Edit Category
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="row justify-content-center animate-fade-up">
        <div class="col-lg-8 col-md-10">
            <div class="card category-card shadow-sm">
                <div class="card-header-premium">
                    <h4>
                        <i class="fas fa-edit me-2"></i>
                        Edit Category
                    </h4>
                    <div class="ms-auto">
                        <span class="status-badge {{ $category->status ? 'badge-active' : 'badge-inactive' }}">
                            <i class="fas {{ $category->status ? 'fa-check-circle' : 'fa-ban' }}"></i>
                            Current Status: {{ $category->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    
                    <!-- Info Alert -->
                    <div class="alert-premium mb-4">
                        <i class="fas fa-info-circle fa-lg"></i>
                        <span>Update the category details below. Fields marked with <span class="text-danger">*</span> are required.</span>
                    </div>

                    <form action="{{ route('categories.update', $category->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="categoryForm"
                          novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Category Name -->
                        <div class="mb-4">
                            <label class="form-label required-field">
                                <i class="fas fa-tag text-warning"></i>
                                Category Name
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name) }}"
                                   placeholder="e.g., Electronics, Fashion, Furniture"
                                   required>
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle"></i> 
                                This will be displayed as the category title
                            </small>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Current Icon Display -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-image text-warning"></i>
                                Current Icon
                            </label>
                            <div class="current-image-card">
                                <div class="d-flex align-items-center gap-4 flex-wrap">
                                    @if($category->icon)
                                        <img src="{{ asset('storage/'.$category->icon) }}"
                                             class="current-image"
                                             alt="{{ $category->name }}"
                                             onclick="showImagePreview(this.src)">
                                        <div>
                                            <small class="text-muted d-block">
                                                <i class="fas fa-info-circle"></i> Current image
                                            </small>
                                            <small class="text-muted">
                                                Click image to preview
                                            </small>
                                        </div>
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mb-0 mt-2">No image uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Change Icon -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-upload text-warning"></i>
                                Change Icon (Optional)
                            </label>
                            
                            <div class="image-preview-container" id="imagePreviewContainer">
                                <input type="file"
                                       name="icon"
                                       id="icon"
                                       class="d-none"
                                       accept="image/*">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-warning mb-2"></i>
                                    <p class="text-muted mb-0">
                                        Click to upload new image or drag and drop
                                    </p>
                                    <small class="text-muted">
                                        PNG, JPG, JPEG up to 2MB (Leave empty to keep current image)
                                    </small>
                                </div>
                                <img id="previewImg" class="preview-img" alt="Preview">
                            </div>
                            
                            @error('icon')
                                <div class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Status Selection -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-toggle-on text-warning"></i>
                                Category Status
                            </label>
                            
                            <div class="d-flex gap-4 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="statusActive" 
                                           value="1" 
                                           {{ old('status', $category->status) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center gap-2" for="statusActive">
                                        <span class="status-badge badge-active">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>
                                        <small class="text-muted">Visible in store and searchable</small>
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="statusInactive" 
                                           value="0" 
                                           {{ old('status', $category->status) == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center gap-2" for="statusInactive">
                                        <span class="status-badge badge-inactive">
                                            <i class="fas fa-ban"></i> Inactive
                                        </span>
                                        <small class="text-muted">Hidden from store temporarily</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="alert alert-info border-0 rounded-3 mb-4" style="background: #eff6ff;">
                            <div class="d-flex gap-3 align-items-start">
                                <i class="fas fa-lightbulb text-info mt-1"></i>
                                <div class="small">
                                    <strong class="d-block mb-1">Category Information:</strong>
                                    <span>ID: <code>#{{ $category->id }}</code> | Slug: <code>{{ $category->slug }}</code></span>
                                    <br>
                                    <span>Created: {{ $category->created_at ? $category->created_at->format('F d, Y h:i A') : 'N/A' }}</span>
                                    <br>
                                    <span>Last Updated: {{ $category->updated_at ? $category->updated_at->diffForHumans() : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-4 pt-2 action-buttons">
                            <button type="submit" class="btn-premium flex-grow-1" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                Update Category
                                <i class="fas fa-spinner fa-spin ms-2 d-none" id="loadingSpinner"></i>
                            </button>
                            
                            <a href="{{ route('categories.index') }}" class="btn-secondary-custom text-center px-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-left me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Help Section -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i> 
                    Secure form with validation | 
                    <i class="fas fa-chart-line ms-2 me-1"></i>
                    Updated changes will reflect immediately
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-header border-0">
                <h5 class="modal-title">Category Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview" style="max-width: 100%; border-radius: 0.75rem;">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Image Preview Function
    function showImagePreview(src) {
        document.getElementById('modalImage').src = src;
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }
    
    // Image Upload Preview Functionality
    const iconInput = document.getElementById('icon');
    const previewImg = document.getElementById('previewImg');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    
    // Trigger file input when clicking preview container
    previewContainer.addEventListener('click', function() {
        iconInput.click();
    });
    
    // Handle file selection
    iconInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload only JPG, JPEG, or PNG files.');
                iconInput.value = '';
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                iconInput.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                uploadPlaceholder.style.display = 'none';
                previewContainer.style.borderColor = '#f59e0b';
                previewContainer.style.background = '#fffbeb';
            };
            reader.readAsDataURL(file);
        } else {
            // Reset preview
            previewImg.style.display = 'none';
            uploadPlaceholder.style.display = 'block';
            previewContainer.style.borderColor = '#cbd5e1';
            previewContainer.style.background = '#f8fafc';
        }
    });
    
    // Drag and drop functionality
    previewContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        previewContainer.style.borderColor = '#f59e0b';
        previewContainer.style.background = '#fffbeb';
    });
    
    previewContainer.addEventListener('dragleave', function(e) {
        e.preventDefault();
        previewContainer.style.borderColor = '#cbd5e1';
        previewContainer.style.background = '#f8fafc';
    });
    
    previewContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file && (file.type === 'image/jpeg' || file.type === 'image/jpg' || file.type === 'image/png')) {
            iconInput.files = e.dataTransfer.files;
            // Trigger change event
            const event = new Event('change');
            iconInput.dispatchEvent(event);
        } else {
            alert('Please drop a valid image file (JPG, JPEG, PNG)');
        }
        previewContainer.style.borderColor = '#cbd5e1';
        previewContainer.style.background = '#f8fafc';
    });
    
    // Form submission with loading state
    const form = document.getElementById('categoryForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    form.addEventListener('submit', function(e) {
        const nameInput = document.getElementById('name');
        
        // Client-side validation
        if (!nameInput.value.trim()) {
            e.preventDefault();
            nameInput.classList.add('is-invalid');
            nameInput.focus();
            
            // Show error message
            let errorDiv = nameInput.parentElement.querySelector('.invalid-feedback');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Category name is required';
                nameInput.parentElement.appendChild(errorDiv);
            }
            
            // Scroll to error
            nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.classList.remove('d-none');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Updating Category...';
    });
    
    // Real-time validation for name field
    const nameField = document.getElementById('name');
    nameField.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });
    
    // Remove validation on focus
    nameField.addEventListener('focus', function() {
        this.classList.remove('is-invalid');
    });
    
    // Initialize validation class if name exists
    if (nameField.value.trim()) {
        nameField.classList.add('is-valid');
    }
    
    // Status radio buttons animation
    const statusRadios = document.querySelectorAll('input[name="status"]');
    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const badges = document.querySelectorAll('.status-badge');
            badges.forEach(badge => {
                badge.style.transform = 'scale(1)';
            });
            if (this.checked) {
                const badge = this.nextElementSibling.querySelector('.status-badge');
                if (badge) {
                    badge.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        badge.style.transform = 'scale(1)';
                    }, 200);
                }
            }
        });
    });
    
    // Warn before leaving if changes are made
    let formChanged = false;
    const formInputs = document.querySelectorAll('#categoryForm input, #categoryForm select');
    formInputs.forEach(input => {
        input.addEventListener('input', () => { formChanged = true; });
    });
    
    window.addEventListener('beforeunload', (e) => {
        if (formChanged && !submitBtn.disabled) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    form.addEventListener('submit', () => {
        formChanged = false;
    });
    
    // Console greeting
    console.log('%c✨ EktaMart Admin | Edit Category Page Loaded ✨', 'color: #f59e0b; font-size: 14px; font-weight: bold;');
    console.log('%c⚡ Features: Image preview • Drag & drop upload • Real-time validation • Unsaved changes warning', 'color: #d97706; font-size: 12px;');
    
    // Tooltip initialization (if Bootstrap JS available)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
</script>

<style>
    /* Additional styles */
    .is-valid {
        border-color: #10b981 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }
    
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    /* Image hover effect */
    .current-image {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-header-premium {
            flex-direction: column;
            text-align: center;
        }
        
        .card-header-premium .ms-auto {
            margin-left: 0 !important;
            margin-top: 1rem;
        }
    }
</style>
@endsection