{{-- resources/views/admin/category/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create Category - EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-5">
    
    <!-- Animated Background Effects -->
    <style>
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
        
        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slide-left {
            animation: slideInLeft 0.5s ease-out forwards;
        }
        
        .category-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .form-control, .form-select {
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        }
        
        .btn-premium {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 92, 246, 0.3);
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
        }
        
        .btn-secondary-custom {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(71, 85, 105, 0.3);
        }
        
        .image-preview {
            border: 2px dashed #cbd5e1;
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .image-preview:hover {
            border-color: #8b5cf6;
            background: #f5f3ff;
        }
        
        .preview-img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            display: none;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .badge-active {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-custom .breadcrumb-item a {
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .breadcrumb-custom .breadcrumb-item.active {
            color: #64748b;
        }
        
        .required-field::after {
            content: '*';
            color: #ef4444;
            margin-left: 0.25rem;
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
                    <i class="fas fa-plus-circle me-1"></i> Create Category
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="row justify-content-center animate-fade-up">
        <div class="col-lg-8 col-md-10">
            <div class="card category-card shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-gradient-primary p-3" style="background: linear-gradient(135deg, #8b5cf6, #6366f1);">
                            <i class="fas fa-layer-group text-white fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-dark">Create New Category</h4>
                            <p class="text-muted mb-0 small">Add a new product category to your ecommerce store</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('categories.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="categoryForm"
                          novalidate>
                        @csrf

                        <!-- Category Name -->
                        <div class="mb-4">
                            <label class="form-label required-field">
                                <i class="fas fa-tag text-purple-600"></i>
                                Category Name
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="e.g., Electronics, Fashion, Furniture"
                                   required>
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle"></i> 
                                Enter a unique and descriptive category name
                            </small>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Category Icon / Image -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-image text-purple-600"></i>
                                Category Icon / Image
                            </label>
                            
                            <div class="image-preview" id="imagePreviewContainer">
                                <input type="file"
                                       name="icon"
                                       id="icon"
                                       class="d-none"
                                       accept="image/*">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-purple-400 mb-2"></i>
                                    <p class="text-muted mb-0">
                                        Click to upload or drag and drop
                                    </p>
                                    <small class="text-muted">
                                        PNG, JPG, JPEG up to 2MB
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

                        <!-- Status Selection with Toggle Style -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-toggle-on text-purple-600"></i>
                                Category Status
                            </label>
                            
                            <div class="d-flex gap-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="statusActive" 
                                           value="1" 
                                           {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center gap-2" for="statusActive">
                                        <span class="status-badge badge-active">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>
                                        <small class="text-muted">Visible in store</small>
                                    </label>
                                </div>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="statusInactive" 
                                           value="0" 
                                           {{ old('status') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center gap-2" for="statusInactive">
                                        <span class="status-badge badge-inactive">
                                            <i class="fas fa-ban"></i> Inactive
                                        </span>
                                        <small class="text-muted">Hidden from store</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info Card (Optional Enhancement) -->
                        <div class="alert alert-info border-0 rounded-3 mb-4" style="background: #eff6ff;">
                            <div class="d-flex gap-3 align-items-start">
                                <i class="fas fa-lightbulb text-info mt-1"></i>
                                <div class="small">
                                    <strong class="d-block mb-1">Pro Tip:</strong>
                                    <span>Categories help organize your products. Use clear, descriptive names and add relevant icons to improve navigation.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-4 pt-2">
                            <button type="submit" class="btn-premium text-white flex-grow-1" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                Create Category
                                <i class="fas fa-spinner fa-spin ms-2 d-none" id="loadingSpinner"></i>
                            </button>
                            
                            <a href="{{ route('categories.index') }}" class="btn-secondary-custom text-white text-decoration-none text-center px-4 d-flex align-items-center">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back
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
                    Categories improve SEO and user experience
                </small>
            </div>
        </div>
    </div>
</div>

<script>
    // Image Preview Functionality
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
                previewContainer.style.borderColor = '#8b5cf6';
                previewContainer.style.background = '#f5f3ff';
            };
            reader.readAsDataURL(file);
        } else {
            // Reset preview
            previewImg.style.display = 'none';
            uploadPlaceholder.style.display = 'block';
            previewContainer.style.borderColor = '#cbd5e1';
            previewContainer.style.background = 'transparent';
        }
    });
    
    // Drag and drop functionality
    previewContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        previewContainer.style.borderColor = '#8b5cf6';
        previewContainer.style.background = '#f5f3ff';
    });
    
    previewContainer.addEventListener('dragleave', function(e) {
        e.preventDefault();
        previewContainer.style.borderColor = '#cbd5e1';
        previewContainer.style.background = 'transparent';
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
        previewContainer.style.background = 'transparent';
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
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Category name is required';
            
            const parent = nameInput.parentElement;
            const existingError = parent.querySelector('.invalid-feedback');
            if (existingError) existingError.remove();
            parent.appendChild(errorDiv);
            
            // Scroll to error
            nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.classList.remove('d-none');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Creating Category...';
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
    
    // Initialize any old values
    if (nameField.value.trim()) {
        nameField.classList.add('is-valid');
    }
    
    // Status radio buttons animation
    const statusRadios = document.querySelectorAll('input[name="status"]');
    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const labels = document.querySelectorAll('.status-badge');
            labels.forEach(label => {
                label.style.transform = 'scale(1)';
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
    
    // Console greeting
    console.log('%c✨ EktaMart Admin | Create Category Page Loaded ✨', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
    console.log('%c⚡ Features: Image preview • Drag & drop upload • Real-time validation • Smooth animations', 'color: #6366f1; font-size: 12px;');
</script>

<style>
    /* Additional custom styles */
    .form-check-input:checked {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.25);
        border-color: #8b5cf6;
    }
    
    .is-valid {
        border-color: #10b981 !important;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
    
    .btn-premium:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    /* Smooth transitions */
    .category-card, .btn-premium, .btn-secondary-custom, .form-control, .form-select, .image-preview {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endsection