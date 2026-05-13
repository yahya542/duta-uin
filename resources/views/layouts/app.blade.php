<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOTE DUTA KAMPUS — UIN Madura 2026')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #2563eb !important;
            --primary-hover: #1d4ed8 !important;
            --bg-dark: #f1f5f9 !important; /* Slightly darker background for contrast */
            --bg-card: #ffffff !important;
            --border: rgba(0, 0, 0, 0.06) !important;
            --text-main: #0f172a !important;
            --text-muted: #64748b !important;
        }
        body { background-color: var(--bg-dark) !important; color: var(--text-main) !important; }
        .navbar { background: rgba(255, 255, 255, 0.9) !important; border-bottom: 1px solid var(--border) !important; box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important; }
        .nav-brand, .nav-links a { color: var(--text-main) !important; }
        
        /* High Contrast Card System */
        .leaderboard-container { 
            background: #ffffff !important; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.08) !important; 
            border: 1px solid var(--border) !important; 
        }
        .stat-card { 
            background: #ffffff !important; 
            border: 1px solid var(--border) !important; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important; 
        }
        .circular-item h3, .voter-name { color: var(--text-main) !important; }
        .rank-num { color: rgba(0,0,0,0.15) !important; }
        .rank-tag { background: #ffffff !important; border: 1px solid var(--border) !important; color: var(--text-main) !important; box-shadow: 0 4px 10px rgba(0,0,0,0.03) !important; }
        .circular-rank-1 .rank-tag { background: #fbbf24 !important; color: #451a03 !important; border: none !important; }
        
        /* Table rows distinction */
        .lb-table td { background: #ffffff !important; border-bottom: 1px solid rgba(0,0,0,0.02) !important; }
        .lb-table tr:hover td { background: #f8fafc !important; }
    </style>
</head>
<body x-data="{ 
    showToast: {{ session('success') || session('error') ? 'true' : 'false' }}, 
    toastMsg: '{{ session('success') ?? session('error') }}',
    toastType: '{{ session('success') ? 'success' : 'error' }}',
    progress: 100,
    startToast() {
        if(this.showToast) {
            let interval = setInterval(() => {
                this.progress -= 1;
                if(this.progress <= 0) {
                    clearInterval(interval);
                    this.showToast = false;
                }
            }, 50);
        }
    }
}" x-init="startToast()">
    <!-- Toast Notification -->
    <template x-if="showToast">
        <div class="toast-wrap">
            <div class="toast-card" :class="toastType === 'success' ? 'toast-success' : 'toast-error'">
                <div class="toast-content">
                    <div class="toast-icon">
                        <template x-if="toastType === 'success'">
                            <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </template>
                        <template x-if="toastType === 'error'">
                            <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </template>
                    </div>
                    <span class="toast-message" x-text="toastMsg"></span>
                    <button @click="showToast = false" class="toast-close" aria-label="Tutup notifikasi">
                        <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="toast-progress" :style="'width: ' + progress + '%'"></div>
            </div>
        </div>
    </template>

    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-brand">DUTA<span>KAMPUS</span></a>
            
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('home') }}#leaderboard">Leaderboard</a></li>
                <li><a href="{{ route('tutorial') }}" class="{{ request()->routeIs('tutorial') ? 'active' : '' }}">Tutorial</a></li>
                @auth
                    <li><a href="{{ route('topup.index') }}" class="{{ request()->routeIs('topup.index') ? 'active' : '' }}">Top Up</a></li>
                @endauth
            </ul>

            <div style="display: flex; gap: 1rem; align-items: center;">
                @auth
                    <div style="display: flex; flex-direction: column; align-items: flex-end; margin-right: 0.5rem;">
                        <span style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Saldo Poin</span>
                        <span style="font-size: 14px; font-weight: 900; color: var(--primary);">{{ number_format(Auth::user()->points) }} <span style="font-size: 10px; color: var(--text-muted);">PTS</span></span>
                    </div>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 10px;">Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 10px;">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @stack('scripts')

    <style>
    .toast-wrap {
        position: fixed;
        top: 90px;
        right: 2rem;
        z-index: 9999;
        width: min(360px, calc(100vw - 2rem));
        animation: slideIn 0.3s ease-out;
    }

    .toast-card {
        position: relative;
        overflow: hidden;
        width: 100%;
        background: #ffffff;
        border: 1px solid var(--border);
        border-left: 5px solid var(--primary);
        border-radius: 1rem;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14), 0 2px 10px rgba(15, 23, 42, 0.06);
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1rem 1.125rem;
    }

    .toast-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 999px;
    }

    .toast-message {
        flex: 1;
        color: var(--text-main);
        font-size: 0.875rem;
        font-weight: 800;
        line-height: 1.45;
    }

    .toast-close {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--text-muted);
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 0.625rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .toast-close:hover {
        color: var(--primary);
        background: rgba(37, 99, 235, 0.08);
        border-color: rgba(37, 99, 235, 0.18);
    }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        transition: width 0.05s linear;
    }

    .toast-success {
        border-left-color: var(--primary);
    }

    .toast-success .toast-icon {
        color: var(--primary);
        background: rgba(37, 99, 235, 0.1);
    }

    .toast-success .toast-progress {
        background: var(--primary);
    }

    .toast-error {
        border-left-color: #dc2626;
    }

    .toast-error .toast-icon {
        color: #dc2626;
        background: rgba(220, 38, 38, 0.1);
    }

    .toast-error .toast-progress {
        background: #dc2626;
    }

    @media (max-width: 640px) {
        .toast-wrap {
            top: 84px;
            right: 1rem;
            left: 1rem;
            width: auto;
        }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    </style>
</body>
</html>
