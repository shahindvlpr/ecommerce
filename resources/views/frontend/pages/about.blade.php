@extends('layouts.app')

@section('title', 'About Us - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 4px 20px rgba(0, 0, 0, 0.08);
        --radius: 0.75rem;
        --radius-sm: 0.5rem;
    }

    .about-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* ============================================
       HERO SECTION - Compact
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
       STATS SECTION - Compact Cards
    ============================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.25rem 1rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .stat-card .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .stat-card .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.2;
        font-variant-numeric: tabular-nums;
    }

    .stat-card .stat-label {
        color: #6b7280;
        font-size: 0.7rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-top: 0.1rem;
    }

    /* ============================================
       STORY SECTION - Clean
    ============================================ */
    .story-section {
        background: white;
        border-radius: var(--radius);
        padding: 1.75rem 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        margin-bottom: 2rem;
    }

    .story-section .story-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #1a1a2e;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .story-section .story-title i {
        color: #8b5cf6;
        font-size: 1.1rem;
    }

    .story-section p {
        color: #4b5563;
        line-height: 1.7;
        font-size: 0.92rem;
        margin-bottom: 0.5rem;
    }

    .story-section .badge-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.75rem;
    }

    .story-section .badge-group .badge-premium {
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 600;
        background: #f5f3ff;
        color: #7c3aed;
        border: 1px solid #ede9fe;
    }

    /* ============================================
       FEATURES SECTION - Compact Grid
    ============================================ */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .feature-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.25rem 1rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        position: relative;
    }

    .feature-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .feature-card .feature-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .feature-card h6 {
        font-weight: 600;
        font-size: 0.85rem;
        color: #1a1a2e;
        margin-bottom: 0.2rem;
    }

    .feature-card p {
        color: #6b7280;
        font-size: 0.75rem;
        line-height: 1.5;
        margin-bottom: 0;
    }

    /* ============================================
       TESTIMONIAL SECTION - Simple
    ============================================ */
    .testimonial-section {
        background: white;
        border-radius: var(--radius);
        padding: 1.75rem 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.03);
        margin-bottom: 2rem;
        text-align: center;
    }

    .testimonial-section .quote-icon {
        font-size: 1.5rem;
        color: #8b5cf6;
        opacity: 0.3;
        margin-bottom: 0.25rem;
    }

    .testimonial-section blockquote {
        font-size: 0.95rem;
        color: #1a1a2e;
        font-weight: 500;
        line-height: 1.7;
        max-width: 650px;
        margin: 0 auto;
    }

    .testimonial-section .testimonial-author {
        margin-top: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .testimonial-section .testimonial-author .avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .testimonial-section .testimonial-author .info {
        text-align: left;
    }

    .testimonial-section .testimonial-author .info .name {
        font-weight: 600;
        font-size: 0.85rem;
        color: #1a1a2e;
    }

    .testimonial-section .testimonial-author .info .role {
        font-size: 0.7rem;
        color: #6b7280;
    }

    /* ============================================
       CTA SECTION - Compact
    ============================================ */
    .cta-section {
        background: var(--primary-gradient);
        border-radius: var(--radius);
        padding: 2rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .cta-section h4 {
        font-weight: 700;
        font-size: 1.25rem;
        position: relative;
        z-index: 1;
        margin-bottom: 0.25rem;
    }

    .cta-section p {
        font-size: 0.9rem;
        opacity: 0.85;
        position: relative;
        z-index: 1;
        margin-bottom: 1rem;
    }

    .cta-section .btn-cta {
        background: white;
        color: #667eea;
        border: none;
        border-radius: var(--radius-sm);
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        text-decoration: none;
        display: inline-block;
    }

    .cta-section .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 1.75rem 1.25rem;
        }
        .hero-section h1 {
            font-size: 1.5rem;
        }
        .story-section {
            padding: 1.25rem;
        }
        .testimonial-section {
            padding: 1.25rem;
        }
        .cta-section {
            padding: 1.5rem;
        }
        .cta-section h4 {
            font-size: 1.1rem;
        }
        .stat-card .stat-number {
            font-size: 1.4rem;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.6rem;
        }
        .features-grid {
            grid-template-columns: 1fr;
            gap: 0.6rem;
        }
        .stat-card {
            padding: 0.8rem 0.6rem;
        }
        .stat-card .stat-number {
            font-size: 1.2rem;
        }
        .feature-card {
            padding: 0.8rem 0.6rem;
        }
        .hero-section h1 {
            font-size: 1.3rem;
        }
        .hero-section p {
            font-size: 0.85rem;
        }
        .story-section p {
            font-size: 0.85rem;
        }
        .testimonial-section blockquote {
            font-size: 0.85rem;
        }
    }
</style>

<div class="about-wrapper">
    <div class="container">
        
        <!-- ============================================
             HERO SECTION
        ============================================ -->
        <div class="hero-section">
            <div class="hero-icon">
                <i class="fas fa-store"></i>
            </div>
            <h1>About <span>EktaMart</span></h1>
            <p>Premium ecommerce platform dedicated to the best shopping experience.</p>
        </div>

        <!-- ============================================
             STATS SECTION
        ============================================ -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-number" data-count="5000">0</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" data-count="15000">0</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-number" data-count="120">0</div>
                <div class="stat-label">Cities Served</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number" data-count="4.8">0</div>
                <div class="stat-label">Avg. Rating</div>
            </div>
        </div>

        <!-- ============================================
             STORY SECTION
        ============================================ -->
        <div class="story-section">
            <div class="story-title">
                <i class="fas fa-book-open"></i> Our Story
            </div>
            <p>
                Founded in 2024, <strong>EktaMart</strong> started with a simple vision: 
                to make quality products accessible to everyone. Today, we're a trusted 
                platform serving thousands of customers across the country.
            </p>
            <p>
                Every product is carefully curated to ensure the highest quality standards, 
                backed by our commitment to excellence and customer satisfaction.
            </p>
            <div class="badge-group">
                <span class="badge-premium"><i class="fas fa-check-circle me-1"></i> Trusted Platform</span>
                <span class="badge-premium"><i class="fas fa-shield-alt me-1"></i> 100% Secure</span>
                <span class="badge-premium"><i class="fas fa-headset me-1"></i> 24/7 Support</span>
            </div>
        </div>

        <!-- ============================================
             FEATURES SECTION
        ============================================ -->
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h6>Fast Delivery</h6>
                <p>24-48 hour delivery with express options</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h6>Secure Payments</h6>
                <p>Encrypted transactions with multiple options</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-headset"></i>
                </div>
                <h6>24/7 Support</h6>
                <p>Dedicated team ready to help anytime</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <h6>Easy Returns</h6>
                <p>7-day return policy, no questions asked</p>
            </div>
        </div>

        <!-- ============================================
             TESTIMONIAL SECTION
        ============================================ -->
        <div class="testimonial-section">
            <div class="quote-icon">
                <i class="fas fa-quote-right"></i>
            </div>
            <blockquote>
                "Quality products, competitive prices, and an unparalleled customer experience."
            </blockquote>
            <div class="testimonial-author">
                <div class="avatar">E</div>
                <div class="info">
                    <div class="name">EktaMart Team</div>
                    <div class="role">Founded 2024</div>
                </div>
            </div>
        </div>

        <!-- ============================================
             CTA SECTION
        ============================================ -->
        <div class="cta-section">
            <h4>Ready to Shop?</h4>
            <p>Join thousands of happy customers today</p>
            <a href="{{ route('shop.index') }}" class="btn-cta">
                <i class="fas fa-shopping-bag me-2"></i> Start Shopping
            </a>
        </div>

    </div>
</div>

<script>
    // ============================================================
    // 1. COUNTER ANIMATION
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-count'));
            const isDecimal = target % 1 !== 0;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(counter, target, isDecimal);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.2 });
            
            observer.observe(counter);
        });
        
        function animateCounter(element, target, isDecimal = false) {
            const duration = 1200;
            const startTime = performance.now();
            
            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const current = easeOutQuart * target;
                
                if (isDecimal) {
                    element.textContent = current.toFixed(1);
                } else {
                    element.textContent = Math.round(current);
                }
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = isDecimal ? target.toFixed(1) : target;
                }
            }
            
            requestAnimationFrame(updateCounter);
        }
    });

    // ============================================================
    // 2. CONSOLE GREETING
    // ============================================================
    console.log('%c🏢 EktaMart About Page Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
</script>
@endsection