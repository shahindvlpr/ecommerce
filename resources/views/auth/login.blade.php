{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EktaMart — Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --purple: #8b5cf6;
            --purple-dark: #7c3aed;
            --purple-light: rgba(139,92,246,.12);
            --surface: rgba(15,12,41,.85);
            --surface-2: rgba(255,255,255,.04);
            --border: rgba(255,255,255,.08);
            --text: #fff;
            --text-muted: rgba(255,255,255,.5);
            --text-dim: rgba(255,255,255,.3);
            --success: #10b981;
            --error: #ef4444;
            --radius: 14px;
            --radius-sm: 10px;
            --transition: all .25s cubic-bezier(.4,0,.2,1);
        }

        html, body { min-height: 100vh; font-family: 'Inter', sans-serif; }

        body {
            background: #0b0919;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* ── Background ── */
        .bg-mesh {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 80% 60% at 70% 10%, rgba(139,92,246,.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 10% 80%, rgba(99,102,241,.14) 0%, transparent 55%),
                radial-gradient(ellipse 40% 40% at 50% 50%, rgba(168,85,247,.06) 0%, transparent 60%);
        }

        /* ── Grid ── */
        .page-grid {
            position: relative; z-index: 1;
            width: 100%; max-width: 900px;
            display: grid;
            grid-template-columns: 1fr 420px;
            min-height: 560px;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid rgba(139,92,246,.2);
            box-shadow: 0 40px 80px -20px rgba(0,0,0,.7), 0 0 0 1px rgba(255,255,255,.04) inset;
        }

        /* ── Left Panel ── */
        .left-panel {
            background: rgba(11,9,25,.6);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255,255,255,.05);
            backdrop-filter: blur(20px);
        }

        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: rgba(139,92,246,.2);
            border: 1px solid rgba(139,92,246,.3);
            display: flex; align-items: center; justify-content: center;
        }
        .brand-icon i { font-size: 1.1rem; color: #c4b5fd; }
        .brand-name { font-size: 1.2rem; font-weight: 700; color: #fff; }
        .brand-name span { color: #a78bfa; }
        .brand-sub { font-size: 0.7rem; color: var(--text-muted); margin-top: 1px; }

        .left-content { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 2rem 0; }
        .left-headline {
            font-size: 1.8rem; font-weight: 700; color: #fff;
            line-height: 1.25; margin-bottom: 0.75rem;
        }
        .left-headline span { color: #a78bfa; }
        .left-desc { font-size: 0.875rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 2rem; }

        .feat-list { display: flex; flex-direction: column; gap: 12px; }
        .feat-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }
        .feat-item:hover { background: rgba(139,92,246,.08); border-color: rgba(139,92,246,.2); }
        .feat-icon {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: .85rem;
        }
        .feat-icon.green { background: rgba(16,185,129,.15); color: #34d399; }
        .feat-icon.purple { background: rgba(139,92,246,.15); color: #a78bfa; }
        .feat-icon.amber { background: rgba(245,158,11,.15); color: #fbbf24; }
        .feat-title { font-size: .8rem; font-weight: 600; color: #e2e8f0; }
        .feat-desc { font-size: .7rem; color: var(--text-muted); }

        .left-footer { font-size: .7rem; color: var(--text-dim); display: flex; align-items: center; gap: 6px; }
        .left-footer i { color: var(--purple); }

        /* ── Right Panel ── */
        .right-panel {
            background: rgba(15,12,35,.9);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            backdrop-filter: blur(24px);
        }

        .form-header { margin-bottom: 1.75rem; }
        .form-title { font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .form-sub { font-size: .8rem; color: var(--text-muted); }

        /* ── Alerts ── */
        .alert {
            border-radius: var(--radius-sm); padding: .7rem 1rem;
            font-size: .8rem; display: flex; align-items: flex-start;
            gap: 8px; margin-bottom: 1.25rem;
            border-left: 3px solid transparent;
            animation: slideIn .3s ease;
        }
        @keyframes slideIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
        .alert-success { background: rgba(16,185,129,.12); border-left-color: #10b981; color: #a7f3d0; }
        .alert-error   { background: rgba(239,68,68,.1);  border-left-color: #ef4444; color: #fca5a5; }

        /* ── Inputs ── */
        .field { margin-bottom: 1rem; }
        .field-label {
            display: flex; align-items: center; gap: 6px;
            font-size: .72rem; font-weight: 500;
            color: var(--text-muted); margin-bottom: 6px;
        }
        .field-label i { font-size: .7rem; }

        .field-wrap { position: relative; }
        .field-input {
            width: 100%; padding: .7rem .9rem;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--radius-sm);
            color: #fff; font-size: .875rem; font-family: 'Inter', sans-serif;
            outline: none; transition: var(--transition);
        }
        .field-input::placeholder { color: rgba(255,255,255,.2); }
        .field-input:focus {
            border-color: rgba(139,92,246,.6);
            background: rgba(139,92,246,.06);
            box-shadow: 0 0 0 3px rgba(139,92,246,.12);
        }
        .field-input.valid   { border-color: rgba(16,185,129,.5); }
        .field-input.invalid { border-color: rgba(239,68,68,.5); }
        .field-input:disabled { opacity: .5; cursor: not-allowed; }

        .field-eye {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--text-dim);
            cursor: pointer; padding: 4px; font-size: .85rem;
            transition: var(--transition);
        }
        .field-eye:hover { color: var(--text-muted); }

        .field-msg { font-size: .68rem; margin-top: 4px; min-height: 14px; transition: var(--transition); }
        .field-msg.error { color: #fca5a5; }
        .field-msg.success { color: #6ee7b7; }

        /* ── Strength bar ── */
        .strength-wrap { margin-top: 6px; }
        .strength-bars { display: flex; gap: 4px; margin-bottom: 3px; }
        .strength-bar { flex: 1; height: 3px; border-radius: 3px; background: rgba(255,255,255,.08); transition: background .3s; }
        .strength-bar.active-1 { background: #ef4444; }
        .strength-bar.active-2 { background: #f97316; }
        .strength-bar.active-3 { background: #eab308; }
        .strength-bar.active-4 { background: #10b981; }
        .strength-label { font-size: .65rem; color: var(--text-dim); }

        /* ── Options row ── */
        .options-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .remember-label {
            display: flex; align-items: center; gap: 7px;
            font-size: .78rem; color: var(--text-muted); cursor: pointer;
        }
        .remember-label input { accent-color: var(--purple); cursor: pointer; }
        .forgot-link {
            font-size: .78rem; color: #a78bfa; text-decoration: none;
            transition: var(--transition);
        }
        .forgot-link:hover { color: #c4b5fd; }

        /* ── Submit ── */
        .btn-submit {
            width: 100%; padding: .8rem;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border: none; border-radius: var(--radius-sm);
            color: #fff; font-size: .9rem; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: var(--transition); position: relative; overflow: hidden;
            margin-bottom: 1.25rem;
        }
        .btn-submit::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.1), transparent);
            opacity: 0; transition: opacity .25s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 30px -8px rgba(139,92,246,.55); }
        .btn-submit:hover::before { opacity: 1; }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

        /* ── Divider ── */
        .divider {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 1.25rem;
        }
        .divider-line { flex: 1; height: 1px; background: rgba(255,255,255,.07); }
        .divider-text { font-size: .7rem; color: var(--text-dim); white-space: nowrap; }

        /* ── Social ── */
        .social-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-bottom: 1.5rem; }
        .social-btn {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: .65rem;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-muted); font-size: .78rem; font-weight: 500;
            text-decoration: none; cursor: pointer;
            transition: var(--transition);
        }
        .social-btn:hover {
            background: rgba(255,255,255,.07);
            border-color: rgba(255,255,255,.15);
            color: #fff; transform: translateY(-2px);
        }
        .social-btn i { font-size: .9rem; }
        .social-btn .g-icon { color: #ea4335; }
        .social-btn .fb-icon { color: #1877f2; }
        .social-btn .gh-icon { color: #e2e8f0; }

        /* ── Register link ── */
        .register-row { text-align: center; font-size: .78rem; color: var(--text-muted); }
        .register-row a { color: #a78bfa; text-decoration: none; font-weight: 500; }
        .register-row a:hover { color: #c4b5fd; }

        /* ── Spinner ── */
        .spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,.25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .page-grid { grid-template-columns: 1fr; max-width: 420px; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.75rem; }
        }
    </style>
</head>
<body>

<div class="bg-mesh"></div>

<div class="page-grid">

    {{-- ── LEFT PANEL ── --}}
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-crown"></i></div>
            <div>
                <div class="brand-name">Ekta<span>Mart</span></div>
                <div class="brand-sub">Bangladesh's trusted marketplace</div>
            </div>
        </div>

        <div class="left-content">
            <div class="left-headline">
                Shop smarter,<br>live <span>better</span>
            </div>
            <div class="left-desc">
                Join 50,000+ customers who trust EktaMart for quality products, fast delivery, and unbeatable prices.
            </div>

            <div class="feat-list">
                <div class="feat-item">
                    <div class="feat-icon green"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <div class="feat-title">Secure payments</div>
                        <div class="feat-desc">SSL encrypted · bKash · SSLCommerz</div>
                    </div>
                </div>
                <div class="feat-item">
                    <div class="feat-icon purple"><i class="fas fa-truck"></i></div>
                    <div>
                        <div class="feat-title">Fast delivery</div>
                        <div class="feat-desc">Across all 64 districts of Bangladesh</div>
                    </div>
                </div>
                <div class="feat-item">
                    <div class="feat-icon amber"><i class="fas fa-gift"></i></div>
                    <div>
                        <div class="feat-title">Loyalty rewards</div>
                        <div class="feat-desc">Earn points on every purchase</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="left-footer">
            <i class="fas fa-lock"></i>
            256-bit SSL encryption · Privacy protected
        </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="right-panel">
        <div class="form-header">
            <div class="form-title">Welcome back</div>
            <div class="form-sub">Sign in to your EktaMart account</div>
        </div>

        {{-- Alerts --}}
        @if(session('status'))
        <div class="alert alert-success" id="statusAlert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error" id="errorAlert">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
            @csrf

            {{-- Email --}}
            <div class="field">
                <div class="field-label">
                    <i class="fas fa-envelope"></i> Email address
                </div>
                <div class="field-wrap">
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           autocomplete="username"
                           autofocus required
                           class="field-input">
                </div>
                <div class="field-msg" id="emailMsg"></div>
            </div>

            {{-- Password --}}
            <div class="field">
                <div class="field-label">
                    <i class="fas fa-lock"></i> Password
                </div>
                <div class="field-wrap">
                    <input type="password" name="password" id="password"
                           placeholder="••••••••"
                           autocomplete="current-password"
                           required
                           class="field-input" style="padding-right: 2.5rem;">
                    <button type="button" class="field-eye" id="eyeBtn">
                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="strength-wrap" id="strengthWrap" style="display:none">
                    <div class="strength-bars">
                        <div class="strength-bar" id="sb1"></div>
                        <div class="strength-bar" id="sb2"></div>
                        <div class="strength-bar" id="sb3"></div>
                        <div class="strength-bar" id="sb4"></div>
                    </div>
                    <div class="strength-label" id="strengthLabel"></div>
                </div>
                <div class="field-msg" id="passMsg"></div>
            </div>

            {{-- Options --}}
            <div class="options-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Forgot password?
                </a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-sign-in-alt" id="btnIcon"></i>
                <span id="btnText">Sign in</span>
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">or continue with</span>
            <div class="divider-line"></div>
        </div>

        {{-- Social --}}
        <div class="social-grid">
            <a href="{{ route('auth.google') }}" class="social-btn">
                <i class="fab fa-google g-icon"></i> Google
            </a>
            <a href="{{ route('auth.facebook') }}" class="social-btn">
                <i class="fab fa-facebook fb-icon"></i> Facebook
            </a>
            <a href="{{ route('auth.github') }}" class="social-btn">
                <i class="fab fa-github gh-icon"></i> GitHub
            </a>
        </div>

        {{-- Register --}}
        <div class="register-row">
            New to EktaMart?
            <a href="{{ route('register') }}">Create free account</a>
        </div>
    </div>

</div>

<script>
const emailInput  = document.getElementById('email');
const passInput   = document.getElementById('password');
const emailMsg    = document.getElementById('emailMsg');
const passMsg     = document.getElementById('passMsg');
const submitBtn   = document.getElementById('submitBtn');
const eyeBtn      = document.getElementById('eyeBtn');
const eyeIcon     = document.getElementById('eyeIcon');
const strengthWrap = document.getElementById('strengthWrap');
const strengthLabel = document.getElementById('strengthLabel');
const bars = ['sb1','sb2','sb3','sb4'].map(id => document.getElementById(id));

// ── Validation ──
function validateEmail() {
    const v = emailInput.value.trim();
    if (!v) { setMsg(emailMsg,'',''); setClass(emailInput,''); return null; }
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    setClass(emailInput, ok ? 'valid' : 'invalid');
    setMsg(emailMsg, ok ? '✓ Looks good' : 'Enter a valid email address', ok ? 'success' : 'error');
    return ok;
}

function strength(pw) {
    let s = 0;
    if (pw.length >= 6)  s++;
    if (pw.length >= 10) s++;
    if (/[A-Z]/.test(pw)) s++;
    if (/[0-9\W]/.test(pw)) s++;
    return Math.min(s, 4);
}

function validatePass() {
    const v = passInput.value;
    if (!v) {
        setMsg(passMsg,'','');
        setClass(passInput,'');
        strengthWrap.style.display = 'none';
        return null;
    }
    const ok = v.length >= 8;
    const s  = strength(v);
    setClass(passInput, ok ? 'valid' : 'invalid');
    setMsg(passMsg, ok ? '' : 'Minimum 8 characters', ok ? '' : 'error');

    strengthWrap.style.display = 'block';
    const cls = ['active-1','active-2','active-3','active-4'];
    const labels = ['Weak','Fair','Good','Strong'];
    bars.forEach((b, i) => {
        b.className = 'strength-bar' + (i < s ? ' ' + cls[s-1] : '');
    });
    strengthLabel.textContent = s > 0 ? labels[s-1] : '';
    return ok;
}

function setClass(el, cls) {
    el.classList.remove('valid','invalid');
    if (cls) el.classList.add(cls);
}
function setMsg(el, text, type) {
    el.textContent = text;
    el.className = 'field-msg' + (type ? ' ' + type : '');
}

emailInput.addEventListener('blur',  validateEmail);
emailInput.addEventListener('input', validateEmail);
passInput.addEventListener('input',  validatePass);

// ── Password toggle ──
eyeBtn.addEventListener('click', () => {
    const isPw = passInput.type === 'password';
    passInput.type = isPw ? 'text' : 'password';
    eyeIcon.className = isPw ? 'fas fa-eye' : 'fas fa-eye-slash';
});

// ── Form submit ──
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const eOk = validateEmail();
    const pOk = validatePass();
    if (eOk === false || pOk === false) {
        e.preventDefault();
        const panel = document.querySelector('.right-panel');
        panel.style.animation = 'shake .35s ease';
        setTimeout(() => panel.style.animation = '', 350);
        return;
    }
    submitBtn.disabled = true;
    document.getElementById('btnIcon').outerHTML = '<div class="spinner"></div>';
    document.getElementById('btnText').textContent = 'Signing in…';
});

// ── Shake keyframe ──
document.head.insertAdjacentHTML('beforeend',`
<style>
@keyframes shake {
    0%,100%{transform:translateX(0)}
    20%{transform:translateX(-6px)}
    40%{transform:translateX(6px)}
    60%{transform:translateX(-4px)}
    80%{transform:translateX(4px)}
}
</style>`);

// ── Auto-hide alerts ──
['statusAlert','errorAlert'].forEach(id => {
    const el = document.getElementById(id);
    if (el) setTimeout(() => {
        el.style.transition = 'opacity .5s, transform .5s';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        setTimeout(() => el.remove(), 500);
    }, 5000);
});

// ── Trigger if has old value ──
if (emailInput.value) validateEmail();
</script>
</body>
</html>