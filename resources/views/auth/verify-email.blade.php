{{-- resources/views/auth/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>EktaMart | Verify Email</title>
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
        
        .btn-secondary {
            background: rgba(30, 30, 50, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            color: white;
        }
        
        .btn-secondary:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
            transform: translateY(-2px);
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
            background: linear-gradient(90deg, #ef4444, #dc2626);
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
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.05); opacity: 1; }
        }
        
        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
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
        
        .alert-info {
            background: rgba(59, 130, 246, 0.15);
            border-left: 3px solid #3b82f6;
            border-radius: 0.75rem;
            padding: 1rem;
            color: #bfdbfe;
            animation: slideIn 0.3s ease;
            backdrop-filter: blur(8px);
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        /* Mail Icon Animation */
        .mail-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* Envelope Badge */
        .envelope-badge {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(99, 102, 241, 0.1));
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        
        /* Countdown Timer */
        .countdown-timer {
            font-family: 'Inter', monospace;
            font-weight: 700;
            background: rgba(0, 0, 0, 0.3);
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .glass-premium {
                margin: 0 0.5rem;
                padding: 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .action-buttons form {
                width: 100%;
            }
            
            .action-buttons button {
                width: 100%;
                justify-content: center;
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
                    <i class="fas fa-envelope-open-text text-3xl text-purple-300 ml-2 mail-icon"></i>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-purple-200 to-indigo-300 bg-clip-text text-transparent tracking-tight">
                    Verify<span class="text-purple-400">Email</span>
                </h1>
                <p class="text-purple-200/60 text-sm mt-2 font-light">Confirm your email address</p>
            </div>

            <!-- Verify Email Card -->
            <div class="glass-premium p-6 md:p-8" id="verifyCard">
                
                <!-- Envelope Badge -->
                <div class="flex justify-center mb-6">
                    <div class="envelope-badge">
                        <i class="fas fa-envelope text-purple-400"></i>
                        <span class="text-white text-sm">Verification Required</span>
                    </div>
                </div>

                <div class="text-center mb-5">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-tr from-purple-500/20 to-indigo-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope fa-3x text-purple-400 mail-icon"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Check Your Inbox 📧</h2>
                </div>

                <!-- Info Message -->
                <div class="alert-info mb-5 flex items-start gap-3">
                    <i class="fas fa-info-circle mt-0.5"></i>
                    <p class="text-sm leading-relaxed">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
                </div>

                <!-- Success Message (when verification link sent) -->
                @if (session('status') == 'verification-link-sent')
                    <div class="alert-success mb-5 flex items-center gap-3" id="successAlert">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span class="text-sm">A new verification link has been sent to your email address.</span>
                    </div>
                @endif

                <!-- Instruction Steps -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-sm text-purple-200/70">
                        <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-300 text-xs font-bold">1</div>
                        <span>Check your email inbox (and spam folder)</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-purple-200/70">
                        <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-300 text-xs font-bold">2</div>
                        <span>Click the verification link in the email</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-purple-200/70">
                        <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-300 text-xs font-bold">3</div>
                        <span>Return to EktaMart to start shopping</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-[rgba(20,20,35,0.8)] px-4 text-purple-300/70 backdrop-blur-sm rounded-full">didn't receive the email?</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons flex items-center justify-between gap-4">
                    <!-- Resend Verification Form -->
                    <form method="POST" action="{{ route('verification.send') }}" id="resendForm" class="flex-1">
                        @csrf
                        <button type="submit" id="resendBtn" class="btn-premium w-full text-white font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Resend Email</span>
                        </button>
                    </form>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="flex-1">
                        @csrf
                        <button type="submit" id="logoutBtn" class="btn-secondary w-full flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>

                <!-- Resend Timer / Cooldown Indicator -->
                <div class="text-center mt-5 pt-3 border-t border-white/10">
                    <p class="text-xs text-purple-300/50 flex items-center justify-center gap-2">
                        <i class="fas fa-clock"></i>
                        <span id="resendTimerText">You can request a new link now</span>
                    </p>
                </div>
            </div>

            <!-- Help Notice -->
            <div class="text-center text-white/40 text-xs mt-6 flex justify-center gap-4 flex-wrap">
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-envelope"></i> Check Spam Folder</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-question-circle"></i> Need Help?</span>
                <span class="flex items-center gap-1 hover:text-white/60 transition"><i class="fas fa-shield-alt"></i> Secure Verification</span>
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
        gsap.from("#verifyCard", { opacity: 0, scale: 0.95, duration: 0.6, delay: 0.2, ease: "power2.out" });
        gsap.from("#logoContainer", { scale: 0, rotation: -180, duration: 0.6, ease: "back.out(1)" });
        gsap.from(".envelope-badge", { opacity: 0, y: -20, duration: 0.4, delay: 0.3 });
        
        // Animate instruction steps
        gsap.from(".space-y-3 > div", {
            opacity: 0,
            x: -20,
            stagger: 0.1,
            duration: 0.4,
            delay: 0.4
        });

        // ==================== RESEND BUTTON COOLDOWN TIMER ====================
        // Check if resend was recently clicked (using sessionStorage or localStorage)
        const LAST_RESEND_KEY = 'ekta_resend_timestamp';
        const COOLDOWN_SECONDS = 60; // 60 seconds cooldown
        
        const resendBtn = document.getElementById('resendBtn');
        const resendTimerText = document.getElementById('resendTimerText');
        const resendForm = document.getElementById('resendForm');
        
        function updateCooldown() {
            const lastResend = localStorage.getItem(LAST_RESEND_KEY);
            if (lastResend) {
                const elapsed = Math.floor((Date.now() - parseInt(lastResend)) / 1000);
                const remaining = COOLDOWN_SECONDS - elapsed;
                
                if (remaining > 0) {
                    // Disable button and show countdown
                    resendBtn.disabled = true;
                    resendBtn.style.opacity = '0.6';
                    resendBtn.style.cursor = 'not-allowed';
                    resendTimerText.innerHTML = `<i class="fas fa-hourglass-half"></i> You can request again in ${remaining} seconds`;
                    
                    // Update countdown every second
                    const timerInterval = setInterval(() => {
                        const newElapsed = Math.floor((Date.now() - parseInt(localStorage.getItem(LAST_RESEND_KEY))) / 1000);
                        const newRemaining = COOLDOWN_SECONDS - newElapsed;
                        
                        if (newRemaining <= 0) {
                            clearInterval(timerInterval);
                            resendBtn.disabled = false;
                            resendBtn.style.opacity = '1';
                            resendBtn.style.cursor = 'pointer';
                            resendTimerText.innerHTML = '<i class="fas fa-paper-plane"></i> You can request a new link now';
                        } else {
                            resendTimerText.innerHTML = `<i class="fas fa-hourglass-half"></i> You can request again in ${newRemaining} seconds`;
                        }
                    }, 1000);
                    
                    return true;
                }
            }
            // No cooldown active
            resendBtn.disabled = false;
            resendBtn.style.opacity = '1';
            resendBtn.style.cursor = 'pointer';
            resendTimerText.innerHTML = '<i class="fas fa-paper-plane"></i> You can request a new link now';
            return false;
        }
        
        // Handle resend form submission
        if (resendForm) {
            resendForm.addEventListener('submit', function(e) {
                const isOnCooldown = updateCooldown();
                if (isOnCooldown === true) {
                    e.preventDefault();
                    // Show toast/message
                    showToast('Please wait before requesting another verification email.', 'warning');
                    return;
                }
                
                // Set loading state
                resendBtn.classList.add('btn-loading');
                const originalHtml = resendBtn.innerHTML;
                resendBtn.innerHTML = '<div class="spinner"></div><span class="ml-2">Sending...</span>';
                
                // Store timestamp for cooldown
                localStorage.setItem(LAST_RESEND_KEY, Date.now().toString());
                
                // Allow form to submit normally
                setTimeout(() => {
                    // Don't reset here - form will reload page
                }, 100);
            });
        }
        
        // Handle logout button (optional loading state)
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutForm = document.getElementById('logoutForm');
        
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                logoutBtn.classList.add('btn-loading');
                logoutBtn.innerHTML = '<div class="spinner"></div><span class="ml-2">Logging out...</span>';
            });
        }
        
        // Toast notification function
        function showToast(message, type = 'info') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed bottom-5 left-1/2 transform -translate-x-1/2 z-50 px-4 py-3 rounded-xl shadow-lg backdrop-blur-md flex items-center gap-2 animate-fade-up`;
            
            if (type === 'warning') {
                toast.style.background = 'rgba(245, 158, 11, 0.9)';
                toast.style.border = '1px solid #f59e0b';
                toast.innerHTML = `<i class="fas fa-exclamation-triangle text-white"></i><span class="text-white text-sm">${message}</span>`;
            } else if (type === 'success') {
                toast.style.background = 'rgba(16, 185, 129, 0.9)';
                toast.style.border = '1px solid #10b981';
                toast.innerHTML = `<i class="fas fa-check-circle text-white"></i><span class="text-white text-sm">${message}</span>`;
            } else {
                toast.style.background = 'rgba(59, 130, 246, 0.9)';
                toast.style.border = '1px solid #3b82f6';
                toast.innerHTML = `<i class="fas fa-info-circle text-white"></i><span class="text-white text-sm">${message}</span>`;
            }
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                gsap.to(toast, { opacity: 0, y: 20, duration: 0.3, onComplete: () => toast.remove() });
            }, 3000);
        }
        
        // Initialize cooldown on page load
        updateCooldown();
        
        // Auto-hide success alert after 8 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                gsap.to(successAlert, { opacity: 0, y: -20, duration: 0.5, onComplete: () => successAlert.remove() });
            }, 8000);
        }
        
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
        
        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn-premium, .btn-secondary');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.width = '0px';
                ripple.style.height = '0px';
                ripple.style.borderRadius = '50%';
                ripple.style.backgroundColor = 'rgba(255,255,255,0.3)';
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

        // Console Greeting
        console.log("%c✨ EktaMart Email Verification | Secure Account Activation ✨", "color: #a855f7; font-size: 16px; font-weight: bold;");
        console.log("%c⚡ Features: Resend cooldown • 3D tilt • Particle effects • Smart notifications", "color: #6366f1; font-size: 12px;");
        
        // Show helpful tip in console
        console.log("%c💡 Tip: Didn't receive the email? Check your spam folder or click 'Resend Email'", "color: #fbbf24; font-size: 12px;");
    </script>
</body>
</html>