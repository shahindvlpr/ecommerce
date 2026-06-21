@extends('layouts.admin')

@section('title', 'SEO Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-purple bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-search text-purple"></i>
                </span>
                SEO Settings
            </h4>
            <p class="text-muted small mb-0">Optimize your store for search engines and improve visibility</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </button>
            <a href="#" class="btn btn-outline-info btn-sm px-3" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> Preview
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ALERT MESSAGES --}}
    {{-- ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle text-success fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle text-danger fs-5"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-times-circle text-danger fs-5 mt-1"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- ============================================================ --}}
        {{-- SIDEBAR --}}
        {{-- ============================================================ --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-2">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.settings.index') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                            <span class="bg-primary bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-globe text-primary"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">General</span>
                                <small class="text-muted">Store information</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.payment') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.payment') ? 'active' : '' }}">
                            <span class="bg-success bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-credit-card text-success"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Payment</span>
                                <small class="text-muted">Gateway settings</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.shipping') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.shipping') ? 'active' : '' }}">
                            <span class="bg-info bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-truck text-info"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Shipping</span>
                                <small class="text-muted">Delivery methods</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.email') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.email') ? 'active' : '' }}">
                            <span class="bg-warning bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-envelope text-warning"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Email</span>
                                <small class="text-muted">SMTP configuration</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.settings.seo') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.seo') ? 'active' : '' }}">
                            <span class="bg-purple bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-search text-purple"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">SEO</span>
                                <small class="text-muted">Meta &amp; optimization</small>
                            </div>
                            @if(request()->routeIs('admin.settings.seo'))
                                <span class="ms-auto">
                                    <i class="fas fa-check-circle text-purple"></i>
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('admin.settings.social') }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 mb-1 {{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">
                            <span class="bg-pink bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-share-alt text-pink"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Social</span>
                                <small class="text-muted">Social media links</small>
                            </div>
                        </a>

                        <hr class="my-2">

                        <a href="#" 
                           class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3 rounded-3 text-danger"
                           onclick="event.preventDefault(); if(confirm('Clear all cache?')) document.getElementById('clear-cache-form').submit();">
                            <span class="bg-danger bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-broom text-danger"></i>
                            </span>
                            <div>
                                <span class="fw-semibold d-block">Clear Cache</span>
                                <small class="text-muted">Clear application cache</small>
                            </div>
                        </a>
                        <form id="clear-cache-form" action="{{ route('admin.settings.clear-cache') }}" method="POST" style="display:none;">
                            @csrf
                            @method('POST')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MAIN CONTENT --}}
        {{-- ============================================================ --}}
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-purple bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-search text-purple fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">SEO Configuration</h6>
                            <p class="text-muted small mb-0">Meta tags, descriptions, and search engine optimization</p>
                        </div>
                        <span class="ms-auto">
                            <span class="badge bg-purple bg-opacity-10 text-purple px-3 py-2 rounded-pill">
                                <i class="fas fa-circle text-purple me-1" style="font-size: 8px;"></i> 
                                {{ count(array_filter($settings['seo'] ?? [])) }} Fields
                            </span>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.seo') }}" method="POST" id="seoForm">
                        @csrf
                        @method('POST')

                        {{-- SEO Title --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-tag text-purple me-2"></i>Meta Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="seo_title" 
                                               class="form-control @error('seo_title') is-invalid @enderror" 
                                               id="seo_title" 
                                               placeholder="SEO Title"
                                               value="{{ old('seo_title', $settings['seo']['seo_title'] ?? 'EktaMart - Best Online Store') }}"
                                               maxlength="60">
                                        <label for="seo_title">
                                            <i class="fas fa-tag text-muted me-2"></i>SEO Title
                                        </label>
                                        @error('seo_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Recommended: 50-60 characters
                                        </small>
                                        <small class="text-muted">
                                            <span id="titleCounter">0</span>/60
                                        </small>
                                    </div>
                                </div>

                                {{-- SEO Description --}}
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="seo_description" 
                                                  class="form-control @error('seo_description') is-invalid @enderror" 
                                                  id="seo_description" 
                                                  placeholder="SEO Description" 
                                                  rows="3" 
                                                  style="height: 100px;"
                                                  maxlength="160">{{ old('seo_description', $settings['seo']['seo_description'] ?? 'Your trusted online store for quality products at affordable prices.') }}</textarea>
                                        <label for="seo_description">
                                            <i class="fas fa-align-left text-muted me-2"></i>SEO Description
                                        </label>
                                        @error('seo_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Recommended: 150-160 characters
                                        </small>
                                        <small class="text-muted">
                                            <span id="descriptionCounter">0</span>/160
                                        </small>
                                    </div>
                                </div>

                                {{-- SEO Keywords --}}
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="seo_keywords" 
                                               class="form-control @error('seo_keywords') is-invalid @enderror" 
                                               id="seo_keywords" 
                                               placeholder="SEO Keywords"
                                               value="{{ old('seo_keywords', $settings['seo']['seo_keywords'] ?? 'ecommerce, online store, shop, buy, products') }}">
                                        <label for="seo_keywords">
                                            <i class="fas fa-key text-muted me-2"></i>SEO Keywords
                                        </label>
                                        @error('seo_keywords')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Enter keywords separated by commas (e.g., ecommerce, online store, shop)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Social Media Meta Tags --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-share-alt text-purple me-2"></i>Social Media Meta Tags
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="og_title" 
                                               class="form-control @error('og_title') is-invalid @enderror" 
                                               id="og_title" 
                                               placeholder="OG Title"
                                               value="{{ old('og_title', $settings['seo']['og_title'] ?? '') }}">
                                        <label for="og_title">
                                            <i class="fab fa-facebook text-primary me-2"></i>OG Title (Facebook)
                                        </label>
                                        @error('og_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Open Graph title for Facebook sharing</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="og_description" 
                                               class="form-control @error('og_description') is-invalid @enderror" 
                                               id="og_description" 
                                               placeholder="OG Description"
                                               value="{{ old('og_description', $settings['seo']['og_description'] ?? '') }}">
                                        <label for="og_description">
                                            <i class="fab fa-facebook text-primary me-2"></i>OG Description (Facebook)
                                        </label>
                                        @error('og_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Open Graph description for Facebook sharing</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="twitter_title" 
                                               class="form-control @error('twitter_title') is-invalid @enderror" 
                                               id="twitter_title" 
                                               placeholder="Twitter Title"
                                               value="{{ old('twitter_title', $settings['seo']['twitter_title'] ?? '') }}">
                                        <label for="twitter_title">
                                            <i class="fab fa-twitter text-info me-2"></i>Twitter Title
                                        </label>
                                        @error('twitter_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Title for Twitter card sharing</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="twitter_description" 
                                               class="form-control @error('twitter_description') is-invalid @enderror" 
                                               id="twitter_description" 
                                               placeholder="Twitter Description"
                                               value="{{ old('twitter_description', $settings['seo']['twitter_description'] ?? '') }}">
                                        <label for="twitter_description">
                                            <i class="fab fa-twitter text-info me-2"></i>Twitter Description
                                        </label>
                                        @error('twitter_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Description for Twitter card sharing</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Additional SEO Settings --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-cog text-purple me-2"></i>Additional Settings
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="sitemap_enabled" id="sitemapEnabled"
                                               {{ ($settings['seo']['sitemap_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="sitemapEnabled">
                                            <i class="fas fa-sitemap text-primary me-2"></i>XML Sitemap
                                        </label>
                                        <p class="text-muted small mb-0">Generate XML sitemap automatically</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="robots_enabled" id="robotsEnabled"
                                               {{ ($settings['seo']['robots_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="robotsEnabled">
                                            <i class="fas fa-robot text-success me-2"></i>Robots.txt
                                        </label>
                                        <p class="text-muted small mb-0">Enable robots.txt file generation</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-purple px-4 text-white">
                                <i class="fas fa-save me-2"></i> Save SEO Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <button type="button" class="btn btn-outline-info px-4 ms-auto" onclick="checkSEO()">
                                <i class="fas fa-check-circle me-2"></i> Check SEO
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SEO Quick Tips --}}
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>Title Tips
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Do:</strong> Use primary keyword at the start<br>
                                <strong>Don't:</strong> Exceed 60 characters<br>
                                <strong>Tip:</strong> Add brand name at the end
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-align-left text-info me-2"></i>Description Tips
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Do:</strong> Include primary &amp; secondary keywords<br>
                                <strong>Don't:</strong> Use generic descriptions<br>
                                <strong>Tip:</strong> Add a call to action
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-share-alt text-success me-2"></i>Social Tips
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Do:</strong> Optimize for sharing<br>
                                <strong>Don't:</strong> Skip social meta tags<br>
                                <strong>Tip:</strong> Use engaging titles
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    .list-group-item.active {
        background: linear-gradient(135deg, #ede9fe, #c4b5fd) !important;
        border-color: transparent !important;
        color: #5b21b6 !important;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.15);
    }
    .list-group-item-action {
        transition: all 0.3s ease;
    }
    .list-group-item-action:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }
    .list-group-item-action.active:hover {
        transform: translateX(4px);
    }
    .bg-purple {
        background: #7c3aed;
    }
    .text-purple {
        color: #7c3aed;
    }
    .bg-pink {
        background: #ec4899;
    }
    .text-pink {
        color: #ec4899;
    }
    .btn-purple {
        background: #7c3aed;
        border-color: #7c3aed;
    }
    .btn-purple:hover {
        background: #6d28d9;
        border-color: #6d28d9;
    }
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    .form-floating > .form-control,
    .form-floating > .form-select {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .form-floating > label {
        color: #6b7280;
    }
    .sticky-top {
        z-index: 10;
    }
    .form-check.form-switch {
        background: #f9fafb;
        transition: all 0.3s ease;
    }
    .form-check.form-switch:hover {
        background: #f3f4f6;
    }
    .form-check-input:checked {
        background-color: #7c3aed;
        border-color: #7c3aed;
    }
    textarea.form-control {
        resize: vertical;
    }
</style>
@endpush

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counters
        const titleInput = document.getElementById('seo_title');
        const descriptionInput = document.getElementById('seo_description');
        const titleCounter = document.getElementById('titleCounter');
        const descriptionCounter = document.getElementById('descriptionCounter');

        function updateTitleCounter() {
            const length = titleInput.value.length;
            titleCounter.textContent = length;
            titleCounter.style.color = length > 60 ? '#dc2626' : length > 50 ? '#f59e0b' : '#6b7280';
        }

        function updateDescriptionCounter() {
            const length = descriptionInput.value.length;
            descriptionCounter.textContent = length;
            descriptionCounter.style.color = length > 160 ? '#dc2626' : length > 150 ? '#f59e0b' : '#6b7280';
        }

        titleInput?.addEventListener('input', updateTitleCounter);
        descriptionInput?.addEventListener('input', updateDescriptionCounter);
        updateTitleCounter();
        updateDescriptionCounter();

        // Form validation
        const form = document.getElementById('seoForm');
        form.addEventListener('submit', function(e) {
            const title = document.getElementById('seo_title').value.trim();
            const description = document.getElementById('seo_description').value.trim();
            
            if (!title) {
                e.preventDefault();
                alert('Please enter an SEO Title.');
                return false;
            }
            
            if (title.length > 60) {
                e.preventDefault();
                alert('SEO Title should not exceed 60 characters. Current: ' + title.length);
                return false;
            }
            
            if (!description) {
                e.preventDefault();
                alert('Please enter an SEO Description.');
                return false;
            }
            
            if (description.length > 160) {
                e.preventDefault();
                alert('SEO Description should not exceed 160 characters. Current: ' + description.length);
                return false;
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('seoForm').submit();
            }
        });

        console.log('%c🔍 SEO Settings Loaded', 'color: #7c3aed; font-size: 14px; font-weight: bold;');
        console.log(`%c📝 Title: ${titleInput.value.length} characters`, 'color: #6b7280; font-size: 12px;');
        console.log(`%c📄 Description: ${descriptionInput.value.length} characters`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Press Ctrl+S to save settings');
    });

    // SEO Check Function
    function checkSEO() {
        const title = document.getElementById('seo_title').value.trim();
        const description = document.getElementById('seo_description').value.trim();
        const keywords = document.getElementById('seo_keywords').value.trim();
        
        let issues = [];
        let warnings = [];
        
        // Title checks
        if (!title) {
            issues.push('❌ SEO Title is empty');
        } else if (title.length < 30) {
            warnings.push('⚠️ SEO Title is too short (' + title.length + ' chars). Recommended: 50-60');
        } else if (title.length > 60) {
            warnings.push('⚠️ SEO Title exceeds 60 characters (' + title.length + ' chars)');
        }
        
        // Description checks
        if (!description) {
            issues.push('❌ SEO Description is empty');
        } else if (description.length < 120) {
            warnings.push('⚠️ SEO Description is too short (' + description.length + ' chars). Recommended: 150-160');
        } else if (description.length > 160) {
            warnings.push('⚠️ SEO Description exceeds 160 characters (' + description.length + ' chars)');
        }
        
        // Keywords checks
        if (!keywords) {
            warnings.push('⚠️ SEO Keywords are empty. Consider adding relevant keywords.');
        }
        
        // Show results
        let message = '🔍 SEO Analysis Results:\n\n';
        
        if (issues.length === 0 && warnings.length === 0) {
            message += '✅ Your SEO settings look great!\n\n';
            message += '💡 Tips:\n';
            message += '• Keep monitoring your SEO performance\n';
            message += '• Update content regularly\n';
            message += '• Track your rankings';
        } else {
            if (issues.length > 0) {
                message += '🚫 Critical Issues:\n' + issues.join('\n') + '\n\n';
            }
            if (warnings.length > 0) {
                message += '⚠️ Warnings:\n' + warnings.join('\n') + '\n\n';
            }
            message += '💡 Fix the issues above for better SEO performance.';
        }
        
        alert(message);
    }
</script>
@endpush
@endsection