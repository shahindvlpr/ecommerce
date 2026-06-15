{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>EktaMart | Premium Login</title>
    <!-- Tailwind CSS v3 + Font Awesome 6 + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        /* Premium Animated Gradient Background */
        body {
            background: radial-gradient(circle at 20% 30%, #0f0c29, #302b63, #24243e);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        /* Floating Particles Animation */
        .particle {
            position: absolute;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.4), rgba(99, 102, 241, 0.2));
            border-radius: 50%;
            pointer-events: none;
            animation: floatParticle linear infinite;
            z-index: 0;
        }
        
        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% {
                transform: translateY(-20vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Premium Glassmorphism Card */
        .glass-premium {
            background: rgba(15, 15, 30, 0.75);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.08);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        
        .glass-premium:hover {
            border-color: rgba(139, 92, 246, 0.5);
            box-shadow: 0 30px 60px -12px rgba(139, 92, 246, 0.3);
        }
        
        /* Modern Input Field Styles */
        .input-wrapper {
            position: relative;
            margin-bottom: 1.75rem;
        }
        
        .premium-input {
            width: 100%;
            background: rgba(10, 10, 20, 0.6);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
            padding: 1rem 1rem 0.5rem 1rem;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .premium-input:focus {
            border-color: #8b5cf6;
            background: rgba(20, 20, 35, 0.8);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
        }
        
        /* Floating Label Styles - Beautiful Top Border Animation */
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
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            z-index: 1;
        }
        
        /* When input is focused OR has content, label moves to top border */
        .premium-input:focus ~ .floating-label,
        .premium-input:not(:placeholder-shown) ~ .floating-label {
            top: -0.65rem;
            left: 0.85rem;
            transform: translateY(0);
            font-size: 0.7rem;
            color: #a78bfa;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 0 0.5rem;
            border-radius: 20px;
            letter-spacing: 0.5px;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }
        
        /* Placeholder hidden until focus */
        .premium-input::placeholder {
            color: transparent;
            transition: color 0.2s;
        }
        
        .premium-input:focus::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        
        /* Password Toggle Button */
        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: color 0.2s;
            z-index: 2;
        }
        
        .password-toggle:hover {
            color: #a78bfa;
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -8px #8b5cf6;
            background-position: right center;
        }
        
        /* Social Login Buttons */
        .social-premium {
            background: rgba(30, 30, 50, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 0.7rem;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        
        .social-premium:hover {
            background: rgba(139, 92, 246, 0.2);
            border-color: #8b5cf6;
            transform: translateY(-3px);
        }
        
        /* Animated Underline for Links */
        .link-premium {
            position: relative;
            text-decoration: none;
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
            animation: fadeInUp 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        /* Alert Styles */
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 0.75rem;
            padding: 0.75rem;
            color: #a7f3d0;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 0.75rem;
            padding: 0.75rem;
            color: #fecaca;
        }
        
        /* Checkbox Styling */
        .premium-checkbox {
            accent-color: #8b5cf6;
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="flex items-center justify-center p-5 relative">

    <!-- Dynamic Particle Background -->
    <div id="particles-container" class="fixed inset-0 overflow-hidden pointer-events-none"></div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md animate-fade-up">
        
        <!-- Premium Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-gradient-to-tr from-purple-500/20 to-indigo-500/20 backdrop-blur-md p-4 rounded-3xl shadow-2xl border border-white/10 mb-4">
                <i class="fas fa-crown text-3xl text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-yellow-400"></i>
                <i class="fas fa-store text-3xl text-purple-300 ml-2"></i>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-purple-200 to-indigo-300 bg-clip-text text-transparent tracking-tight">
                Ekta<span class="text-purple-400">Mart</span>
            </h1>
            <p class="text-purple-200/60 text-sm mt-2 font-light">Luxury shopping experience</p>
        </div>

        <!-- Premium Glass Card -->
        <div class="glass-premium p-6 md:p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-white">Welcome Back ✨</h2>
                <p class="text-purple-200/60 text-sm mt-1">Sign in to your account</p>
            </div>

            <!-- Laravel Session Messages -->
            @if(session('status'))
                <div class="alert-success mb-5 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error mb-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-xs"></i> {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-2">
                @csrf

                <!-- Email Field with Floating Label -->
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
                        <i class="fas fa-envelope mr-2 text-xs"></i> Email Address
                    </label>
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
                        <i class="fas fa-lock mr-2 text-xs"></i> Password
                    </label>
                    <button type="button" id="togglePassword" class="password-toggle">
                        <i class="fas fa-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center text-sm text-purple-200/70 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="premium-checkbox">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-300 hover:text-purple-200 font-medium link-premium">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-premium w-full text-white font-semibold mt-6 flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-right-to-bracket"></i> Sign In
                    <i class="fas fa-sparkle text-xs opacity-80"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/10"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="bg-[rgba(20,20,35,0.8)] px-4 text-purple-300/70 backdrop-blur-sm rounded-full">or continue with</span>
                </div>
            </div>

            <!-- Social Login Options -->
            <div class="grid grid-cols-3 gap-3">
                <button class="social-premium flex items-center justify-center gap-2 text-white transition-all">
                    <i class="fab fa-google text-rose-400"></i>
                    <span class="text-sm font-medium hidden sm:inline">Google</span>
                </button>
                <button class="social-premium flex items-center justify-center gap-2 text-white transition-all">
                    <i class="fab fa-facebook text-blue-400"></i>
                    <span class="text-sm font-medium hidden sm:inline">Facebook</span>
                </button>
                <button class="social-premium flex items-center justify-center gap-2 text-white transition-all">
                    <i class="fab fa-apple text-gray-200"></i>
                    <span class="text-sm font-medium hidden sm:inline">Apple</span>
                </button>
            </div>

            <!-- Sign Up Link -->
            <p class="text-center text-purple-200/60 text-sm mt-6">
                New to EktaMart? 
                <a href="{{ route('register') }}" class="text-purple-300 font-semibold hover:text-white transition link-premium">
                    Create free account
                </a>
            </p>
        </div>

        <!-- Security Badge -->
        <div class="text-center text-white/40 text-xs mt-6 flex justify-center gap-4">
            <span><i class="fas fa-shield-alt mr-1"></i> SSL Secure</span>
            <span><i class="fas fa-lock mr-1"></i> 256-bit Encryption</span>
            <span><i class="fas fa-shield-hart mr-1"></i> Privacy Protected</span>
        </div>
    </div>

    <script>
        // Create Floating Particles Background
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 50;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 15 + 10 + 's';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.opacity = Math.random() * 0.4 + 0.1;
                container.appendChild(particle);
            }
        }
        createParticles();

        // Password Toggle Functionality
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

        // Add focus effect to float labels even more elegantly
        const inputs = document.querySelectorAll('.premium-input');
        inputs.forEach(input => {
            // On focus, add a subtle scale effect to the wrapper
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
                setTimeout(() => {
                    this.parentElement.style.transform = 'scale(1)';
                }, 200);
            });
            
            // Trigger label state on page load if input has value
            if (input.value.trim() !== '') {
                input.dispatchEvent(new Event('input'));
            }
        });

        // Ripple Effect for Buttons
        const btns = document.querySelectorAll('.btn-premium, .social-premium');
        btns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.classList.contains('social-premium')) return; // skip ripple for social buttons
                let rect = this.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;
                let ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.width = '0px';
                ripple.style.height = '0px';
                ripple.style.borderRadius = '50%';
                ripple.style.backgroundColor = 'rgba(255,255,255,0.4)';
                ripple.style.transform = 'translate(-50%, -50%)';
                ripple.style.transition = 'width 0.4s, height 0.4s, opacity 0.4s';
                ripple.style.pointerEvents = 'none';
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                setTimeout(() => {
                    ripple.style.width = '200px';
                    ripple.style.height = '200px';
                    ripple.style.opacity = '0';
                }, 10);
                setTimeout(() => ripple.remove(), 500);
            });
        });

        // Magnetic Light Effect on Card
        const card = document.querySelector('.glass-premium');
        if (card) {
            document.addEventListener('mousemove', function(e) {
                let x = (e.clientX / window.innerWidth) * 100;
                let y = (e.clientY / window.innerHeight) * 100;
                card.style.borderImage = `radial-gradient(circle at ${x}% ${y}%, rgba(139,92,246,0.4), rgba(99,102,241,0.05)) 1`;
                card.style.borderImageSlice = 1;
            });
        }

        // Console Greeting
        console.log("%c✨ EktaMart Premium Login | Secure & Elegant ✨", "color: #a855f7; font-size: 14px; font-weight: bold;");
    </script>
</body>
</html>