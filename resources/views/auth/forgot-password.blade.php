{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>EktaMart | Reset Password</title>
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
        
        /* Premium Gradient Button */
        .btn-premium {
            background: linear-gradient(105deg, #8b5cf6 0%, #6366f1 50%, #a855f7 100%);
            background-size: 200% auto;
            border-radius: 1rem;
            padding: 0.875rem 1.5rem;
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
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Alert Styles */
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border-left: 3px solid #10b981;
            border-radius: 0.75rem;
            padding: 1rem;
            color: #a7f3d0;
            animation: slideIn 0.3s ease;
            backdrop-filter: blur(8px);
        }
        
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
        
        /* Info Message Box */
        .info-message {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            backdrop-filter: blur(8px);
        }
        
        .info-message i {
            color: #818cf8;
            font-size: 1.25rem;
            margin-top: 0.125rem;
        }
        
        .info-message p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            line-height: 1.5;
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
                    <i class="fas fa-key text-3xl text-purple-300 ml-2"></i>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-purple-200 to-indigo-300 bg-clip-text text-transparent tracking-tight">
                    Reset<span class="text-purple-400">Password</span>
                </h1>
                <p class="text-purple-200/60 text-sm mt-2 font-light">Recover your account access</p>
            </div>

            <!-- Reset Password Card -->
            <div class="glass-premium p-6 md:p-8" id="resetCard">
                <div class="text-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Forgot Password? 🔐</h2>
                    <p class="text-purple-200/60 text-sm mt-1">We'll help you get back in</p>
                </div>

                <!-- Info Message -->
                <div class="info-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No problem! Just enter your email address and we'll send you a password reset link that will allow you to choose a new password.</p>
                </div>

                <!-- Session Status Message -->
                @if(session('status'))
                    <div class="alert-success mb-5 flex items-center gap-2" id="statusAlert">
                        <i class="fas fa-check-circle"></i> 
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

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

                <!-- Reset Form -->
                <form method="POST" action="{{ route('password.email') }}" id="resetForm" novalidate>
                    @csrf

                    <!-- Email Field with Floating Label -->
                    <div class="input-wrapper">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="email"
                               placeholder=" "
                               class="premium-input">
                        <label for="email" class="floating-label">
                            <i class="fas fa-envelope text-xs"></i> Email Address
                        </label>
                        <div class="validation-message" id="emailError"></div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" class="btn-premium w-full text-white font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Reset Link</span>
                        <i class="fas fa-envelope-open-text text-xs opacity-80"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-[rgba(20,20,35,0.8)] px-4 text-purple-300/70 backdrop-blur-sm rounded-full">remember your password?</span>
                    </div>
                </div>

                <!-- Back to Login Link -->
                <p class="text-center">
                    <a href="{{ route('login') }}" class="text-purple-300 font-semibold hover:text-white transition link-premium inline-flex items-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i> Back to Sign In
                    </a>
                </p>
            </div>

            <!-- Security Badge -->
            <div class="text-center text-white/40 text-xs mt-6 flex justify-center gap-4 flex-wrap">
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-shield-alt"></i> SSL Secure</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-lock"></i> 256-bit Encryption</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-envelope"></i> Instant Delivery</span>
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
        gsap.from("#resetCard", { opacity: 0, scale: 0.95, duration: 0.6, delay: 0.2, ease: "power2.out" });
        gsap.from("#logoContainer", { scale: 0, rotation: -180, duration: 0.6, ease: "back.out(1)" });
        gsap.from(".info-message", { opacity: 0, x: -30, duration: 0.5, delay: 0.3 });

        // DOM Elements
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const submitBtn = document.getElementById('submitBtn');
        const resetForm = document.getElementById('resetForm');

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
                emailError.innerHTML = '<span class="text-rose-400 flex items-center gap-1"><i class="fas fa-times-circle text-xs"></i> Please enter a valid email address</span>';
                return false;
            } else {
                emailInput.classList.add('input-success-border');
                emailInput.classList.remove('input-error-border');
                emailError.innerHTML = '<span class="text-emerald-400 flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Valid email address</span>';
                return true;
            }
        }

        // Real-time validation
        emailInput.addEventListener('input', validateEmail);

        // Form Submit with Validation & Loading State
        resetForm.addEventListener('submit', function(e) {
            const isEmailValid = validateEmail();
            
            if (!isEmailValid) {
                e.preventDefault();
                const card = document.querySelector('.glass-premium');
                card.style.animation = 'shake 0.3s ease-in-out';
                setTimeout(() => { card.style.animation = ''; }, 300);
                
                // Focus on email field
                emailInput.focus();
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = '<div class="spinner"></div><span class="ml-2">Sending reset link...</span>';
        });

        // 3D Tilt Effect
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

        // Magnetic Light Effect
        document.addEventListener('mousemove', function(e) {
            if (card) {
                const x = (e.clientX / window.innerWidth) * 100;
                const y = (e.clientY / window.innerHeight) * 100;
                card.style.borderImage = `radial-gradient(circle at ${x}% ${y}%, rgba(139,92,246,0.5), rgba(99,102,241,0.08)) 1`;
                card.style.borderImageSlice = 1;
            }
        });

        // Auto-hide alerts after 5 seconds
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

        // Trigger validation on page load if email exists
        if (emailInput.value) {
            validateEmail();
        }

        // Add focus effect to input wrapper
        emailInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
            setTimeout(() => {
                this.parentElement.style.transform = 'scale(1)';
            }, 200);
        });

        // Console Greeting
        console.log("%c✨ EktaMart Password Reset | Secure & Fast Recovery ✨", "color: #a855f7; font-size: 16px; font-weight: bold;");
        console.log("%c⚡ Features: Real-time validation • Smooth animations • 3D tilt • Instant delivery", "color: #6366f1; font-size: 12px;");
    </script>
</body>
</html>