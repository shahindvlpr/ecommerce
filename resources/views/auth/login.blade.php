{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>EktaMart | Premium Login</title>
    <!-- Tailwind CSS v3 + Font Awesome 6 + Google Fonts + GSAP for smooth animations -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Premium Animated Gradient Background with shifting colors */
        body {
            background: linear-gradient(125deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        /* Animated Gradient Orb Backgrounds */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            pointer-events: none;
            animation: floatOrb 20s ease-in-out infinite;
            z-index: 0;
        }
        
        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        .orb-1 { width: 400px; height: 400px; background: #8b5cf6; top: -100px; right: -100px; animation-delay: 0s; }
        .orb-2 { width: 500px; height: 500px; background: #6366f1; bottom: -150px; left: -150px; animation-delay: -5s; }
        .orb-3 { width: 300px; height: 300px; background: #a855f7; top: 50%; left: 50%; animation-delay: -10s; opacity: 0.3; }
        
        /* Floating Particles Animation - Enhanced */
        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(139,92,246,0.6), rgba(99,102,241,0));
            border-radius: 50%;
            pointer-events: none;
            animation: floatParticle linear infinite;
            z-index: 0;
        }
        
        @keyframes floatParticle {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.6; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }
        
        /* Ultra Premium Glassmorphism Card with 3D effect */
        .glass-premium {
            background: rgba(15, 15, 35, 0.65);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.05);
            transition: all 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            transform-style: preserve-3d;
        }
        
        /* Modern Input Field Styles with Enhanced Focus */
        .input-wrapper {
            position: relative;
            margin-bottom: 1.75rem;
        }
        
        .premium-input {
            width: 100%;
            background: rgba(10, 10, 25, 0.7);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1rem 1rem 0.5rem 1rem;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .premium-input:focus {
            border-color: #8b5cf6;
            background: rgba(20, 20, 40, 0.9);
            box-shadow: 0 0 0 5px rgba(139, 92, 246, 0.2);
        }
        
        /* Enhanced Floating Label */
        .floating-label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            padding: 0 0.25rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .premium-input:focus ~ .floating-label,
        .premium-input:not(:placeholder-shown) ~ .floating-label {
            top: -0.75rem;
            left: 0.85rem;
            transform: translateY(0);
            font-size: 0.7rem;
            color: #c4b5fd;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 0.2rem 0.7rem;
            border-radius: 50px;
            letter-spacing: 0.5px;
            font-weight: 600;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        
        .premium-input::placeholder {
            color: transparent;
            transition: color 0.2s;
        }
        
        .premium-input:focus::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }
        
        /* Animated Password Toggle */
        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.2s;
            z-index: 2;
            padding: 0.5rem;
            border-radius: 50%;
        }
        
        .password-toggle:hover {
            color: #c4b5fd;
            background: rgba(139, 92, 246, 0.2);
            transform: translateY(-50%) scale(1.1);
        }
        
        /* Premium Gradient Button with Loading State */
        .btn-premium {
            background: linear-gradient(105deg, #8b5cf6 0%, #6366f1 50%, #a855f7 100%);
            background-size: 200% auto;
            border-radius: 1rem;
            padding: 0.875rem;
            font-weight: 700;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -10px #8b5cf6;
            background-position: right center;
        }
        
        .btn-premium:active {
            transform: translateY(0);
        }
        
        /* Loading Spinner */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }
        
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Social Login Buttons - Enhanced */
        .social-premium {
            background: rgba(30, 30, 50, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            padding: 0.75rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: white;
            width: 100%;
        }
        
        .social-premium:hover {
            background: rgba(139, 92, 246, 0.25);
            border-color: #8b5cf6;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px -8px rgba(139, 92, 246, 0.4);
            color: white;
        }
        
        /* Real-time Validation Styles */
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
        
        .input-success {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
        
        .validation-message {
            font-size: 0.7rem;
            margin-top: 0.25rem;
            margin-left: 0.5rem;
            animation: slideDown 0.2s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Animated Underline for Links */
        .link-premium {
            position: relative;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .link-premium::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #a855f7, #6366f1);
            transition: width 0.3s ease;
        }
        
        .link-premium:hover::after {
            width: 100%;
        }
        
        /* Fade In Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        /* Alert Styles with Animation */
        .alert-success, .alert-error {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            animation: slideIn 0.3s ease;
            backdrop-filter: blur(8px);
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border-left: 3px solid #10b981;
            color: #a7f3d0;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border-left: 3px solid #ef4444;
            color: #fecaca;
        }
        
        /* Checkbox Styling */
        .premium-checkbox {
            accent-color: #8b5cf6;
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .premium-checkbox:hover {
            transform: scale(1.1);
        }
        
        /* Typing Animation Effect */
        @keyframes typingPulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }
        
        .typing-effect {
            animation: typingPulse 1s ease-in-out infinite;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 640px) {
            .glass-premium {
                margin: 0 0.5rem;
                padding: 1.5rem;
            }
            .social-premium span {
                display: none;
            }
            .social-premium {
                padding: 0.6rem;
            }
        }
    </style>
</head>
<body>

    <!-- Animated Gradient Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Dynamic Particle Background -->
    <div id="particles-container" class="fixed inset-0 overflow-hidden pointer-events-none"></div>

    <!-- Main Container -->
    <div class="relative z-10 flex items-center justify-center min-h-screen p-5">
        <div class="w-full max-w-md animate-fade-up" id="main-card">
            
            <!-- Premium Branding with Animated Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center bg-gradient-to-tr from-purple-500/20 to-indigo-500/20 backdrop-blur-md p-4 rounded-3xl shadow-2xl border border-white/10 mb-4 transform transition-transform hover:scale-105 duration-300 cursor-pointer" id="logoContainer">
                    <i class="fas fa-crown text-3xl text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-yellow-400"></i>
                    <i class="fas fa-store text-3xl text-purple-300 ml-2"></i>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-purple-200 to-indigo-300 bg-clip-text text-transparent tracking-tight" id="brandTitle">
                    Ekta<span class="text-purple-400">Mart</span>
                </h1>
                <p class="text-purple-200/60 text-sm mt-2 font-light" id="tagline">Luxury shopping experience</p>
            </div>

            <!-- Premium Glass Card -->
            <div class="glass-premium p-6 md:p-8" id="loginCard">
                <div class="text-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Welcome Back ✨</h2>
                    <p class="text-purple-200/60 text-sm mt-1">Sign in to your account</p>
                </div>

                <!-- Laravel Session Messages with Auto-hide -->
                @if(session('status'))
                    <div class="alert-success mb-5 flex items-center gap-2" id="statusAlert">
                        <i class="fas fa-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error mb-5 space-y-1" id="errorAlert">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-xs"></i> {{ $error }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                    @csrf

                    <!-- Email Field with Floating Label & Real-time Validation -->
                    <div class="input-wrapper">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder=" "
                               class="premium-input">
                        <label for="email" class="floating-label">
                            <i class="fas fa-envelope text-xs"></i> Email Address
                        </label>
                        <div class="validation-message" id="emailError"></div>
                    </div>

                    <!-- Password Field with Floating Label & Toggle -->
                    <div class="input-wrapper">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required 
                               autocomplete="current-password"
                               placeholder=" "
                               class="premium-input">
                        <label for="password" class="floating-label">
                            <i class="fas fa-lock text-xs"></i> Password
                        </label>
                        <button type="button" id="togglePassword" class="password-toggle">
                            <i class="fas fa-eye-slash" id="toggleIcon"></i>
                        </button>
                        <div class="validation-message" id="passwordError"></div>
                    </div>

                    <!-- Password Strength Indicator (Dynamic) -->
                    <div id="strengthIndicator" class="hidden mb-3">
                        <div class="flex gap-1 mt-1">
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength1"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength2"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength3"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength4"></div>
                        </div>
                        <p class="text-xs mt-1 text-gray-400" id="strengthText"></p>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-4">
                        <label class="flex items-center text-sm text-purple-200/70 cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember" class="premium-checkbox">
                            <span class="group-hover:text-purple-200 transition">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-purple-300 hover:text-purple-200 font-medium link-premium">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button with Loading State -->
                    <button type="submit" id="submitBtn" class="btn-premium w-full text-white font-semibold mt-6 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        <span>Sign In</span>
                        <i class="fas fa-sparkle text-xs opacity-80"></i>
                    </button>
                </form>

                <!-- Divider with shine effect -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-[rgba(20,20,35,0.8)] px-4 text-purple-300/70 backdrop-blur-sm rounded-full">or continue with</span>
                    </div>
                </div>

                <!-- ============================================
                     SOCIAL LOGIN OPTIONS (FULLY INTEGRATED)
                ============================================ -->
                <div class="grid grid-cols-3 gap-3">
                    <!-- Google Login -->
                    <a href="{{ route('auth.google') }}" class="social-premium flex items-center justify-center gap-2 text-white transition-all" data-social="google">
                        <i class="fab fa-google text-rose-400 text-lg"></i>
                        <span class="text-sm font-medium hidden sm:inline">Google</span>
                    </a>

                    <!-- Facebook Login -->
                    <a href="{{ route('auth.facebook') }}" class="social-premium flex items-center justify-center gap-2 text-white transition-all" data-social="facebook">
                        <i class="fab fa-facebook text-blue-400 text-lg"></i>
                        <span class="text-sm font-medium hidden sm:inline">Facebook</span>
                    </a>

                    <!-- GitHub Login (Optional - Extra) -->
                    <a href="{{ route('auth.github') }}" class="social-premium flex items-center justify-center gap-2 text-white transition-all" data-social="github">
                        <i class="fab fa-github text-gray-300 text-lg"></i>
                        <span class="text-sm font-medium hidden sm:inline">GitHub</span>
                    </a>
                </div>

                <!-- Sign Up Link -->
                <p class="text-center text-purple-200/60 text-sm mt-6">
                    New to EktaMart? 
                    <a href="{{ route('register') }}" class="text-purple-300 font-semibold hover:text-white transition link-premium">
                        Create free account
                    </a>
                </p>
            </div>

            <!-- Security Badge with Dynamic Icons -->
            <div class="text-center text-white/40 text-xs mt-6 flex justify-center gap-4 flex-wrap">
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-shield-alt"></i> SSL Secure</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-lock"></i> 256-bit Encryption</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-shield-heart"></i> Privacy Protected</span>
            </div>
        </div>
    </div>

    <script>
        // ==================== ENHANCED PARTICLE SYSTEM ====================
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 80;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 8 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 20 + 12 + 's';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                container.appendChild(particle);
            }
        }
        createParticles();

        // ==================== GSAP ANIMATIONS ====================
        gsap.from("#main-card", {
            opacity: 0,
            y: 50,
            duration: 0.8,
            ease: "back.out(0.5)"
        });
        
        gsap.from("#loginCard", {
            opacity: 0,
            scale: 0.95,
            duration: 0.6,
            delay: 0.2,
            ease: "power2.out"
        });
        
        gsap.from("#logoContainer", {
            scale: 0,
            rotation: -180,
            duration: 0.6,
            ease: "back.out(1)"
        });
        
        // Animate security badges
        gsap.from(".text-center .flex span", {
            opacity: 0,
            y: 20,
            stagger: 0.1,
            duration: 0.5,
            delay: 0.5
        });

        // ==================== REAL-TIME VALIDATION ====================
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const submitBtn = document.getElementById('submitBtn');
        const strengthIndicator = document.getElementById('strengthIndicator');
        
        // Email validation
        function validateEmail() {
            const email = emailInput.value;
            const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            
            if (email === '') {
                emailInput.classList.remove('input-success', 'input-error');
                emailError.innerHTML = '';
                return false;
            }
            
            if (!emailRegex.test(email)) {
                emailInput.classList.add('input-error');
                emailInput.classList.remove('input-success');
                emailError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Please enter a valid email address</span>';
                return false;
            } else {
                emailInput.classList.add('input-success');
                emailInput.classList.remove('input-error');
                emailError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Valid email</span>';
                return true;
            }
        }
        
        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            return Math.min(strength, 4);
        }
        
        function updateStrengthIndicator() {
            const password = passwordInput.value;
            
            if (password === '') {
                strengthIndicator.classList.add('hidden');
                return;
            }
            
            strengthIndicator.classList.remove('hidden');
            const strength = checkPasswordStrength(password);
            const bars = ['strength1', 'strength2', 'strength3', 'strength4'];
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
            const texts = ['Very Weak', 'Weak', 'Good', 'Strong'];
            
            for (let i = 0; i < 4; i++) {
                const bar = document.getElementById(bars[i]);
                if (i < strength) {
                    bar.className = `h-1 flex-1 rounded-full ${colors[strength-1]} transition-all duration-300`;
                } else {
                    bar.className = 'h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300';
                }
            }
            
            document.getElementById('strengthText').innerHTML = texts[strength-1] || '';
            document.getElementById('strengthText').className = `text-xs mt-1 ${strength >= 3 ? 'text-green-400' : 'text-yellow-400'}`;
            
            return strength >= 2;
        }
        
        function validatePassword() {
            const password = passwordInput.value;
            const isValid = password.length >= 6;
            
            if (password === '') {
                passwordInput.classList.remove('input-success', 'input-error');
                passwordError.innerHTML = '';
                return false;
            }
            
            if (!isValid) {
                passwordInput.classList.add('input-error');
                passwordInput.classList.remove('input-success');
                passwordError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Password must be at least 6 characters</span>';
                return false;
            } else {
                passwordInput.classList.add('input-success');
                passwordInput.classList.remove('input-error');
                const strength = checkPasswordStrength(password);
                if (strength >= 3) {
                    passwordError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Strong password</span>';
                } else {
                    passwordError.innerHTML = '<span class="text-yellow-400 flex items-center gap-1"><i class="fas fa-info-circle text-xs"></i> Add uppercase, numbers or symbols for stronger security</span>';
                }
                return true;
            }
        }
        
        emailInput.addEventListener('input', validateEmail);
        passwordInput.addEventListener('input', () => {
            validatePassword();
            updateStrengthIndicator();
        });
        
        // ==================== LOADING STATE ON FORM SUBMIT ====================
        const loginForm = document.getElementById('loginForm');
        
        loginForm.addEventListener('submit', function(e) {
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            
            if (!isEmailValid || !isPasswordValid) {
                e.preventDefault();
                // Shake animation for error
                const card = document.querySelector('.glass-premium');
                card.style.animation = 'shake 0.3s ease-in-out';
                setTimeout(() => { card.style.animation = ''; }, 300);
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = '<div class="spinner"></div><span class="ml-2">Signing in...</span>';
        });
        
        // Shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);
        
        // ==================== PASSWORD TOGGLE ====================
        const toggleBtn = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (toggleBtn && passwordField) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                toggleIcon.classList.toggle('fa-eye-slash');
                toggleIcon.classList.toggle('fa-eye');
            });
        }
        
        // ==================== 3D TILT EFFECT ON CARD ====================
        const card = document.querySelector('.glass-premium');
        if (card) {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;
                
                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0)';
            });
        }
        
        // ==================== AUTO-HIDE ALERTS AFTER 5 SECONDS ====================
        const statusAlert = document.getElementById('statusAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        if (statusAlert) {
            setTimeout(() => {
                gsap.to(statusAlert, { opacity: 0, y: -20, duration: 0.5, onComplete: () => statusAlert.remove() });
            }, 5000);
        }
        
        if (errorAlert) {
            setTimeout(() => {
                gsap.to(errorAlert, { opacity: 0, y: -20, duration: 0.5, onComplete: () => errorAlert.remove() });
            }, 5000);
        }
        
        // ==================== SOCIAL BUTTON LOGGING ====================
        const socialBtns = document.querySelectorAll('.social-premium');
        socialBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const social = this.getAttribute('data-social');
                this.style.transform = 'scale(0.95)';
                setTimeout(() => { this.style.transform = ''; }, 150);
                console.log(`%c🔗 Redirecting to ${social} login...`, 'color: #a855f7');
            });
        });
        
        // ==================== FOCUS RIPPLE EFFECT ====================
        const inputs = document.querySelectorAll('.premium-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
                setTimeout(() => {
                    this.parentElement.style.transform = 'scale(1)';
                }, 200);
            });
        });
        
        // ==================== MAGNETIC LIGHT EFFECT ON CARD ====================
        document.addEventListener('mousemove', function(e) {
            const x = (e.clientX / window.innerWidth) * 100;
            const y = (e.clientY / window.innerHeight) * 100;
            if (card) {
                card.style.borderImage = `radial-gradient(circle at ${x}% ${y}%, rgba(139,92,246,0.5), rgba(99,102,241,0.08)) 1`;
                card.style.borderImageSlice = 1;
            }
        });
        
        // ==================== TRIGGER VALIDATION ON LOAD IF HAS VALUE ====================
        if (emailInput.value) validateEmail();
        if (passwordInput.value) {
            validatePassword();
            updateStrengthIndicator();
        }
        
        // ==================== CONSOLE GREETING ====================
        console.log("%c✨ EktaMart Premium Login | Ultra Dynamic & Secure ✨", "color: #a855f7; font-size: 16px; font-weight: bold;");
        console.log("%c⚡ Features: Real-time validation • Password strength • 3D tilt • Particle system • Loading states", "color: #6366f1; font-size: 12px;");
        console.log("%c🔗 Social Login: Google • Facebook • GitHub", "color: #8b5cf6; font-size: 12px;");
    </script>
</body>
</html>