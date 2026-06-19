@extends('layouts.admin')

@section('title', 'Email Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-envelope text-primary me-2"></i>Email Settings
            </h4>
            <p class="text-muted small">Configure email delivery</p>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.email') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mail Driver</label>
                            <select name="mail_driver" class="form-control">
                                <option value="smtp" {{ ($settings['email']['mail_driver'] ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ ($settings['email']['mail_driver'] ?? 'smtp') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                <option value="mailgun" {{ ($settings['email']['mail_driver'] ?? 'smtp') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mail Host</label>
                            <input type="text" name="mail_host" class="form-control" 
                                   value="{{ $settings['email']['mail_host'] ?? 'smtp.gmail.com' }}" 
                                   placeholder="smtp.gmail.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mail Port</label>
                            <input type="number" name="mail_port" class="form-control" 
                                   value="{{ $settings['email']['mail_port'] ?? 587 }}" 
                                   placeholder="587">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mail Encryption</label>
                            <select name="mail_encryption" class="form-control">
                                <option value="tls" {{ ($settings['email']['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($settings['email']['mail_encryption'] ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="null" {{ ($settings['email']['mail_encryption'] ?? 'tls') == 'null' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mail Username</label>
                            <input type="text" name="mail_username" class="form-control" 
                                   value="{{ $settings['email']['mail_username'] ?? '' }}" 
                                   placeholder="your-email@gmail.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mail Password</label>
                            <input type="password" name="mail_password" class="form-control" 
                                   value="{{ $settings['email']['mail_password'] ?? '' }}" 
                                   placeholder="Enter your email password">
                            <small class="text-muted">For Gmail, use App Password</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">From Email Address</label>
                            <input type="email" name="mail_from_address" class="form-control" 
                                   value="{{ $settings['email']['mail_from_address'] ?? 'noreply@ektamart.com' }}" 
                                   placeholder="noreply@ektamart.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">From Name</label>
                            <input type="text" name="mail_from_name" class="form-control" 
                                   value="{{ $settings['email']['mail_from_name'] ?? 'EktaMart' }}" 
                                   placeholder="EktaMart">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Email Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection