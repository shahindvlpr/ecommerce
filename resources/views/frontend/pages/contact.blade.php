@extends('layouts.app')

@section('title', 'Contact Us - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 4px 20px rgba(0, 0, 0, 0.08);
        --radius: 0.75rem;
        --radius-sm: 0.5rem;
    }

    .contact-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* ============================================
       HERO SECTION
    ============================================ */
    .hero-section {
        background: var(--primary-gradient);
        border-radius: var(--radius);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        text-align: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .hero-section h1 {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .hero-section h1 span {
        color: #fbbf24;
    }

    .hero-section p {
        font-size: 0.95rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
        max-width: 600px;
        margin: 0 auto;
    }

    .hero-section .hero-icon {
        position: relative;
        z-index: 1;
        margin-bottom: 0.75rem;
    }

    .hero-section .hero-icon i {
        font-size: 2.5rem;
        background: rgba(255, 255, 255, 0.12);
        padding: 0.75rem;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    /* ============================================
       INFO CARDS - Compact
    ============================================ */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.25rem 1rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .info-card .info-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .info-card h6 {
        font-weight: 600;
        font-size: 0.8rem;
        color: #1a1a2e;
        margin-bottom: 0.1rem;
    }

    .info-card p {
        color: #6b7280;
        font-size: 0.8rem;
        margin-bottom: 0;
    }

    /* ============================================
       CONTACT FORM - Premium
    ============================================ */
    .contact-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.75rem 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        margin-bottom: 2rem;
    }

    .contact-card .form-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-card .form-title i {
        color: #8b5cf6;
    }

    .contact-card .form-subtitle {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        font-weight: 500;
        font-size: 0.8rem;
        color: #1a1a2e;
        margin-bottom: 0.25rem;
        display: block;
    }

    .form-group label .required {
        color: #ef4444;
        margin-left: 0.15rem;
    }

    .form-control {
        border: 1.5px solid #e5e7eb;
        border-radius: var(--radius-sm);
        padding: 0.6rem 0.85rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: #fafbfc;
        width: 100%;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .form-control::placeholder {
        color: #9ca3af;
        font-size: 0.8rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .btn-submit {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: var(--radius-sm);
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* ============================================
       MAP / LOCATION SECTION
    ============================================ */
    .map-section {
        background: white;
        border-radius: var(--radius);
        padding: 1.25rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        text-align: center;
    }

    .map-section .map-placeholder {
        background: #f1f5f9;
        border-radius: var(--radius-sm);
        padding: 2rem 1rem;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px dashed #d1d5db;
    }

    .map-section .map-placeholder i {
        font-size: 2rem;
        color: #667eea;
    }

    .map-section .map-placeholder p {
        color: #6b7280;
        font-size: 0.8rem;
        margin: 0;
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 768px) {
        .hero-section {
            padding: 1.75rem 1.25rem;
        }
        .hero-section h1 {
            font-size: 1.5rem;
        }
        .info-grid {
            grid-template-columns: 1fr;
            gap: 0.6rem;
        }
        .contact-card {
            padding: 1.25rem;
        }
        .contact-card .form-title {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 1.3rem;
        }
        .hero-section p {
            font-size: 0.85rem;
        }
        .info-card {
            padding: 0.8rem 0.6rem;
        }
        .contact-card {
            padding: 1rem;
        }
        .form-control {
            font-size: 0.8rem;
            padding: 0.5rem 0.7rem;
        }
        .map-section {
            padding: 0.8rem;
        }
        .map-section .map-placeholder {
            min-height: 100px;
            padding: 1rem;
        }
    }
</style>

<div class="contact-wrapper">
    <div class="container">
        
        <!-- ============================================
             HERO SECTION
        ============================================ -->
        <div class="hero-section">
            <div class="hero-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h1>Contact <span>Us</span></h1>
            <p>Have questions? We'd love to hear from you.</p>
        </div>

        <!-- ============================================
             INFO CARDS
        ============================================ -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                    <i class="fas fa-phone"></i>
                </div>
                <h6>Phone</h6>
                <p>+880 1234 567890</p>
            </div>
            <div class="info-card">
                <div class="info-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-envelope"></i>
                </div>
                <h6>Email</h6>
                <p>support@ektamart.com</p>
            </div>
            <div class="info-card">
                <div class="info-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h6>Address</h6>
                <p>Dhaka, Bangladesh</p>
            </div>
        </div>

        <!-- ============================================
             CONTACT FORM
        ============================================ -->
        <div class="contact-card">
            <div class="form-title">
                <i class="fas fa-paper-plane"></i> Send us a message
            </div>
            <p class="form-subtitle">We'll get back to you within 24 hours.</p>

            <form action="#" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name <span class="required">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter your name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address <span class="required">*</span></label>
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" placeholder="What is this about?">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Message <span class="required">*</span></label>
                            <textarea class="form-control" rows="4" placeholder="Write your message here..." required></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i> Send Message
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- ============================================
             MAP / LOCATION
        ============================================ -->
        <div class="map-section">
            <div class="map-placeholder">
                <i class="fas fa-map-marked-alt"></i>
                <p><strong>Visit Us:</strong> Dhaka, Bangladesh</p>
                <p style="font-size: 0.7rem; color: #9ca3af;">Find us on Google Maps</p>
            </div>
        </div>

    </div>
</div>

<script>
    console.log('%c📞 EktaMart Contact Page Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
</script>
@endsection