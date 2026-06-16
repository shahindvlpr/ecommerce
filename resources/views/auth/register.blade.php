{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>EktaMart | Create Account</title>
    <!-- Tailwind CSS v3 + Font Awesome 6 + Google Fonts + GSAP -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Premium Animated Gradient Background */
        body {
            background: linear-gradient(125deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        /* Animated Gradient Orbs */
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
        
        /* Floating Particles */
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
        
        /* Premium Glassmorphism Card */
        .glass-premium {
            background: rgba(15, 15, 35, 0.65);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.05);
            transition: all 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            transform-style: preserve-3d;
        }
        
        /* Input Field Styles */
        .input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
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
        
        /* Floating Label */
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
        }
        
        /* Password Toggle */
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
        
        /* Validation Styles */
        .input-error-border {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
        
        .input-success-border {
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
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Password Strength Indicator */
        .strength-bar {
            transition: all 0.3s ease;
        }
        
        /* Premium Gradient Button */
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
        
        /* Link Styles */
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
        
        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        /* Alert Styles */
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border-left: 3px solid #ef4444;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: #fecaca;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        /* Checkbox */
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
        
        /* Responsive */
        @media (max-width: 640px) {
            .glass-premium {
                margin: 0 0.5rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Animated Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Particle Background -->
    <div id="particles-container" class="fixed inset-0 overflow-hidden pointer-events-none"></div>

    <!-- Main Container -->
    <div class="relative z-10 flex items-center justify-center min-h-screen p-5">
        <div class="w-full max-w-md animate-fade-up" id="main-card">
            
            <!-- Branding -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center bg-gradient-to-tr from-purple-500/20 to-indigo-500/20 backdrop-blur-md p-4 rounded-3xl shadow-2xl border border-white/10 mb-4 transform transition-transform hover:scale-105 duration-300 cursor-pointer" id="logoContainer">
                    <i class="fas fa-crown text-3xl text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-yellow-400"></i>
                    <i class="fas fa-user-plus text-3xl text-purple-300 ml-2"></i>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-purple-200 to-indigo-300 bg-clip-text text-transparent tracking-tight">
                    Join<span class="text-purple-400">EktaMart</span>
                </h1>
                <p class="text-purple-200/60 text-sm mt-2 font-light">Create your premium account</p>
            </div>

            <!-- Registration Card -->
            <div class="glass-premium p-6 md:p-8" id="registerCard">
                <div class="text-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Get Started 🚀</h2>
                    <p class="text-purple-200/60 text-sm mt-1">Join the luxury shopping experience</p>
                </div>

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="alert-error mb-5 space-y-1" id="errorAlert">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-xs"></i> {{ $error }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                    @csrf

                    <!-- Name Field -->
                    <div class="input-wrapper">
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder=" "
                               class="premium-input">
                        <label for="name" class="floating-label">
                            <i class="fas fa-user text-xs"></i> Full Name
                        </label>
                        <div class="validation-message" id="nameError"></div>
                    </div>

                    <!-- Email Field -->
                    <div class="input-wrapper">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               placeholder=" "
                               class="premium-input">
                        <label for="email" class="floating-label">
                            <i class="fas fa-envelope text-xs"></i> Email Address
                        </label>
                        <div class="validation-message" id="emailError"></div>
                    </div>

                    <!-- Password Field -->
                    <div class="input-wrapper">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required 
                               autocomplete="new-password"
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

                    <!-- Password Strength Indicator -->
                    <div id="strengthIndicator" class="hidden mb-4">
                        <div class="flex gap-1 mt-1">
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength1"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength2"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength3"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-600 transition-all duration-300" id="strength4"></div>
                        </div>
                        <p class="text-xs mt-1 text-gray-400" id="strengthText"></p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="input-wrapper">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder=" "
                               class="premium-input">
                        <label for="password_confirmation" class="floating-label">
                            <i class="fas fa-check-circle text-xs"></i> Confirm Password
                        </label>
                        <button type="button" id="toggleConfirmPassword" class="password-toggle">
                            <i class="fas fa-eye-slash" id="toggleConfirmIcon"></i>
                        </button>
                        <div class="validation-message" id="confirmError"></div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start gap-2 mt-4 mb-4">
                        <input type="checkbox" name="terms" id="terms" required class="premium-checkbox mt-1">
                        <label for="terms" class="text-xs text-purple-200/70 cursor-pointer hover:text-purple-200 transition">
                            I agree to the <a href="#" class="text-purple-300 hover:underline">Terms of Service</a> and 
                            <a href="#" class="text-purple-300 hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" class="btn-premium w-full text-white font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Account</span>
                        <i class="fas fa-sparkle text-xs opacity-80"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-[rgba(20,20,35,0.8)] px-4 text-purple-300/70 backdrop-blur-sm rounded-full">already have an account?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <p class="text-center text-purple-200/60 text-sm">
                    <a href="{{ route('login') }}" class="text-purple-300 font-semibold hover:text-white transition link-premium">
                        Sign in to existing account
                    </a>
                </p>
            </div>

            <!-- Security Badge -->
            <div class="text-center text-white/40 text-xs mt-6 flex justify-center gap-4 flex-wrap">
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-shield-alt"></i> SSL Secure</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-lock"></i> 256-bit Encryption</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-database"></i> Data Protected</span>
            </div>
        </div>
    </div>

    <script>
        // Particle System
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 70;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 18 + 10 + 's';
                particle.style.animationDelay = Math.random() * 12 + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                container.appendChild(particle);
            }
        }
        createParticles();

        // GSAP Animations
        gsap.from("#main-card", { opacity: 0, y: 50, duration: 0.8, ease: "back.out(0.5)" });
        gsap.from("#registerCard", { opacity: 0, scale: 0.95, duration: 0.6, delay: 0.2, ease: "power2.out" });
        gsap.from("#logoContainer", { scale: 0, rotation: -180, duration: 0.6, ease: "back.out(1)" });

        // DOM Elements
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const nameError = document.getElementById('nameError');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const confirmError = document.getElementById('confirmError');
        const submitBtn = document.getElementById('submitBtn');
        const strengthIndicator = document.getElementById('strengthIndicator');
        const termsCheckbox = document.getElementById('terms');

        // Name Validation
        function validateName() {
            const name = nameInput.value.trim();
            if (name === '') {
                nameInput.classList.remove('input-success-border', 'input-error-border');
                nameError.innerHTML = '';
                return false;
            }
            if (name.length < 2) {
                nameInput.classList.add('input-error-border');
                nameInput.classList.remove('input-success-border');
                nameError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Name must be at least 2 characters</span>';
                return false;
            }
            nameInput.classList.add('input-success-border');
            nameInput.classList.remove('input-error-border');
            nameError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Valid name</span>';
            return true;
        }

        // Email Validation
        function validateEmail() {
            const email = emailInput.value;
            const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            if (email === '') {
                emailInput.classList.remove('input-success-border', 'input-error-border');
                emailError.innerHTML = '';
                return false;
            }
            if (!emailRegex.test(email)) {
                emailInput.classList.add('input-error-border');
                emailInput.classList.remove('input-success-border');
                emailError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Enter a valid email address</span>';
                return false;
            }
            emailInput.classList.add('input-success-border');
            emailInput.classList.remove('input-error-border');
            emailError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Valid email</span>';
            return true;
        }

        // Password Strength Checker
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
                passwordInput.classList.remove('input-success-border', 'input-error-border');
                passwordError.innerHTML = '';
                return false;
            }
            if (!isValid) {
                passwordInput.classList.add('input-error-border');
                passwordInput.classList.remove('input-success-border');
                passwordError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Password must be at least 6 characters</span>';
                return false;
            }
            passwordInput.classList.add('input-success-border');
            passwordInput.classList.remove('input-error-border');
            const strength = checkPasswordStrength(password);
            if (strength >= 3) {
                passwordError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Strong password</span>';
            } else {
                passwordError.innerHTML = '<span class="text-yellow-400 flex items-center gap-1"><i class="fas fa-info-circle text-xs"></i> Add uppercase, numbers or symbols for stronger security</span>';
            }
            return true;
        }

        function validateConfirm() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            if (confirm === '') {
                confirmInput.classList.remove('input-success-border', 'input-error-border');
                confirmError.innerHTML = '';
                return false;
            }
            if (password !== confirm) {
                confirmInput.classList.add('input-error-border');
                confirmInput.classList.remove('input-success-border');
                confirmError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Passwords do not match</span>';
                return false;
            }
            confirmInput.classList.add('input-success-border');
            confirmInput.classList.remove('input-error-border');
            confirmError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Passwords match</span>';
            return true;
        }

        // Event Listeners
        nameInput.addEventListener('input', validateName);
        emailInput.addEventListener('input', validateEmail);
        passwordInput.addEventListener('input', () => {
            validatePassword();
            updateStrengthIndicator();
            if (confirmInput.value) validateConfirm();
        });
        confirmInput.addEventListener('input', validateConfirm);

        // Password Toggle
        const toggleBtn = document.getElementById('togglePassword');
        const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

        toggleBtn.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            toggleIcon.classList.toggle('fa-eye-slash');
            toggleIcon.classList.toggle('fa-eye');
        });

        toggleConfirmBtn.addEventListener('click', () => {
            const type = confirmInput.type === 'password' ? 'text' : 'password';
            confirmInput.type = type;
            toggleConfirmIcon.classList.toggle('fa-eye-slash');
            toggleConfirmIcon.classList.toggle('fa-eye');
        });

        // Form Submit with Validation
        const registerForm = document.getElementById('registerForm');
        
        registerForm.addEventListener('submit', function(e) {
            const isNameValid = validateName();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            const isConfirmValid = validateConfirm();
            const isTermsChecked = termsCheckbox.checked;
            
            if (!isNameValid || !isEmailValid || !isPasswordValid || !isConfirmValid) {
                e.preventDefault();
                const card = document.querySelector('.glass-premium');
                card.style.animation = 'shake 0.3s ease-in-out';
                setTimeout(() => { card.style.animation = ''; }, 300);
                return;
            }
            
            if (!isTermsChecked) {
                e.preventDefault();
                alert('Please accept the Terms and Conditions to continue.');
                return;
            }
            
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = '<div class="spinner"></div><span class="ml-2">Creating account...</span>';
        });

        // 3D Tilt Effect
        const card = document.querySelector('.glass-premium');
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

        // Magnetic Light Effect
        document.addEventListener('mousemove', function(e) {
            const x = (e.clientX / window.innerWidth) * 100;
            const y = (e.clientY / window.innerHeight) * 100;
            card.style.borderImage = `radial-gradient(circle at ${x}% ${y}%, rgba(139,92,246,0.5), rgba(99,102,241,0.08)) 1`;
            card.style.borderImageSlice = 1;
        });

        // Auto-hide error alert
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(() => {
                gsap.to(errorAlert, { opacity: 0, y: -20, duration: 0.5, onComplete: () => errorAlert.remove() });
            }, 5000);
        }

        // Trigger initial validation if values exist
        if (nameInput.value) validateName();
        if (emailInput.value) validateEmail();
        if (passwordInput.value) {
            validatePassword();
            updateStrengthIndicator();
        }
        if (confirmInput.value) validateConfirm();

        console.log("%c✨ EktaMart Premium Registration | Secure & Elegant ✨", "color: #a855f7; font-size: 16px; font-weight: bold;");
        console.log("%c⚡ Features: Real-time validation • Password strength • 3D tilt • Dynamic animations", "color: #6366f1; font-size: 12px;");
    </script>
</body>
</html>