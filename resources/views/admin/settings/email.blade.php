@extends('layouts.admin')

@section('title', 'Email Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-warning bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-envelope text-warning"></i>
                </span>
                Email Settings
            </h4>
            <p class="text-muted small mb-0">Configure your mail server and email notification settings</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="testEmail()">
                <i class="fas fa-paper-plane me-1"></i> Test Email
            </button>
            <button class="btn btn-outline-secondary btn-sm px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </button>
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
                            @if(request()->routeIs('admin.settings.email'))
                                <span class="ms-auto">
                                    <i class="fas fa-check-circle text-warning"></i>
                                </span>
                            @endif
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
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-envelope text-warning fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">SMTP Configuration</h6>
                            <p class="text-muted small mb-0">Configure your mail server settings for sending emails</p>
                        </div>
                        <span class="ms-auto">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                                {{ $settings['email']['mail_host'] ?? 'Not Configured' }}
                            </span>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.email') }}" method="POST" id="emailForm">
                        @csrf
                        @method('POST')

                        {{-- SMTP Configuration --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-server text-warning me-2"></i>SMTP Server Settings
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="mail_host" 
                                               class="form-control @error('mail_host') is-invalid @enderror" 
                                               id="mail_host" 
                                               placeholder="SMTP Host"
                                               value="{{ old('mail_host', $settings['email']['mail_host'] ?? 'smtp.gmail.com') }}">
                                        <label for="mail_host">
                                            <i class="fas fa-server text-muted me-2"></i>SMTP Host
                                        </label>
                                        @error('mail_host')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" 
                                               name="mail_port" 
                                               class="form-control @error('mail_port') is-invalid @enderror" 
                                               id="mail_port" 
                                               placeholder="SMTP Port"
                                               value="{{ old('mail_port', $settings['email']['mail_port'] ?? 587) }}">
                                        <label for="mail_port">
                                            <i class="fas fa-plug text-muted me-2"></i>SMTP Port
                                        </label>
                                        @error('mail_port')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="mail_username" 
                                               class="form-control @error('mail_username') is-invalid @enderror" 
                                               id="mail_username" 
                                               placeholder="SMTP Username"
                                               value="{{ old('mail_username', $settings['email']['mail_username'] ?? '') }}">
                                        <label for="mail_username">
                                            <i class="fas fa-user text-muted me-2"></i>SMTP Username
                                        </label>
                                        @error('mail_username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" 
                                               name="mail_password" 
                                               class="form-control @error('mail_password') is-invalid @enderror" 
                                               id="mail_password" 
                                               placeholder="SMTP Password"
                                               value="{{ old('mail_password', $settings['email']['mail_password'] ?? '') }}">
                                        <label for="mail_password">
                                            <i class="fas fa-lock text-muted me-2"></i>SMTP Password
                                        </label>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <small>Leave blank to keep current password</small>
                                        </div>
                                        @error('mail_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="mail_encryption" 
                                               class="form-control @error('mail_encryption') is-invalid @enderror" 
                                               id="mail_encryption" 
                                               placeholder="Encryption"
                                               value="{{ old('mail_encryption', $settings['email']['mail_encryption'] ?? 'tls') }}">
                                        <label for="mail_encryption">
                                            <i class="fas fa-shield-alt text-muted me-2"></i>Encryption
                                        </label>
                                        <div class="form-text">
                                            <small>Options: tls, ssl, or null</small>
                                        </div>
                                        @error('mail_encryption')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" 
                                               name="mail_from_address" 
                                               class="form-control @error('mail_from_address') is-invalid @enderror" 
                                               id="mail_from_address" 
                                               placeholder="From Address"
                                               value="{{ old('mail_from_address', $settings['email']['mail_from_address'] ?? '') }}">
                                        <label for="mail_from_address">
                                            <i class="fas fa-envelope text-muted me-2"></i>From Address
                                        </label>
                                        @error('mail_from_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Email Templates --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-file-alt text-warning me-2"></i>Email Templates
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="order_confirmation_enabled" id="orderConfirmation"
                                               {{ ($settings['email']['order_confirmation_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="orderConfirmation">
                                            <i class="fas fa-shopping-cart text-primary me-2"></i>Order Confirmation
                                        </label>
                                        <p class="text-muted small mb-0">Send order confirmation emails</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="order_shipped_enabled" id="orderShipped"
                                               {{ ($settings['email']['order_shipped_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="orderShipped">
                                            <i class="fas fa-truck text-info me-2"></i>Order Shipped
                                        </label>
                                        <p class="text-muted small mb-0">Send shipping notifications</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch p-3 border rounded-3">
                                        <input class="form-check-input" type="checkbox" 
                                               name="order_delivered_enabled" id="orderDelivered"
                                               {{ ($settings['email']['order_delivered_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="orderDelivered">
                                            <i class="fas fa-check-circle text-success me-2"></i>Order Delivered
                                        </label>
                                        <p class="text-muted small mb-0">Send delivery confirmation</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fas fa-save me-2"></i> Save Email Settings
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <button type="button" class="btn btn-outline-info px-4 ms-auto" onclick="testEmail()">
                                <i class="fas fa-paper-plane me-2"></i> Send Test Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Quick SMTP Guides --}}
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fab fa-google text-danger me-2"></i>Gmail
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Host:</strong> smtp.gmail.com<br>
                                <strong>Port:</strong> 587<br>
                                <strong>Encryption:</strong> tls<br>
                                <strong>Note:</strong> Use App Password
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>Mailgun
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Host:</strong> smtp.mailgun.org<br>
                                <strong>Port:</strong> 587<br>
                                <strong>Encryption:</strong> tls<br>
                                <strong>Note:</strong> Use your domain
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-server text-success me-2"></i>SendGrid
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Host:</strong> smtp.sendgrid.net<br>
                                <strong>Port:</strong> 587<br>
                                <strong>Encryption:</strong> tls<br>
                                <strong>Note:</strong> API Key required
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- TEST EMAIL MODAL --}}
{{-- ============================================================ --}}
<div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="testEmailModalLabel">
                    <i class="fas fa-paper-plane text-info me-2"></i>Send Test Email
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Send a test email to verify your SMTP configuration is working correctly.</p>
                <div class="form-floating">
                    <input type="email" class="form-control" id="testEmailAddress" 
                           placeholder="test@example.com" 
                           value="{{ $settings['email']['mail_from_address'] ?? '' }}">
                    <label for="testEmailAddress">
                        <i class="fas fa-envelope text-muted me-2"></i>Email Address
                    </label>
                </div>
                <div id="testResult" class="mt-3" style="display:none;"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info text-white" id="sendTestEmailBtn">
                    <i class="fas fa-paper-plane me-2"></i> Send Test Email
                </button>
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
        background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
        border-color: transparent !important;
        color: #92400e !important;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
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
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
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
    .modal-content {
        border: none;
        border-radius: 16px;
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
        const form = document.getElementById('emailForm');
        form.addEventListener('submit', function(e) {
            const host = document.getElementById('mail_host').value.trim();
            const port = document.getElementById('mail_port').value.trim();
            const username = document.getElementById('mail_username').value.trim();
            const from = document.getElementById('mail_from_address').value.trim();
            
            if (!host || !port || !username || !from) {
                e.preventDefault();
                alert('Please fill in all required fields: Host, Port, Username, and From Address');
                return false;
            }
            
            if (port < 1 || port > 65535) {
                e.preventDefault();
                alert('Please enter a valid port number (1-65535)');
                return false;
            }
            
            if (!from.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address for From Address');
                return false;
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('emailForm').submit();
            }
        });

        console.log('%c📧 Email Settings Loaded', 'color: #f59e0b; font-size: 14px; font-weight: bold;');
        console.log(`%c📮 SMTP Host: {{ $settings['email']['mail_host'] ?? 'Not Configured' }}`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Press Ctrl+S to save settings');
    });

    // ============================================================
    // TEST EMAIL FUNCTION
    // ============================================================
    function testEmail() {
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('testEmailModal'));
        modal.show();
        
        // Reset result
        document.getElementById('testResult').style.display = 'none';
    }

    // Send test email via AJAX
    document.getElementById('sendTestEmailBtn')?.addEventListener('click', function() {
        const email = document.getElementById('testEmailAddress').value.trim();
        const resultDiv = document.getElementById('testResult');
        
        if (!email) {
            resultDiv.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3">
                    <i class="fas fa-exclamation-circle me-2"></i> Please enter an email address.
                </div>
            `;
            resultDiv.style.display = 'block';
            return;
        }

        if (!email.includes('@')) {
            resultDiv.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3">
                    <i class="fas fa-exclamation-circle me-2"></i> Please enter a valid email address.
                </div>
            `;
            resultDiv.style.display = 'block';
            return;
        }

        // Show loading state
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `
            <div class="alert alert-info border-0 rounded-3">
                <i class="fas fa-spinner fa-spin me-2"></i> Sending test email to ${email}...
            </div>
        `;

        // AJAX call (you need to implement the route)
        fetch('{{ route("admin.settings.email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="alert alert-success border-0 rounded-3">
                        <i class="fas fa-check-circle me-2"></i> ${data.message || 'Test email sent successfully!'}
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger border-0 rounded-3">
                        <i class="fas fa-exclamation-circle me-2"></i> ${data.message || 'Failed to send test email. Please check your SMTP settings.'}
                    </div>
                `;
            }
        })
        .catch(error => {
            resultDiv.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> An error occurred. Please try again.
                </div>
            `;
            console.error('Test email error:', error);
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Send Test Email';
        });
    });
</script>
@endpush
@endsection