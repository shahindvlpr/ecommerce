<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EktaMart - Premium Ecommerce Platform')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-premium {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 0.75rem 0;
        }
        .navbar-premium .navbar-brand {
            color: white;
            font-weight: 800;
            font-size: 1.5rem;
        }
        .navbar-premium .navbar-brand span {
            color: #8b5cf6;
        }
        .navbar-premium .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .navbar-premium .nav-link:hover {
            color: white !important;
        }
        .btn-primary-premium {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            border: none;
            border-radius: 0.75rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 92, 246, 0.3);
            color: white;
        }
        .btn-outline-light {
            border-radius: 0.75rem;
        }
        .footer-premium {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
        .footer-premium a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .footer-premium a:hover {
            color: #8b5cf6;
        }
        main {
            flex: 1;
        }
        .text-purple-600 {
            color: #8b5cf6;
        }

        /* Notification Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateX(100px) scale(0.9);
            }
        }

        /* Cart Badge */
        #cartCount {
            transition: all 0.3s ease;
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
        }

        /* Loading Spinner */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 0.5rem;
            min-width: 200px;
        }
        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .dropdown-item:hover {
            background: #f1f5f9;
            transform: translateX(5px);
        }
        .dropdown-item.text-danger:hover {
            background: #fef2f2;
        }
        .dropdown-divider {
            margin: 0.3rem 0;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-premium">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Ekta<span>Mart</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('shop.index') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('contact') }}">Contact</a>
                    </li>
                    
                    <!-- Cart Icon - Visible for all authenticated users -->
                    @auth
                        <li class="nav-item position-relative">
                            <a class="nav-link text-white" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                                <span id="cartCount" class="badge bg-danger rounded-pill" style="position: absolute; top: 0px; right: -8px; font-size: 0.6rem; padding: 0.2rem 0.5rem; display: none;">0</span>
                            </a>
                        </li>
                    @endauth

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ Auth::user()->name ?? 'Dashboard' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                        <i class="fas fa-shopping-bag me-2"></i> My Orders
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.wishlist') }}">
                                        <i class="fas fa-heart me-2"></i> Wishlist
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger" style="background: none; border: none; width: 100%; text-align: left;">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-primary-premium" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light rounded-pill px-4" href="{{ route('register') }}">
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer-premium">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>Ekta<span style="color: #8b5cf6;">Mart</span></h5>
                    <p class="text-muted small">Premium Ecommerce Platform</p>
                    <div class="social-links mt-2">
                        <a href="#" class="me-2"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Contact Info</h6>
                    <p class="text-muted small">
                        <i class="fas fa-phone me-2"></i> +880 1234 567890<br>
                        <i class="fas fa-envelope me-2"></i> support@ektamart.com<br>
                        <i class="fas fa-map-marker-alt me-2"></i> Dhaka, Bangladesh
                    </p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} EktaMart. All rights reserved.
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Cart Count Update Script -->
    <script>
        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const badge = document.getElementById('cartCount');
                    if (badge) {
                        const count = data.count || 0;
                        badge.textContent = count;
                        badge.style.display = count > 0 ? 'inline-block' : 'none';
                    }
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }

        // Toast Notification function (global)
        function showNotification(message, type = 'success') {
            // Remove existing notification
            const existing = document.querySelector('.custom-notification');
            if (existing) existing.remove();
            
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6'
            };
            
            const icons = {
                success: 'check-circle',
                error: 'exclamation-circle',
                warning: 'exclamation-triangle',
                info: 'info-circle'
            };
            
            const notification = document.createElement('div');
            notification.className = 'custom-notification';
            notification.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: ${colors[type] || colors.success};
                color: white;
                padding: 14px 24px;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.2);
                z-index: 9999;
                font-weight: 500;
                font-size: 0.95rem;
                animation: slideInRight 0.4s ease;
                max-width: 400px;
                display: flex;
                align-items: center;
                gap: 12px;
                border: 1px solid rgba(255,255,255,0.15);
                backdrop-filter: blur(10px);
            `;
            
            notification.innerHTML = `
                <i class="fas fa-${icons[type] || icons.success}" style="font-size: 1.2rem;"></i>
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
            
            document.body.appendChild(notification);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 4000);
        }

        console.log('%c✨ EktaMart App Loaded Successfully ✨', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
    </script>
    
    @stack('scripts')
</body>
</html>