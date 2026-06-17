<!-- ============================================================
     ULTRA PREMIUM NAVBAR - EKTAMART
     ============================================================ -->
<nav class="relative z-50 bg-gradient-to-r from-[#0f0c29] via-[#1a1a3e] to-[#24243e] border-b border-white/5 shadow-2xl shadow-purple-500/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">
            
            <!-- ==========================================
                 BRAND LOGO - WITH GLOW EFFECT
                 ========================================== -->
            <div class="flex items-center shrink-0">
                <a href="{{ route('home') }}" class="group flex items-center gap-2.5 text-white font-extrabold text-xl sm:text-2xl transition-all duration-500 hover:scale-105">
                    <div class="relative">
                        <!-- Animated Glow Ring -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-500 animate-pulse"></div>
                        <!-- Icon Container -->
                        <div class="relative w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl flex items-center justify-center border border-white/10 backdrop-blur-sm group-hover:border-purple-400/50 transition-all duration-500">
                            <i class="fas fa-crown text-yellow-400 text-base sm:text-xl group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <span class="relative">
                        Ekta
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-[length:200%_auto] animate-gradient">Mart</span>
                    </span>
                </a>
            </div>
            
            <!-- ==========================================
                 DESKTOP NAVIGATION
                 ========================================== -->
            <div class="hidden lg:flex items-center space-x-1">
                <!-- Nav Links with Icon -->
                <a href="{{ route('shop.index') }}" class="nav-link-premium text-gray-300 hover:text-white px-4 py-2.5 rounded-xl transition-all duration-300 flex items-center gap-2.5 group relative">
                    <span class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <i class="fas fa-store text-purple-400 group-hover:text-purple-300 group-hover:scale-110 transition-all duration-300"></i>
                    <span class="relative font-medium">Shop</span>
                    <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-pink-400 group-hover:w-1/2 transition-all duration-300 -translate-x-1/2"></span>
                </a>
                
                <a href="{{ route('about') }}" class="nav-link-premium text-gray-300 hover:text-white px-4 py-2.5 rounded-xl transition-all duration-300 flex items-center gap-2.5 group relative">
                    <span class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <i class="fas fa-info-circle text-purple-400 group-hover:text-purple-300 group-hover:scale-110 transition-all duration-300"></i>
                    <span class="relative font-medium">About</span>
                    <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-pink-400 group-hover:w-1/2 transition-all duration-300 -translate-x-1/2"></span>
                </a>
                
                <a href="{{ route('contact') }}" class="nav-link-premium text-gray-300 hover:text-white px-4 py-2.5 rounded-xl transition-all duration-300 flex items-center gap-2.5 group relative">
                    <span class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <i class="fas fa-envelope text-purple-400 group-hover:text-purple-300 group-hover:scale-110 transition-all duration-300"></i>
                    <span class="relative font-medium">Contact</span>
                    <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-pink-400 group-hover:w-1/2 transition-all duration-300 -translate-x-1/2"></span>
                </a>
                
                <!-- Divider -->
                <div class="w-px h-6 bg-white/10 mx-2"></div>
                
                <!-- Cart Icon - Desktop -->
                @auth
                    <a href="{{ route('cart.index') }}" class="relative text-gray-300 hover:text-white p-2.5 rounded-xl hover:bg-white/5 transition-all duration-300 group">
                        <i class="fas fa-shopping-cart text-xl group-hover:scale-110 transition-transform duration-300"></i>
                        <span id="navCartCount" class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-[10px] font-bold rounded-full min-w-[20px] h-[20px] flex items-center justify-center shadow-lg shadow-red-500/40 border-2 border-white/20 animate-pulse">0</span>
                    </a>
                @endauth

                <!-- User Dropdown - Premium Glassmorphism -->
                @auth
                    <div class="relative group ml-1">
                        <button class="flex items-center gap-2.5 text-white hover:text-purple-300 transition-all duration-300 px-3.5 py-2 rounded-xl hover:bg-white/5 border border-transparent hover:border-purple-500/20 group">
                            <div class="relative">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-purple-500/30 ring-2 ring-purple-400/30 ring-offset-2 ring-offset-[#1a1a3e] transition-all duration-300 group-hover:ring-purple-400/50 group-hover:scale-105">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-[#1a1a3e]"></div>
                            </div>
                            <span class="hidden xl:inline font-medium text-sm">{{ Str::limit(Auth::user()->name, 15) }}</span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown - Glassmorphism -->
                        <div class="absolute right-0 mt-2 w-72 bg-white/5 backdrop-blur-2xl rounded-2xl shadow-2xl shadow-purple-500/10 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-white/10">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-white/5">
                                <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-white/50 truncate">{{ Auth::user()->email }}</p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="px-2 py-0.5 text-[10px] font-semibold bg-gradient-to-r from-purple-500/20 to-pink-500/20 text-purple-300 rounded-full border border-purple-500/20">
                                        <i class="fas fa-user-check mr-1"></i> Customer
                                    </span>
                                    <span class="px-2 py-0.5 text-[10px] font-semibold bg-green-500/10 text-green-400 rounded-full border border-green-500/20">
                                        <i class="fas fa-circle text-[6px] mr-1"></i> Active
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Menu Items with Icons -->
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/70 hover:text-white hover:bg-white/5 transition-all duration-200 group">
                                <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition">
                                    <i class="fas fa-th-large text-purple-400"></i>
                                </div>
                                <span class="font-medium text-sm">Dashboard</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/70 hover:text-white hover:bg-white/5 transition-all duration-200 group">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20 transition">
                                    <i class="fas fa-user text-blue-400"></i>
                                </div>
                                <span class="font-medium text-sm">Profile</span>
                            </a>
                            <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/70 hover:text-white hover:bg-white/5 transition-all duration-200 group">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition">
                                    <i class="fas fa-shopping-bag text-emerald-400"></i>
                                </div>
                                <span class="font-medium text-sm">My Orders</span>
                            </a>
                            <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/70 hover:text-white hover:bg-white/5 transition-all duration-200 group">
                                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500/20 transition">
                                    <i class="fas fa-heart text-red-400"></i>
                                </div>
                                <span class="font-medium text-sm">Wishlist</span>
                            </a>
                            
                            <div class="border-t border-white/5 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200 group">
                                    <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500/20 transition">
                                        <i class="fas fa-sign-out-alt text-red-400"></i>
                                    </div>
                                    <span class="font-medium text-sm">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2.5">
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/30 font-medium text-sm flex items-center gap-2 group">
                            <i class="fas fa-sign-in-alt group-hover:rotate-12 transition-transform duration-300"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 border-2 border-white/20 text-white/80 rounded-xl hover:bg-white/10 hover:text-white transition-all duration-300 hover:scale-105 font-medium text-sm flex items-center gap-2 group">
                            <i class="fas fa-user-plus group-hover:scale-110 transition-transform duration-300"></i> Register
                        </a>
                    </div>
                @endauth
            </div>
            
            <!-- ==========================================
                 MOBILE CONTROLS
                 ========================================== -->
            <div class="flex lg:hidden items-center gap-1">
                @auth
                    <a href="{{ route('cart.index') }}" class="relative text-white p-2 rounded-xl hover:bg-white/5 transition-all duration-300">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span id="mobileCartCount" class="absolute -top-0.5 -right-0.5 bg-gradient-to-r from-red-500 to-pink-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center shadow-lg shadow-red-500/30 border border-white/20">0</span>
                    </a>
                @endauth
                
                <button id="mobileMenuToggle" class="relative text-white hover:text-purple-300 p-2.5 rounded-xl hover:bg-white/5 transition-all duration-300 group border border-white/20 hover:border-purple-400/50">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- ============================================================
         MOBILE MENU - PREMIUM GLASSMORPHISM
         ============================================================ -->
    <div id="mobileMenu" class="lg:hidden hidden bg-gradient-to-b from-[#0f0c29]/98 via-[#1a1a3e]/98 to-[#24243e]/98 backdrop-blur-2xl border-t border-white/5 shadow-2xl shadow-purple-500/10">
        <div class="px-4 py-4 space-y-1 max-h-[80vh] overflow-y-auto">
            
            <!-- User Info - Mobile -->
            @auth
                <div class="flex items-center gap-3 px-4 py-3.5 bg-white/5 rounded-2xl mb-3 border border-white/5 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-purple-500/30 ring-2 ring-purple-400/30 flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                        <p class="text-white/50 text-xs truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-semibold bg-purple-500/20 text-purple-300 rounded-full border border-purple-500/20">
                        <i class="fas fa-check-circle mr-1"></i> User
                    </span>
                </div>
                <div class="border-t border-white/5 my-2"></div>
            @endauth
            
            <!-- Mobile Navigation Links -->
            <a href="{{ route('shop.index') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition">
                    <i class="fas fa-store text-purple-400"></i>
                </div>
                <span class="font-medium">Shop</span>
                <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-purple-400 group-hover:translate-x-1 transition-all"></i>
            </a>
            
            <a href="{{ route('about') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition">
                    <i class="fas fa-info-circle text-purple-400"></i>
                </div>
                <span class="font-medium">About</span>
                <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-purple-400 group-hover:translate-x-1 transition-all"></i>
            </a>
            
            <a href="{{ route('contact') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition">
                    <i class="fas fa-envelope text-purple-400"></i>
                </div>
                <span class="font-medium">Contact</span>
                <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-purple-400 group-hover:translate-x-1 transition-all"></i>
            </a>
            
            @auth
                <div class="border-t border-white/5 my-2"></div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                    <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center group-hover:bg-indigo-500/20 transition">
                        <i class="fas fa-th-large text-indigo-400"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                    <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20 transition">
                        <i class="fas fa-user text-blue-400"></i>
                    </div>
                    <span class="font-medium">Profile</span>
                    <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                
                <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition">
                        <i class="fas fa-shopping-bag text-emerald-400"></i>
                    </div>
                    <span class="font-medium">My Orders</span>
                    <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                
                <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-white/10 group">
                    <div class="w-9 h-9 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500/20 transition">
                        <i class="fas fa-heart text-red-400"></i>
                    </div>
                    <span class="font-medium">Wishlist</span>
                    <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-red-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                
                <div class="border-t border-white/5 my-2"></div>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 px-4 py-3.5 rounded-xl transition-all duration-300 border border-transparent hover:border-red-500/20 group">
                        <div class="w-9 h-9 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500/20 transition">
                            <i class="fas fa-sign-out-alt text-red-400"></i>
                        </div>
                        <span class="font-medium">Logout</span>
                        <i class="fas fa-chevron-right ml-auto text-white/20 group-hover:text-red-400 group-hover:translate-x-1 transition-all"></i>
                    </button>
                </form>
            @else
                <div class="border-t border-white/5 my-2"></div>
                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 font-medium shadow-lg shadow-purple-500/20">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3.5 border-2 border-white/20 text-white/80 rounded-xl hover:bg-white/10 hover:text-white transition-all duration-300 font-medium mt-2">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            @endauth
        </div>
    </div>
</nav>

<style>
    /* ============================================================
       NAVBAR PREMIUM STYLES
       ============================================================ */
    
    /* Gradient Animation for Logo */
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-gradient {
        background-size: 200% auto;
        animation: gradient 3s ease infinite;
    }
    
    /* Nav Link Premium */
    .nav-link-premium {
        position: relative;
        overflow: hidden;
    }
    .nav-link-premium::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #a855f7, #ec4899);
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .nav-link-premium:hover::after {
        width: 60%;
    }
    
    /* Mobile Menu Scrollbar */
    #mobileMenu::-webkit-scrollbar {
        width: 4px;
    }
    #mobileMenu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 10px;
    }
    #mobileMenu::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #a855f7, #ec4899);
        border-radius: 10px;
    }
    
    /* Dropdown Animation */
    .group:hover .group-hover\:visible {
        visibility: visible;
    }
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
    
    /* Cart Badge Pulse */
    @keyframes cartPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    #navCartCount, #mobileCartCount {
        animation: cartPulse 2s ease-in-out infinite;
    }
    
    /* Mobile Menu Slide Animation */
    #mobileMenu {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Glowing Effect for Active State */
    .nav-link-premium.active {
        color: white;
        background: rgba(139, 92, 246, 0.1);
    }
    .nav-link-premium.active::after {
        width: 60%;
    }
</style>

<script>
    // ============================================================
    // 1. MOBILE MENU TOGGLE - SMOOTH
    // ============================================================
    (function() {
        const mobileToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        let isOpen = false;
        
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                isOpen = !isOpen;
                
                if (isOpen) {
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.style.maxHeight = '0';
                    mobileMenu.style.opacity = '0';
                    mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                    
                    requestAnimationFrame(() => {
                        mobileMenu.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
                        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
                        mobileMenu.style.opacity = '1';
                        mobileMenu.style.transform = 'translateY(0) scale(1)';
                    });
                } else {
                    mobileMenu.style.maxHeight = '0';
                    mobileMenu.style.opacity = '0';
                    mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                    
                    setTimeout(() => {
                        mobileMenu.classList.add('hidden');
                        mobileMenu.style.transition = '';
                        mobileMenu.style.transform = '';
                    }, 400);
                }
            });
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (isOpen && !mobileToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                    isOpen = false;
                    mobileMenu.style.maxHeight = '0';
                    mobileMenu.style.opacity = '0';
                    mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                    setTimeout(() => {
                        mobileMenu.classList.add('hidden');
                    }, 400);
                }
            });
            
            // Close on link click
            mobileMenu.querySelectorAll('a, button').forEach(link => {
                link.addEventListener('click', function() {
                    isOpen = false;
                    mobileMenu.style.maxHeight = '0';
                    mobileMenu.style.opacity = '0';
                    mobileMenu.style.transform = 'translateY(-20px) scale(0.95)';
                    setTimeout(() => {
                        mobileMenu.classList.add('hidden');
                    }, 400);
                });
            });
            
            // Close on resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024 && isOpen) {
                    isOpen = false;
                    mobileMenu.classList.add('hidden');
                    mobileMenu.style.maxHeight = '';
                    mobileMenu.style.opacity = '';
                    mobileMenu.style.transform = '';
                    mobileMenu.style.transition = '';
                }
            });
        }
    })();

    // ============================================================
    // 2. UPDATE CART COUNT
    // ============================================================
    function updateNavCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                document.querySelectorAll('#navCartCount, #mobileCartCount').forEach(badge => {
                    if (badge) {
                        badge.textContent = count;
                        badge.style.display = count > 0 ? 'flex' : 'none';
                    }
                });
            })
            .catch(error => console.error('Cart count error:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateNavCartCount();
    });

    // ============================================================
    // 3. ACTIVE LINK DETECTION
    // ============================================================
    document.querySelectorAll('.nav-link-premium').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });

    console.log('%c🚀 EktaMart Ultra Premium Navbar Loaded ✨', 'color: #a855f7; font-size: 16px; font-weight: bold;');
    console.log('%c🎨 Features: Glassmorphism • Gradient animations • Smooth dropdown • Responsive', 'color: #8b5cf6; font-size: 12px;');
</script>