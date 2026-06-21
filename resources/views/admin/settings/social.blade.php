@extends('layouts.admin')

@section('title', 'Social Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-pink bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-share-alt text-pink"></i>
                </span>
                Social Media Settings
            </h4>
            <p class="text-muted small mb-0">Connect your store with social media platforms and grow your audience</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </button>
            <a href="#" class="btn btn-outline-primary btn-sm px-3" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> View Store
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
                            @if(request()->routeIs('admin.settings.social'))
                                <span class="ms-auto">
                                    <i class="fas fa-check-circle text-pink"></i>
                                </span>
                            @endif
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
                        <div class="bg-pink bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-share-alt text-pink fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Social Media Links</h6>
                            <p class="text-muted small mb-0">Add your social media profile URLs to connect with customers</p>
                        </div>
                        <span class="ms-auto">
                            <span class="badge bg-pink bg-opacity-10 text-pink px-3 py-2 rounded-pill">
                                <i class="fas fa-circle text-pink me-1" style="font-size: 8px;"></i> 
                                {{ count(array_filter($settings['social'] ?? [])) }} Connected
                            </span>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.social') }}" method="POST" id="socialForm">
                        @csrf
                        @method('POST')

                        {{-- Social Media Platforms --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-hashtag text-pink me-2"></i>Social Platforms
                            </h6>
                            <div class="row g-3">
                                {{-- Facebook --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="facebook" 
                                               class="form-control @error('facebook') is-invalid @enderror" 
                                               id="facebook" 
                                               placeholder="Facebook URL"
                                               value="{{ old('facebook', $settings['social']['facebook'] ?? '') }}">
                                        <label for="facebook">
                                            <i class="fab fa-facebook text-primary me-2"></i>Facebook
                                        </label>
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['facebook']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- Twitter/X --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="twitter" 
                                               class="form-control @error('twitter') is-invalid @enderror" 
                                               id="twitter" 
                                               placeholder="Twitter URL"
                                               value="{{ old('twitter', $settings['social']['twitter'] ?? '') }}">
                                        <label for="twitter">
                                            <i class="fab fa-twitter text-info me-2"></i>Twitter/X
                                        </label>
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['twitter']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- Instagram --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="instagram" 
                                               class="form-control @error('instagram') is-invalid @enderror" 
                                               id="instagram" 
                                               placeholder="Instagram URL"
                                               value="{{ old('instagram', $settings['social']['instagram'] ?? '') }}">
                                        <label for="instagram">
                                            <i class="fab fa-instagram text-danger me-2"></i>Instagram
                                        </label>
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['instagram']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- YouTube --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="youtube" 
                                               class="form-control @error('youtube') is-invalid @enderror" 
                                               id="youtube" 
                                               placeholder="YouTube URL"
                                               value="{{ old('youtube', $settings['social']['youtube'] ?? '') }}">
                                        <label for="youtube">
                                            <i class="fab fa-youtube text-danger me-2"></i>YouTube
                                        </label>
                                        @error('youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['youtube']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- LinkedIn --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="linkedin" 
                                               class="form-control @error('linkedin') is-invalid @enderror" 
                                               id="linkedin" 
                                               placeholder="LinkedIn URL"
                                               value="{{ old('linkedin', $settings['social']['linkedin'] ?? '') }}">
                                        <label for="linkedin">
                                            <i class="fab fa-linkedin text-primary me-2"></i>LinkedIn
                                        </label>
                                        @error('linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['linkedin']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- Pinterest --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="pinterest" 
                                               class="form-control @error('pinterest') is-invalid @enderror" 
                                               id="pinterest" 
                                               placeholder="Pinterest URL"
                                               value="{{ old('pinterest', $settings['social']['pinterest'] ?? '') }}">
                                        <label for="pinterest">
                                            <i class="fab fa-pinterest text-danger me-2"></i>Pinterest
                                        </label>
                                        @error('pinterest')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['pinterest']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- TikTok --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="tiktok" 
                                               class="form-control @error('tiktok') is-invalid @enderror" 
                                               id="tiktok" 
                                               placeholder="TikTok URL"
                                               value="{{ old('tiktok', $settings['social']['tiktok'] ?? '') }}">
                                        <label for="tiktok">
                                            <i class="fab fa-tiktok text-dark me-2"></i>TikTok
                                        </label>
                                        @error('tiktok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['tiktok']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>

                                {{-- WhatsApp --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="url" 
                                               name="whatsapp" 
                                               class="form-control @error('whatsapp') is-invalid @enderror" 
                                               id="whatsapp" 
                                               placeholder="WhatsApp URL"
                                               value="{{ old('whatsapp', $settings['social']['whatsapp'] ?? '') }}">
                                        <label for="whatsapp">
                                            <i class="fab fa-whatsapp text-success me-2"></i>WhatsApp
                                        </label>
                                        @error('whatsapp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!empty($settings['social']['whatsapp']))
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Connected
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Social Display Settings --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-sliders-h text-pink me-2"></i>Display Settings
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="social_icons_footer" id="socialIconsFooter"
                                               {{ ($settings['social']['social_icons_footer'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="socialIconsFooter">
                                            <i class="fas fa-fingerprint text-primary me-2"></i>Show in Footer
                                        </label>
                                        <p class="text-muted small mb-0">Display social media icons in footer</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="social_icons_header" id="socialIconsHeader"
                                               {{ ($settings['social']['social_icons_header'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="socialIconsHeader">
                                            <i class="fas fa-arrow-up text-info me-2"></i>Show in Header
                                        </label>
                                        <p class="text-muted small mb-0">Display social media icons in header</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-pink px-4 text-white">
                                <i class="fas fa-save me-2"></i> Save Social Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <button type="button" class="btn btn-outline-primary px-4 ms-auto" onclick="previewSocial()">
                                <i class="fas fa-eye me-2"></i> Preview
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Social Media Tips --}}
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-rocket text-warning me-2"></i>Best Practices
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Tip 1:</strong> Use consistent branding<br>
                                <strong>Tip 2:</strong> Post regularly<br>
                                <strong>Tip 3:</strong> Engage with followers<br>
                                <strong>Tip 4:</strong> Track analytics
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-hashtag text-info me-2"></i>Popular Platforms
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Facebook:</strong> 2.9B+ users<br>
                                <strong>Instagram:</strong> 1.4B+ users<br>
                                <strong>YouTube:</strong> 2.5B+ users<br>
                                <strong>TikTok:</strong> 1B+ users
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-lightbulb text-success me-2"></i>Growth Tips
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Strategy:</strong> Cross-promote content<br>
                                <strong>Content:</strong> Share user-generated content<br>
                                <strong>Engage:</strong> Reply to comments<br>
                                <strong>Analyze:</strong> Track performance
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
        background: linear-gradient(135deg, #fce7f3, #fbcfe8) !important;
        border-color: transparent !important;
        color: #9d174d !important;
        box-shadow: 0 2px 8px rgba(236, 72, 153, 0.15);
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
    .btn-pink {
        background: #ec4899;
        border-color: #ec4899;
        color: white;
    }
    .btn-pink:hover {
        background: #db2777;
        border-color: #db2777;
        color: white;
    }
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
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
        background-color: #ec4899;
        border-color: #ec4899;
    }
</style>
@endpush

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.getElementById('socialForm');
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[type="url"]');
            let hasValidUrl = false;
            
            inputs.forEach(input => {
                const value = input.value.trim();
                if (value && !isValidUrl(value)) {
                    e.preventDefault();
                    alert('Please enter a valid URL for ' + input.labels[0]?.textContent || 'social media');
                    input.focus();
                    return false;
                }
                if (value) {
                    hasValidUrl = true;
                }
            });
            
            if (!hasValidUrl) {
                if (!confirm('You haven\'t added any social media URLs. Are you sure you want to save?')) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // URL validation helper
        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch {
                return false;
            }
        }

        // Auto-add https:// if missing
        document.querySelectorAll('input[type="url"]').forEach(input => {
            input.addEventListener('blur', function() {
                const value = this.value.trim();
                if (value && !value.startsWith('http://') && !value.startsWith('https://')) {
                    this.value = 'https://' + value;
                }
            });
        });

        // Character counter for social media links
        document.querySelectorAll('input[type="url"]').forEach(input => {
            input.addEventListener('input', function() {
                const parent = this.closest('.col-md-6');
                const status = parent.querySelector('small.text-success');
                if (this.value.trim()) {
                    if (!status) {
                        const newStatus = document.createElement('small');
                        newStatus.className = 'text-success';
                        newStatus.innerHTML = '<i class="fas fa-check-circle me-1"></i>Connected';
                        parent.appendChild(newStatus);
                    }
                } else {
                    if (status) {
                        status.remove();
                    }
                }
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('socialForm').submit();
            }
        });

        // Preview function
        window.previewSocial = function() {
            const facebook = document.getElementById('facebook').value.trim() || 'Not set';
            const twitter = document.getElementById('twitter').value.trim() || 'Not set';
            const instagram = document.getElementById('instagram').value.trim() || 'Not set';
            const youtube = document.getElementById('youtube').value.trim() || 'Not set';
            const linkedin = document.getElementById('linkedin').value.trim() || 'Not set';
            const pinterest = document.getElementById('pinterest').value.trim() || 'Not set';
            
            let message = '👁️ Social Media Preview\n\n';
            message += '📱 Connected Platforms:\n';
            message += `• Facebook: ${facebook !== 'Not set' ? '✅' : '❌'} ${facebook}\n`;
            message += `• Twitter/X: ${twitter !== 'Not set' ? '✅' : '❌'} ${twitter}\n`;
            message += `• Instagram: ${instagram !== 'Not set' ? '✅' : '❌'} ${instagram}\n`;
            message += `• YouTube: ${youtube !== 'Not set' ? '✅' : '❌'} ${youtube}\n`;
            message += `• LinkedIn: ${linkedin !== 'Not set' ? '✅' : '❌'} ${linkedin}\n`;
            message += `• Pinterest: ${pinterest !== 'Not set' ? '✅' : '❌'} ${pinterest}\n\n`;
            
            const total = [facebook, twitter, instagram, youtube, linkedin, pinterest].filter(url => url !== 'Not set').length;
            message += `📊 Total Connected: ${total}/6`;
            
            alert(message);
        };

        console.log('%c📱 Social Settings Loaded', 'color: #ec4899; font-size: 14px; font-weight: bold;');
        const connected = document.querySelectorAll('input[type="url"]').filter(input => input.value.trim()).length;
        console.log(`%c🔗 Connected Platforms: ${connected}`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Press Ctrl+S to save settings');
    });
</script>
@endpush
@endsection