{{-- resources/views/layouts/admin/footer.blade.php --}}
<style>
    /* Premium Footer Styles */
    .admin-footer {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        margin-top: auto;
        padding: 1.5rem 2rem;
        position: relative;
        overflow: hidden;
    }
    
    /* Animated Border Effect */
    .admin-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #8b5cf6, #6366f1, #a855f7, transparent);
        animation: borderSlide 8s linear infinite;
    }
    
    @keyframes borderSlide {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }
    
    /* Footer Content */
    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .footer-copyright {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .copyright-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(139, 92, 246, 0.2);
    }
    
    .copyright-icon i {
        color: white;
        font-size: 0.9rem;
    }
    
    .copyright-text {
        color: #475569;
        font-size: 0.85rem;
    }
    
    .copyright-text strong {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 800;
    }
    
    /* Footer Links */
    .footer-links {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .footer-link {
        color: #64748b;
        text-decoration: none;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .footer-link i {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }
    
    .footer-link:hover {
        color: #8b5cf6;
        transform: translateY(-2px);
    }
    
    .footer-link:hover i {
        transform: translateX(3px);
    }
    
    /* Social Icons */
    .social-icons {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .social-icon {
        width: 32px;
        height: 32px;
        background: #f1f5f9;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: #64748b;
        text-decoration: none;
    }
    
    .social-icon:hover {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
    }
    
    /* Version Badge */
    .version-badge {
        background: #f1f5f9;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .version-badge i {
        font-size: 0.7rem;
        color: #8b5cf6;
    }
    
    /* Server Status Indicator */
    .server-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.7rem;
        color: #64748b;
    }
    
    .status-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        animation: statusPulse 2s infinite;
    }
    
    @keyframes statusPulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.6;
            transform: scale(1.2);
        }
    }
    
    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 999;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
    }
    
    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        transform: translateY(-5px);
        color: white;
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.5);
    }
    
    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        .admin-footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-top-color: rgba(255, 255, 255, 0.05);
        }
        
        .copyright-text {
            color: #94a3b8;
        }
        
        .footer-link {
            color: #94a3b8;
        }
        
        .social-icon {
            background: #334155;
            color: #94a3b8;
        }
        
        .version-badge {
            background: #334155;
            color: #94a3b8;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .admin-footer {
            padding: 1rem;
        }
        
        .footer-content {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-copyright {
            justify-content: center;
        }
        
        .footer-links {
            justify-content: center;
        }
        
        .back-to-top {
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
        }
    }
</style>

<footer class="admin-footer">
    <div class="container-fluid">
        <div class="footer-content">
            
            <!-- Left Side: Copyright -->
            <div class="footer-copyright">
                <div class="copyright-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="copyright-text">
                    © {{ date('Y') }} 
                    <strong>EktaMart</strong> 
                    <span class="d-none d-md-inline">-</span>
                    <span class="d-block d-md-inline">Premium Ecommerce Platform</span>
                    <br class="d-md-none">
                    <small class="text-muted ms-0 ms-md-2">All Rights Reserved</small>
                </div>
            </div>
            
            <!-- Center: Server Status & Version -->
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="server-status">
                    <span class="status-dot"></span>
                    <span>Server Status: <strong class="text-success">Operational</strong></span>
                </div>
                
                <div class="version-badge">
                    <i class="fas fa-code-branch"></i>
                    <span>v2.0.0</span>
                </div>
            </div>
            
            <!-- Right Side: Links & Social -->
            <div class="footer-links">
                <a href="{{ route('help') }}" class="footer-link">
                    <i class="fas fa-question-circle"></i>
                    Help Center
                </a>
                <a href="{{ route('privacy') }}" class="footer-link">
                    <i class="fas fa-shield-alt"></i>
                    Privacy
                </a>
                <a href="{{ route('terms') }}" class="footer-link">
                    <i class="fas fa-file-contract"></i>
                    Terms
                </a>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://github.com" target="_blank" class="social-icon">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Additional Info Row -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <small class="text-muted" style="font-size: 0.7rem;">
                    <i class="fas fa-database me-1"></i> 
                    Database Queries: {{ app('db')->getQueryLog() ? count(app('db')->getQueryLog()) : 'N/A' }} | 
                    <i class="fas fa-clock me-1 ms-2"></i> 
                    Page Load: {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
</a>

<script>
    // Back to Top Functionality
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });
    
    backToTopBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Dynamic Copyright Year Update (ensuring it's always current)
    const yearElement = document.querySelector('.copyright-text strong');
    if (yearElement && !yearElement.innerText.includes('{{ date('Y') }}')) {
        // Year is already set via PHP, this is just a backup
        const currentYear = new Date().getFullYear();
        const copyrightText = document.querySelector('.copyright-text');
        if (copyrightText) {
            copyrightText.innerHTML = copyrightText.innerHTML.replace(/\d{4}/, currentYear);
        }
    }
    
    // Server status check (optional - can be implemented with AJAX)
    function checkServerStatus() {
        fetch('/admin/server-status')
            .then(response => response.json())
            .then(data => {
                const statusDot = document.querySelector('.status-dot');
                const statusText = document.querySelector('.server-status strong');
                if (data.status === 'online') {
                    statusDot.style.background = '#10b981';
                    statusText.textContent = 'Operational';
                    statusText.className = 'text-success';
                } else {
                    statusDot.style.background = '#ef4444';
                    statusText.textContent = 'Issues Detected';
                    statusText.className = 'text-danger';
                }
            })
            .catch(() => {
                console.log('Server status check failed - using default status');
            });
    }
    
    // Uncomment to enable periodic server status checks
    // setInterval(checkServerStatus, 60000);
    
    // Console info
    console.log('%c🔧 EktaMart Admin Footer | Premium Footer Loaded', 'color: #8b5cf6; font-size: 12px; font-weight: bold;');
    console.log('%c⚡ Features: Back to top • Server status • Social links • Animated border • Dark mode ready', 'color: #6366f1; font-size: 11px;');
    
    // Track page performance
    if (typeof window.performance !== 'undefined') {
        const perfData = window.performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log(`%c📊 Page Load Time: ${pageLoadTime}ms`, 'color: #10b981; font-size: 11px;');
    }
</script>