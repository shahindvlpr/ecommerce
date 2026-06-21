@extends('layouts.admin')

@section('title', 'Edit Banner - EktaMart Admin')
@section('page-title', 'Edit Banner')
@section('icon', 'images')

@section('content')
<div class="container-fluid">
    
    {{-- Back Button --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Banners
                    </a>
                </div>
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-images me-1"></i> Edit Banner
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Form Card --}}
    <div class="card premium-card">
        <div class="card-header-custom">
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon-wrapper">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h5 class="mb-0">Edit Banner</h5>
                    <p class="text-muted small mb-0">Update your banner information</p>
                </div>
            </div>
            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                <i class="fas fa-hashtag me-1"></i> ID: {{ $banner->id }}
            </span>
        </div>
        <div class="card-body-custom">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    
                    {{-- ============================================
                         SECTION 1: BASIC INFORMATION
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">01</span>
                            <h6 class="section-title">Basic Information</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Title <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-heading text-primary"></i></span>
                                <input type="text" name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="e.g. Summer Sale 2024" 
                                       value="{{ old('title', $banner->title) }}" required>
                            </div>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Subtitle --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Subtitle</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-align-left text-primary"></i></span>
                                <input type="text" name="subtitle" 
                                       class="form-control @error('subtitle') is-invalid @enderror" 
                                       placeholder="e.g. Get up to 50% off" 
                                       value="{{ old('subtitle', $banner->subtitle) }}">
                            </div>
                            @error('subtitle')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 2: IMAGES
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">02</span>
                            <h6 class="section-title">Images</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Current Desktop Image --}}
                    <div class="col-md-6">
                        @if($banner->image)
                            <div class="form-group">
                                <label class="form-label fw-semibold">Current Desktop Image</label>
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         alt="{{ $banner->title }}" 
                                         class="current-image-preview">
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                @if($banner->image) Change Desktop Image @else Desktop Image <span class="text-danger">*</span> @endif
                                <span class="label-hint">(1920 x 600px recommended)</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <div class="file-upload-area" id="desktopUploadArea">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click or drag & drop to upload</p>
                                    <small class="text-muted">JPG, PNG, GIF, WebP (Max 2MB)</small>
                                    <input type="file" name="image" 
                                           class="file-upload-input @error('image') is-invalid @enderror" 
                                           accept="image/*" 
                                           id="desktopImageInput">
                                </div>
                                <div class="file-preview" id="desktopPreview" style="display:none;">
                                    <img id="desktopPreviewImage" src="" alt="Preview">
                                    <button type="button" class="file-remove-btn" onclick="removeFile('desktop')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Current Mobile Image --}}
                    <div class="col-md-6">
                        @if($banner->mobile_image)
                            <div class="form-group">
                                <label class="form-label fw-semibold">Current Mobile Image</label>
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $banner->mobile_image) }}" 
                                         alt="{{ $banner->title }}" 
                                         class="current-image-preview">
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                @if($banner->mobile_image) Change Mobile Image @else Mobile Image @endif
                                <span class="label-hint">(768 x 400px recommended)</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <div class="file-upload-area" id="mobileUploadArea">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click or drag & drop to upload</p>
                                    <small class="text-muted">JPG, PNG, GIF, WebP (Max 2MB)</small>
                                    <input type="file" name="mobile_image" 
                                           class="file-upload-input @error('mobile_image') is-invalid @enderror" 
                                           accept="image/*" 
                                           id="mobileImageInput">
                                </div>
                                <div class="file-preview" id="mobilePreview" style="display:none;">
                                    <img id="mobilePreviewImage" src="" alt="Preview">
                                    <button type="button" class="file-remove-btn" onclick="removeFile('mobile')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('mobile_image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 3: LINKS & BUTTONS
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">03</span>
                            <h6 class="section-title">Links & Buttons</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- URL --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Banner URL</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-link text-primary"></i></span>
                                <input type="url" name="url" 
                                       class="form-control @error('url') is-invalid @enderror" 
                                       placeholder="https://example.com" 
                                       value="{{ old('url', $banner->url) }}">
                            </div>
                            <small class="text-muted">Where the banner should link to</small>
                            @error('url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Button Text --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Button Text</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-font text-primary"></i></span>
                                <input type="text" name="button_text" 
                                       class="form-control @error('button_text') is-invalid @enderror" 
                                       placeholder="Shop Now" 
                                       value="{{ old('button_text', $banner->button_text) }}">
                            </div>
                            @error('button_text')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Button URL --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Button URL</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-arrow-right text-primary"></i></span>
                                <input type="url" name="button_url" 
                                       class="form-control @error('button_url') is-invalid @enderror" 
                                       placeholder="https://example.com/shop" 
                                       value="{{ old('button_url', $banner->button_url) }}">
                            </div>
                            @error('button_url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 4: DISPLAY SETTINGS
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">04</span>
                            <h6 class="section-title">Display Settings</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Position --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Position</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-map-pin text-primary"></i></span>
                                <input type="text" name="position" 
                                       class="form-control @error('position') is-invalid @enderror" 
                                       placeholder="Home" 
                                       value="{{ old('position', $banner->position ?? 'home') }}">
                            </div>
                            <small class="text-muted">e.g. home, header, sidebar</small>
                            @error('position')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Order --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Display Order</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-up text-primary"></i></span>
                                <input type="number" name="order" 
                                       class="form-control @error('order') is-invalid @enderror" 
                                       placeholder="0" min="0" 
                                       value="{{ old('order', $banner->order ?? 0) }}">
                            </div>
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('order')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Type --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Type</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-tag text-primary"></i></span>
                                <input type="text" name="type" 
                                       class="form-control @error('type') is-invalid @enderror" 
                                       placeholder="banner" 
                                       value="{{ old('type', $banner->type ?? 'banner') }}">
                            </div>
                            <small class="text-muted">e.g. banner, slider, promo</small>
                            @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="status-toggle-wrapper">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="status" class="form-check-input" id="status" 
                                           value="1" {{ old('status', $banner->status) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="status">
                                        <span class="status-text {{ old('status', $banner->status) ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-circle me-1"></i>
                                            {{ old('status', $banner->status) ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 5: DATE SCHEDULE
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">05</span>
                            <h6 class="section-title">Date Schedule</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">Start Date</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                                <input type="date" name="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date', $banner->start_date ? $banner->start_date->format('Y-m-d') : '') }}">
                            </div>
                            <small class="text-muted">Leave empty for immediate start</small>
                            @error('start_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">End Date</label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-calendar-check text-primary"></i></span>
                                <input type="date" name="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date', $banner->end_date ? $banner->end_date->format('Y-m-d') : '') }}">
                            </div>
                            <small class="text-muted">Leave empty for no expiry</small>
                            @error('end_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-premium">
                                <i class="fas fa-save me-2"></i> Update Banner
                            </button>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-danger btn-premium">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* Same styles as create.blade.php plus */
.current-image {
    margin-bottom: 10px;
}
.current-image-preview {
    max-width: 100%;
    max-height: 80px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

/* ============================================================
   PREMIUM CARD
============================================================ */
.premium-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.premium-card:hover {
    box-shadow: var(--shadow-md);
}

.card-header-custom {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    background: linear-gradient(135deg, rgba(139,92,246,0.03), rgba(99,102,241,0.03));
}

.header-icon-wrapper {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
}

.card-header-custom h5 {
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.card-body-custom {
    padding: 28px 24px;
}

/* ============================================================
   SECTION HEADER
============================================================ */
.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border-color);
}

.section-number {
    font-size: 11px;
    font-weight: 700;
    color: #8B5CF6;
    background: rgba(139,92,246,0.1);
    padding: 2px 10px;
    border-radius: 20px;
    letter-spacing: 0.5px;
}

.section-title {
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    font-size: 14px;
}

.section-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, var(--border-color), transparent);
}

/* ============================================================
   FORM GROUP
============================================================ */
.form-group {
    margin-bottom: 8px;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.label-hint {
    font-size: 11px;
    font-weight: 400;
    color: var(--text-muted);
}

.input-group-premium {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    transition: all 0.3s ease;
}
.input-group-premium:focus-within {
    box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
}

.input-group-premium .input-group-text {
    background: var(--bg-body);
    border: 1px solid var(--border-color);
    color: var(--text-muted);
    font-size: 14px;
    padding: 10px 14px;
    min-width: 44px;
    justify-content: center;
}

.input-group-premium .form-control,
.input-group-premium .form-select {
    border: 1px solid var(--border-color);
    padding: 10px 14px;
    font-size: 14px;
    color: var(--text-primary);
    background: var(--bg-card);
    transition: all 0.3s ease;
}
.input-group-premium .form-control:focus,
.input-group-premium .form-select:focus {
    border-color: #8B5CF6;
    box-shadow: none;
}
.input-group-premium .form-control::placeholder {
    color: var(--text-muted);
}

/* ============================================================
   FILE UPLOAD
============================================================ */
.file-upload-wrapper {
    position: relative;
}

.file-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 10px;
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: var(--bg-body);
}
.file-upload-area:hover {
    border-color: #8B5CF6;
    background: rgba(139,92,246,0.02);
}
.file-upload-area i {
    font-size: 36px;
    color: var(--text-muted);
    opacity: 0.5;
    display: block;
    margin-bottom: 8px;
}
.file-upload-area p {
    font-weight: 500;
    color: var(--text-primary);
    margin: 0;
}
.file-upload-area small {
    color: var(--text-muted);
}

.file-upload-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-preview {
    position: relative;
    display: none;
    margin-top: 10px;
}
.file-preview img {
    max-width: 100%;
    max-height: 150px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.file-remove-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: #EF4444;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
}
.file-remove-btn:hover {
    transform: scale(1.1);
}

.current-image {
    margin-bottom: 10px;
}
.current-image-preview {
    max-width: 100%;
    max-height: 80px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

/* ============================================================
   STATUS TOGGLE
============================================================ */
.status-toggle-wrapper {
    background: var(--bg-body);
    border-radius: 10px;
    padding: 12px 16px;
    border: 1px solid var(--border-color);
}

.status-text {
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

/* ============================================================
   FORM ACTIONS
============================================================ */
.form-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
    margin-top: 8px;
}

.btn-premium {
    padding: 10px 28px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}
.btn-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .card-body-custom {
        padding: 16px;
    }
    .card-header-custom {
        padding: 16px;
    }
    .form-actions {
        flex-direction: column;
    }
    .form-actions .btn-premium {
        width: 100%;
        justify-content: center;
    }
    .file-upload-area {
        padding: 20px 16px;
    }
}

@media (max-width: 576px) {
    .card-body-custom {
        padding: 12px;
    }
    .input-group-premium .form-control,
    .input-group-premium .form-select {
        font-size: 13px;
        padding: 8px 12px;
    }
    .file-upload-area i {
        font-size: 28px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .card-header-custom {
    background: linear-gradient(135deg, rgba(139,92,246,0.06), rgba(99,102,241,0.04));
}
[data-theme="dark"] .status-toggle-wrapper {
    background: rgba(255,255,255,0.02);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================================
    // FILE UPLOAD PREVIEW
    // ============================================================
    function setupFileUpload(type) {
        const input = document.getElementById(type + 'ImageInput');
        const uploadArea = document.getElementById(type + 'UploadArea');
        const preview = document.getElementById(type + 'Preview');
        const previewImage = document.getElementById(type + 'PreviewImage');

        if (!input) return;

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    uploadArea.style.display = 'none';
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    setupFileUpload('desktop');
    setupFileUpload('mobile');

    // ============================================================
    // REMOVE FILE
    // ============================================================
    window.removeFile = function(type) {
        const input = document.getElementById(type + 'ImageInput');
        const uploadArea = document.getElementById(type + 'UploadArea');
        const preview = document.getElementById(type + 'Preview');

        input.value = '';
        uploadArea.style.display = 'block';
        preview.style.display = 'none';
    };

    // ============================================================
    // DRAG & DROP
    // ============================================================
    document.querySelectorAll('.file-upload-area').forEach(area => {
        area.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#8B5CF6';
            this.style.background = 'rgba(139,92,246,0.05)';
        });
        area.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '';
            this.style.background = '';
        });
        area.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '';
            this.style.background = '';
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const input = this.querySelector('.file-upload-input');
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });

    // ============================================================
    // STATUS TOGGLE TEXT UPDATE
    // ============================================================
    const statusToggle = document.getElementById('status');
    const statusText = document.querySelector('.status-text');
    
    if (statusToggle) {
        statusToggle.addEventListener('change', function() {
            if (this.checked) {
                statusText.innerHTML = '<i class="fas fa-circle me-1"></i> Active';
                statusText.className = 'status-text text-success';
            } else {
                statusText.innerHTML = '<i class="fas fa-circle me-1"></i> Inactive';
                statusText.className = 'status-text text-danger';
            }
        });
    }

    console.log('%c🖼️ Banner Edit Page Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush