{{-- resources/views/layouts/partials/footer.blade.php --}}
<footer class="footer-premium">
    <div class="container-fluid">
        <div class="container">
            <div class="row g-4">
                <!-- Brand Column -->
                <div class="col-md-4">
                    <h5><i class="fas fa-crown me-2" style="color: #fbbf24;"></i>Ekta<span>Mart</span></h5>
                    <p class="text-muted small">Premium Ecommerce Platform</p>
                    <div class="social-links mt-3">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-md-4">
                    <h6><i class="fas fa-link me-2" style="color: #8b5cf6;"></i>Quick Links</h6>
                    <ul>
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('terms') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-md-4">
                    <h6><i class="fas fa-address-card me-2" style="color: #8b5cf6;"></i>Contact Info</h6>
                    <p class="text-muted small">
                        <i class="fas fa-phone me-2" style="color: #8b5cf6;"></i> +880 1234 567890<br>
                        <i class="fas fa-envelope me-2" style="color: #8b5cf6;"></i> support@ektamart.com<br>
                        <i class="fas fa-map-marker-alt me-2" style="color: #8b5cf6;"></i> Dhaka, Bangladesh
                    </p>
                    <div class="mt-3">
                        <span class="badge-success">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                            Online
                        </span>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <!-- Bottom Bar -->
            <div class="row">
                <div class="col-12 text-center">
                    <p class="bottom-text mb-1">
                        &copy; {{ date('Y') }} <strong>EktaMart</strong> — All rights reserved.
                        <span class="d-none d-md-inline">|</span>
                        <span class="d-block d-md-inline mt-1 mt-md-0">Made with <span class="heart">❤️</span> in Bangladesh</span>
                    </p>
                    <p class="security-badge mt-2 mb-0">
                        <i class="fas fa-shield-alt"></i> Secure Shopping
                        <span class="mx-2">•</span>
                        <i class="fas fa-lock"></i> SSL Encrypted
                        <span class="mx-2">•</span>
                        <i class="fas fa-credit-card"></i> Multiple Payment Options
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* ============================================================
       UNIVERSAL FOOTER STYLES
    ============================================================ */
    .footer-premium {
        background: linear-gradient(135deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
        color: #ffffff;
        padding: 3rem 0 1.5rem 0;
        margin-top: auto;
        position: relative;
        overflow: hidden;
        border-top: 2px solid rgba(139, 92, 246, 0.15);
        width: 100%;
    }
    
    /* Animated Border */
    .footer-premium::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -100%;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #8b5cf6, #6366f1, #a855f7, #8b5cf6, transparent);
        animation: borderSlide 6s linear infinite;
    }
    
    @keyframes borderSlide {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    /* Animated Glow */
    .footer-premium::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: glowPulse 8s ease-in-out infinite;
    }
    
    @keyframes glowPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.3); opacity: 1; }
    }
    
    /* Brand */
    .footer-premium h5 {
        font-weight: 800;
        font-size: 1.3rem;
        color: #ffffff;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    .footer-premium h5 span {
        color: #8b5cf6;
    }
    .footer-premium h6 {
        font-weight: 700;
        font-size: 0.9rem;
        color: #e2e8f0;
        margin-bottom: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        z-index: 1;
    }
    
    /* Links */
    .footer-premium a {
        color: #c4b5fd;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
        display: inline-block;
    }
    .footer-premium a:hover {
        color: #8b5cf6;
        transform: translateX(5px);
    }
    
    .footer-premium .text-muted {
        color: #a78bfa !important;
        opacity: 0.8;
    }
    
    /* Social Links */
    .footer-premium .social-links {
        position: relative;
        z-index: 1;
    }
    .footer-premium .social-links a {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 0.5rem;
        text-align: center;
        line-height: 40px;
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 92, 246, 0.15);
        color: #c4b5fd;
        font-size: 1rem;
    }
    .footer-premium .social-links a:hover {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 8px 30px rgba(139, 92, 246, 0.4);
        color: white;
        border-color: transparent;
    }
    
    /* Divider */
    .footer-premium hr {
        border-color: rgba(139, 92, 246, 0.15);
        opacity: 0.5;
        margin: 1.5rem 0;
        position: relative;
        z-index: 1;
    }
    
    /* Lists */
    .footer-premium ul {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    .footer-premium ul li {
        margin-bottom: 0.5rem;
    }
    .footer-premium ul li a {
        display: inline-block;
    }
    
    /* Badge */
    .footer-premium .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 0.3rem 1.2rem;
        border-radius: 2rem;
        font-weight: 500;
        font-size: 0.8rem;
        position: relative;
        z-index: 1;
    }
    .footer-premium .badge-success i {
        color: #34d399;
        font-size: 0.5rem;
    }
    
    /* Bottom Text */
    .footer-premium .bottom-text {
        color: #a78bfa;
        opacity: 0.7;
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }
    .footer-premium .bottom-text strong {
        color: #c4b5fd;
    }
    .footer-premium .bottom-text .heart {
        color: #ef4444;
        display: inline-block;
        animation: heartBeat 1.5s ease-in-out infinite;
    }
    
    @keyframes heartBeat {
        0%, 100% { transform: scale(1); }
        14% { transform: scale(1.3); }
        28% { transform: scale(1); }
        42% { transform: scale(1.3); }
        70% { transform: scale(1); }
    }
    
    /* Security Badge */
    .footer-premium .security-badge {
        color: #94a3b8;
        font-size: 0.7rem;
        opacity: 0.6;
        position: relative;
        z-index: 1;
    }
    .footer-premium .security-badge i {
        color: #8b5cf6;
    }
    
    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .footer-premium {
            padding: 2rem 0 1rem 0;
        }
        .footer-premium .social-links a {
            width: 36px;
            height: 36px;
            line-height: 36px;
        }
        .footer-premium .bottom-text {
            font-size: 0.75rem;
        }
        .footer-premium h5 {
            font-size: 1.1rem;
        }
        .footer-premium h6 {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .footer-premium {
            padding: 1.5rem 0 0.8rem 0;
        }
        .footer-premium .social-links a {
            width: 32px;
            height: 32px;
            line-height: 32px;
            font-size: 0.8rem;
        }
        .footer-premium ul li a {
            font-size: 0.75rem;
        }
        .footer-premium .bottom-text {
            font-size: 0.7rem;
        }
        .footer-premium .security-badge {
            font-size: 0.6rem;
        }
        .footer-premium .badge-success {
            font-size: 0.7rem;
            padding: 0.2rem 0.8rem;
        }
    }
</style>