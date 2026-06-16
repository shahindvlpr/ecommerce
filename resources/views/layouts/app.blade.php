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
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
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
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>