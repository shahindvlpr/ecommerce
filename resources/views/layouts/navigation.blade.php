<nav class="bg-gradient-to-r from-purple-900 to-indigo-900 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-white font-bold text-2xl">
                    Ekta<span class="text-purple-400">Mart</span>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('shop.index') }}" class="text-gray-300 hover:text-white transition">Shop</a>
                <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition">About</a>
                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition">Contact</a>
                
                @auth
                    <div class="relative group">
                        <button class="flex items-center text-white hover:text-purple-300 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 border border-purple-400 text-purple-300 rounded-lg hover:bg-purple-600 hover:text-white transition">
                        Register
                    </a>
                @endauth
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton" class="text-white hover:text-purple-300 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-indigo-900/95 py-4">
        <div class="px-4 space-y-2">
            <a href="{{ route('shop.index') }}" class="block text-gray-300 hover:text-white py-2">Shop</a>
            <a href="{{ route('about') }}" class="block text-gray-300 hover:text-white py-2">About</a>
            <a href="{{ route('contact') }}" class="block text-gray-300 hover:text-white py-2">Contact</a>
            @auth
                <hr class="border-gray-700">
                <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-white py-2">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block text-gray-300 hover:text-white py-2">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left text-red-400 hover:text-red-300 py-2">Logout</button>
                </form>
            @else
                <hr class="border-gray-700">
                <a href="{{ route('login') }}" class="block text-center px-4 py-2 bg-purple-600 text-white rounded-lg">Login</a>
                <a href="{{ route('register') }}" class="block text-center px-4 py-2 border border-purple-400 text-purple-300 rounded-lg">Register</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Mobile Menu Toggle
    document.getElementById('mobileMenuButton')?.addEventListener('click', function() {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>