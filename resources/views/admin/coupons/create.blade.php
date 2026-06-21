@extends('layouts.admin')

@section('title', 'Create Coupon - EktaMart Admin')
@section('page-title', 'Create Coupon')
@section('icon', 'ticket-alt')

@section('content')
<div class="container-fluid">
    
    {{-- Breadcrumb & Back Button --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Coupons
                    </a>
                </div>
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-ticket-alt me-1"></i> New Coupon
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
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h5 class="mb-0">Add New Coupon</h5>
                    <p class="text-muted small mb-0">Create a new discount coupon for your customers</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                    <i class="far fa-clock me-1"></i> {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
        <div class="card-body-custom">
            <form action="{{ route('admin.coupons.store') }}" method="POST" id="couponForm">
                @csrf

                {{-- Form Sections --}}
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

                    {{-- Code & Name --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Coupon Code <span class="text-danger">*</span>
                                <span class="label-hint">(Uppercase letters & numbers only)</span>
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-ticket-alt text-primary"></i></span>
                                <input type="text" name="code" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       placeholder="e.g. SUMMER2024" 
                                       value="{{ old('code') }}"
                                       id="couponCode"
                                       required>
                                <button type="button" class="btn btn-outline-primary" onclick="generateCode()" title="Generate Random Code">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            @error('code')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Coupon Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-tag text-primary"></i></span>
                                <input type="text" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="e.g. Summer Sale 2024" 
                                       value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 2: DISCOUNT DETAILS
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">02</span>
                            <h6 class="section-title">Discount Details</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Type, Value, Max Discount --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Discount Type <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-percent text-primary"></i></span>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" id="discountType" required>
                                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                </select>
                            </div>
                            @error('type')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Discount Value <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text" id="valueSymbol">%</span>
                                <input type="number" name="value" 
                                       class="form-control @error('value') is-invalid @enderror" 
                                       placeholder="0.00" step="0.01" min="0.01" 
                                       value="{{ old('value') }}" required>
                            </div>
                            @error('value')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Max Discount
                                <span class="label-hint">(For percentage coupons)</span>
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text">$</span>
                                <input type="number" name="max_discount" 
                                       class="form-control @error('max_discount') is-invalid @enderror" 
                                       placeholder="0.00" step="0.01" min="0" 
                                       value="{{ old('max_discount') }}">
                            </div>
                            @error('max_discount')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 3: LIMITATIONS
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">03</span>
                            <h6 class="section-title">Limitations</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Min Order, Usage Limit, Per User Limit --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Minimum Order Amount
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text">$</span>
                                <input type="number" name="min_order_amount" 
                                       class="form-control @error('min_order_amount') is-invalid @enderror" 
                                       placeholder="0.00" step="0.01" min="0" 
                                       value="{{ old('min_order_amount') }}">
                            </div>
                            <small class="text-muted"><i class="far fa-info-circle me-1"></i> Leave empty for no minimum</small>
                            @error('min_order_amount')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Usage Limit
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-users text-primary"></i></span>
                                <input type="number" name="usage_limit" 
                                       class="form-control @error('usage_limit') is-invalid @enderror" 
                                       placeholder="e.g. 100" min="1" 
                                       value="{{ old('usage_limit') }}">
                            </div>
                            <small class="text-muted"><i class="far fa-info-circle me-1"></i> Total number of times this coupon can be used</small>
                            @error('usage_limit')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Per User Limit
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                                <input type="number" name="per_user_limit" 
                                       class="form-control @error('per_user_limit') is-invalid @enderror" 
                                       placeholder="e.g. 1" min="1" 
                                       value="{{ old('per_user_limit') }}">
                            </div>
                            <small class="text-muted"><i class="far fa-info-circle me-1"></i> How many times per user can use this coupon</small>
                            @error('per_user_limit')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         SECTION 4: DATE & STATUS
                    ============================================ --}}
                    <div class="col-12">
                        <div class="section-header">
                            <span class="section-number">04</span>
                            <h6 class="section-title">Date & Status</h6>
                            <span class="section-line"></span>
                        </div>
                    </div>

                    {{-- Start & End Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                Start Date
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                                <input type="date" name="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date') }}">
                            </div>
                            <small class="text-muted"><i class="far fa-info-circle me-1"></i> Leave empty for immediate activation</small>
                            @error('start_date')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold">
                                End Date
                            </label>
                            <div class="input-group input-group-premium">
                                <span class="input-group-text"><i class="fas fa-calendar-check text-primary"></i></span>
                                <input type="date" name="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date') }}">
                            </div>
                            <small class="text-muted"><i class="far fa-info-circle me-1"></i> Leave empty for no expiry</small>
                            @error('end_date')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status Toggle --}}
                    <div class="col-12">
                        <div class="form-group">
                            <div class="status-toggle-wrapper">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check form-switch form-switch-lg">
                                        <input type="checkbox" name="status" class="form-check-input" id="status" 
                                               value="1" {{ old('status', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="status">
                                            <span class="status-text {{ old('status', true) ? 'text-success' : 'text-danger' }}">
                                                <i class="fas fa-circle me-1"></i>
                                                {{ old('status', true) ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </div>
                                    <span class="badge bg-light text-muted rounded-pill px-3">
                                        <i class="far fa-question-circle me-1"></i> Toggle to enable/disable
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============================================
                         FORM ACTIONS
                    ============================================ --}}
                    <div class="col-12">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-premium">
                                <i class="fas fa-save me-2"></i> Create Coupon
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-premium">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-danger btn-premium">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Help Card --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="help-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="help-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Tips for creating effective coupons</h6>
                        <p class="text-muted small mb-0">
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1">💡</span>
                            Use clear coupon codes that are easy to remember
                            <span class="mx-2">•</span>
                            <span class="badge bg-success bg-opacity-10 text-success me-1">📊</span>
                            Set realistic discount values (10-30% for percentage)
                            <span class="mx-2">•</span>
                            <span class="badge bg-warning bg-opacity-10 text-warning me-1">⏰</span>
                            Use expiry dates to create urgency
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
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
   STATUS TOGGLE
============================================================ */
.status-toggle-wrapper {
    background: var(--bg-body);
    border-radius: 12px;
    padding: 16px 20px;
    border: 1px solid var(--border-color);
}

.form-switch-lg .form-check-input {
    width: 56px;
    height: 28px;
    cursor: pointer;
}
.form-switch-lg .form-check-input:checked {
    background-color: #10B981;
    border-color: #10B981;
}
.form-switch-lg .form-check-input:not(:checked) {
    background-color: #EF4444;
    border-color: #EF4444;
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
   HELP CARD
============================================================ */
.help-card {
    background: linear-gradient(135deg, rgba(139,92,246,0.04), rgba(99,102,241,0.02));
    border-radius: 12px;
    border: 1px solid var(--border-color);
    padding: 16px 20px;
}

.help-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(139,92,246,0.1);
    color: #8B5CF6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
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
    .status-toggle-wrapper {
        padding: 12px 16px;
    }
    .section-header {
        flex-wrap: wrap;
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
    .btn-premium {
        padding: 8px 20px;
        font-size: 13px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .card-header-custom {
    background: linear-gradient(135deg, rgba(139,92,246,0.06), rgba(99,102,241,0.04));
}
[data-theme="dark"] .help-card {
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
    // DISCOUNT TYPE SYMBOL UPDATE
    // ============================================================
    const typeSelect = document.getElementById('discountType');
    const valueSymbol = document.getElementById('valueSymbol');
    
    typeSelect.addEventListener('change', function() {
        if (this.value === 'percentage') {
            valueSymbol.textContent = '%';
            valueSymbol.style.color = '#8B5CF6';
        } else {
            valueSymbol.textContent = '$';
            valueSymbol.style.color = '#10B981';
        }
    });

    // ============================================================
    // GENERATE RANDOM COUPON CODE
    // ============================================================
    window.generateCode = function() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for (let i = 0; i < 8; i++) {
            code += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        // Format: ABCD-1234
        const formattedCode = code.substring(0, 4) + '-' + code.substring(4, 8);
        document.getElementById('couponCode').value = formattedCode;
        document.getElementById('couponCode').focus();
        
        // Show toast notification
        showToast('Random coupon code generated: ' + formattedCode, 'success');
    };

    // ============================================================
    // STATUS TOGGLE TEXT UPDATE
    // ============================================================
    const statusToggle = document.getElementById('status');
    const statusText = document.querySelector('.status-text');
    
    statusToggle.addEventListener('change', function() {
        if (this.checked) {
            statusText.innerHTML = '<i class="fas fa-circle me-1"></i> Active';
            statusText.className = 'status-text text-success';
        } else {
            statusText.innerHTML = '<i class="fas fa-circle me-1"></i> Inactive';
            statusText.className = 'status-text text-danger';
        }
    });

    // ============================================================
    // START/END DATE VALIDATION
    // ============================================================
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');
    
    startDate.addEventListener('change', function() {
        if (endDate.value && this.value && endDate.value < this.value) {
            endDate.value = '';
            showToast('End date must be after start date', 'warning');
        }
    });

    endDate.addEventListener('change', function() {
        if (startDate.value && this.value && this.value < startDate.value) {
            this.value = '';
            showToast('End date must be after start date', 'warning');
        }
    });

    // ============================================================
    // TOAST NOTIFICATION
    // ============================================================
    function showToast(message, type = 'success') {
        const colors = {
            success: '#10B981',
            error: '#EF4444',
            warning: '#F59E0B',
            info: '#3B82F6'
        };
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };

        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 90px;
            right: 30px;
            background: ${colors[type]};
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            z-index: 9999;
            font-weight: 500;
            font-size: 0.9rem;
            animation: slideInRight 0.4s ease;
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
        `;
        
        toast.innerHTML = `
            <i class="fas fa-${icons[type]}" style="font-size: 1.2rem;"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" style="
                background: transparent;
                border: none;
                color: white;
                opacity: 0.7;
                cursor: pointer;
                margin-left: auto;
                font-size: 1rem;
                padding: 4px;
            ">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    }

    // ============================================================
    // KEYBOARD SHORTCUT: Ctrl+G for generate code
    // ============================================================
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'g') {
            e.preventDefault();
            generateCode();
        }
    });

    console.log('%c🎫 Coupon Create Page Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
    console.log('%c⌨️  Press Ctrl+G to generate random coupon code', 'color: #6366F1; font-size: 12px;');
});
</script>
@endpush