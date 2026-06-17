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
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f8fafc; min-height: 100vh; display: flex; flex-direction: column; }
        main { flex: 1; }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100px) scale(0.9); }
            to   { opacity: 1; transform: translateX(0)    scale(1);   }
        }
        @keyframes slideOutRight {
            from { opacity: 1; transform: translateX(0)    scale(1);   }
            to   { opacity: 0; transform: translateX(100px) scale(0.9); }
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .fa-spinner { animation: spin 1s linear infinite; }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ═══════════════════════════════════════════
         PREMIUM NAVBAR  (single source of truth)
    ═══════════════════════════════════════════ --}}
    @include('layouts.partials.navbar')

    {{-- ═══════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════ --}}
    <main>
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════ --}}
    @include('layouts.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Toast Notification (global helper) ──────────────────────
        function showNotification(message, type = 'success') {
            const existing = document.querySelector('.custom-notification');
            if (existing) existing.remove();

            const map = {
                success: { color: '#10b981', icon: 'check-circle' },
                error:   { color: '#ef4444', icon: 'exclamation-circle' },
                warning: { color: '#f59e0b', icon: 'exclamation-triangle' },
                info:    { color: '#3b82f6', icon: 'info-circle' },
            };
            const { color, icon } = map[type] ?? map.success;

            const el = document.createElement('div');
            el.className = 'custom-notification';
            el.style.cssText = `
                position:fixed; bottom:30px; right:30px; z-index:99999;
                background:${color}; color:#fff;
                padding:14px 20px; border-radius:14px;
                box-shadow:0 8px 32px rgba(0,0,0,.22);
                font-weight:500; font-size:.92rem;
                display:flex; align-items:center; gap:12px;
                max-width:380px; border:1px solid rgba(255,255,255,.15);
                backdrop-filter:blur(12px);
                animation:slideInRight .35s ease;
            `;
            el.innerHTML = `
                <i class="fas fa-${icon}" style="font-size:1.15rem;flex-shrink:0"></i>
                <span style="flex:1">${message}</span>
                <button onclick="this.closest('.custom-notification').remove()"
                    style="background:none;border:none;color:#fff;opacity:.7;cursor:pointer;padding:2px 4px;font-size:.9rem;">
                    <i class="fas fa-times"></i>
                </button>`;
            document.body.appendChild(el);
            setTimeout(() => {
                el.style.animation = 'slideOutRight .3s ease forwards';
                setTimeout(() => el.remove(), 300);
            }, 4000);
        }

        console.log('%c✨ EktaMart Premium Loaded', 'color:#8b5cf6;font-size:14px;font-weight:bold');
    </script>

    @stack('scripts')
</body>
</html>