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
            --bg-dark: #f8fafc !important;
            --bg-card: #ffffff !important;
            --border: rgba(0, 0, 0, 0.1) !important;
            --text-main: #0f172a !important;
            --text-muted: #64748b !important;
        }
        body { background-color: var(--bg-dark) !important; color: var(--text-main) !important; font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* App Layout */
        .app-layout { display: flex; min-height: 100vh; }
        
        /* SIDEBAR */
        .sidebar { 
            width: 280px; 
            background: #ffffff !important; 
            border-right: 1px solid var(--border); 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            left: 0;
            top: 0;
            bottom: 0;
            height: 100vh; 
            z-index: 2000 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-100%);
            /* Flat design, no shadow for seamless integration with header */
        }
        .sidebar.open { transform: translateX(0); }
        .main-content { flex: 1; margin-left: 0; min-width: 0; display: flex; flex-direction: column; min-height: 100vh; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .main-content.with-sidebar { margin-left: 280px; }
        
        .sidebar-header { padding: 1.5rem 2rem; height: 72px; display: flex; align-items: center; border-bottom: 1px solid var(--border); }
        .sidebar-nav { padding: 2rem 1.25rem; flex: 1; }
        .sidebar-link { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
            padding: 0.875rem 1.25rem; 
            color: var(--text-muted); 
            text-decoration: none; 
            font-weight: 700; 
            font-size: 0.875rem; 
            border-radius: 1rem; 
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }
        .sidebar-link:hover { background: #f8fafc; color: var(--primary); }
        .sidebar-link.active { background: var(--primary); color: white; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15); }
        .sidebar-link svg { width: 20px; height: 20px; flex-shrink: 0; }

        /* NAVBAR */
        .navbar { 
            height: 72px; 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid var(--border); 
            position: sticky; 
            top: 0; 
            z-index: 900;
            padding: 0 2rem;
            display: flex;
            align-items: center;
        }
        .nav-container { width: 100%; display: flex; justify-content: space-between; align-items: center; }

        /* Profile Dropdown */
        .profile-dropdown { position: relative; }
        .dropdown-menu { 
            position: absolute; 
            top: calc(100% + 12px); 
            right: 0; 
            width: 240px; 
            background: white; 
            border: 1px solid var(--border); 
            border-radius: 1.25rem; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.1); 
            padding: 0.75rem; 
            z-index: 1100;
            transform-origin: top right;
        }
        .dropdown-item { 
            display: flex; 
            align-items: center; 
            gap: 0.85rem; 
            padding: 0.85rem 1rem; 
            color: var(--text-main); 
            text-decoration: none; 
            font-size: 0.875rem; 
            font-weight: 700; 
            border-radius: 0.85rem; 
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            width: 100%;
            background: transparent;
            text-align: left;
        }
        .dropdown-item:hover { background: #f8fafc; color: var(--primary); }
        .dropdown-item.logout { color: #dc2626; margin-top: 0.5rem; border-top: 1px solid var(--border); border-radius: 0; padding-top: 0.75rem; }

        /* Mobile specific */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content.with-sidebar { margin-left: 0; }
            .navbar { padding: 0 1.25rem; }
            .sidebar-overlay { display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 999; backdrop-filter: blur(4px); }
        }

        .nav-brand { font-size: 1.25rem; font-weight: 900; text-decoration: none; color: var(--text-main); }
        .nav-brand span { color: var(--primary); }

        /* Abstract Decorations */
        .decoration-blob {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.05) 0%, rgba(37, 99, 235, 0) 70%);
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
            filter: blur(60px);
        }
        .blob-1 { top: -100px; right: -100px; }
        .blob-2 { bottom: -100px; left: 180px; background: radial-gradient(circle, rgba(251, 191, 36, 0.03) 0%, rgba(251, 191, 36, 0) 70%); }
        
        .decoration-dots {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(15, 23, 42, 0.02) 1.5px, transparent 1.5px);
            background-size: 32px 32px;
            z-index: -1;
            pointer-events: none;
        }

        /* Modal Styles */
        .modal-overlay { 
            position: fixed; 
            inset: 0; 
            background: rgba(15, 23, 42, 0.4); 
            backdrop-filter: blur(8px); 
            z-index: 10000; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 2rem;
        }
        .modal-card { 
            background: white; 
            width: 100%; 
            max-width: 500px; 
            border-radius: 2rem; 
            border: 1px solid var(--border); 
            box-shadow: 0 30px 60px rgba(0,0,0,0.15); 
            overflow: hidden;
            position: relative;
        }
        .modal-header { padding: 2.5rem 2.5rem 1rem; text-align: center; }
        .modal-body { padding: 1rem 2.5rem 2.5rem; text-align: center; }
        .modal-icon { 
            width: 80px; 
            height: 80px; 
            background: rgba(37, 99, 235, 0.1); 
            color: var(--primary); 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 1.5rem; 
        }

        /* Toast Styles */
        .toast-wrap { position: fixed; top: 90px; right: 2rem; z-index: 9999; width: min(360px, calc(100vw - 2rem)); }
        .toast-card { background: white; border-radius: 1rem; border: 1px solid var(--border); box-shadow: 0 15px 40px rgba(0,0,0,0.1); overflow: hidden; }
        .toast-content { display: flex; align-items: center; gap: 1rem; padding: 1rem; }
        .toast-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .toast-success .toast-icon { background: rgba(37, 99, 235, 0.1); color: var(--primary); }
        .toast-error .toast-icon { background: rgba(220, 38, 38, 0.1); color: #dc2626; }
        .toast-message { font-size: 0.875rem; font-weight: 800; flex: 1; }
        .toast-progress { height: 3px; transition: width 0.05s linear; }
        .toast-success .toast-progress { background: var(--primary); }
        .toast-error .toast-progress { background: #dc2626; }
    </style>
</head>
<body x-data="{ 
    sidebarOpen: false,
    profileOpen: false,
    showWelcomeModal: false,
    dontShowAgain: false,
    showToast: {{ session('success') || session('error') ? 'true' : 'false' }}, 
    toastMsg: '{{ session('success') ?? session('error') }}',
    toastType: '{{ session('success') ? 'success' : 'error' }}',
    progress: 100,
    init() {
        @guest
            sessionStorage.removeItem('welcomeModalShown');
        @endguest

        @auth
            const hidePermanent = localStorage.getItem('hideWelcomeModal');
            const shownThisSession = sessionStorage.getItem('welcomeModalShown');

            if (!hidePermanent && !shownThisSession) {
                setTimeout(() => { this.showWelcomeModal = true; }, 500);
                sessionStorage.setItem('welcomeModalShown', 'true');
            }
        @endauth

        if(this.showToast) {
            let interval = setInterval(() => {
                this.progress -= 1;
                if(this.progress <= 0) {
                    clearInterval(interval);
                    this.showToast = false;
                }
            }, 50);
        }
    },
    closeModal() {
        if (this.dontShowAgain) {
            localStorage.setItem('hideWelcomeModal', 'true');
        }
        this.showWelcomeModal = false;
    }
}">
    <!-- SIDEBAR OVERLAY -->
    <div x-show="sidebarOpen && window.innerWidth <= 1024" @click="sidebarOpen = false" class="sidebar-overlay" style="display: none;"></div>

    <div class="app-layout">
        <!-- BACKGROUND DECORATIONS -->
        <div class="decoration-blob blob-1"></div>
        <div class="decoration-blob blob-2"></div>
        <div class="decoration-dots"></div>

    @if(!request()->is('admin*'))
        <!-- SIDEBAR -->
        <aside class="sidebar" :class="sidebarOpen ? 'open' : ''">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="nav-brand">DUTA<span>KAMPUS</span></a>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') && !str_contains(request()->fullUrl(), '#leaderboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Beranda
                </a>
                <a href="{{ route('home') }}#leaderboard" class="sidebar-link {{ str_contains(request()->fullUrl(), '#leaderboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Leaderboard
                </a>
                <a href="{{ route('tutorial') }}" class="sidebar-link {{ request()->routeIs('tutorial') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    Tutorial
                </a>
                @auth
                <a href="{{ route('topup.index') }}" class="sidebar-link {{ request()->routeIs('topup.index') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 16v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2m5-13V3m0 0L9 5m3-2l3 2" /></svg>
                    Top Up Poin
                </a>
                @endauth
            </nav>
        </aside>
    @endif

        <!-- MAIN CONTENT AREA -->
        <div class="main-content" :class="sidebarOpen && window.innerWidth > 1024 && !{{ request()->is('admin*') ? 'true' : 'false' }} ? 'with-sidebar' : ''">
            @if(!request()->is('admin*'))
                <!-- NAVBAR -->
                <nav class="navbar">
                <div class="nav-container">
                    <div style="display: flex; align-items: center;">
                        <button @click="sidebarOpen = !sidebarOpen" style="background: none; border: none; padding: 0.5rem; cursor: pointer; color: var(--text-main); display: flex; align-items: center; justify-content: center; margin-right: 1rem; border-radius: 0.5rem; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
                            <svg style="width: 24px; height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                    </div>

                    <div style="display: flex; align-items: center; gap: 1.25rem;">
                        @auth
                        <!-- Points Display -->
                        <div style="background: #f8fafc; border: 1px solid var(--border); padding: 0.5rem 1rem; border-radius: 999px; display: flex; align-items: center; gap: 0.65rem;">
                            <div style="width: 22px; height: 22px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <span style="font-size: 13px; font-weight: 900; color: var(--text-main);">{{ number_format(Auth::user()->points) }} <span style="font-size: 9px; color: var(--text-muted);">PTS</span></span>
                        </div>

                        <!-- Profile Dropdown -->
                        <div class="profile-dropdown" @click.away="profileOpen = false">
                            <button @click="profileOpen = !profileOpen" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem;">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=100&background=2563eb&color=ffffff' }}" 
                                     style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                <svg style="width: 14px; height: 14px; color: var(--text-muted); transition: transform 0.2s;" :style="profileOpen ? 'transform: rotate(180deg)' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div class="dropdown-menu" x-show="profileOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                                <div style="padding: 0.5rem 1rem; border-bottom: 1px solid var(--border); margin-bottom: 0.5rem;">
                                    <div style="font-size: 0.8125rem; font-weight: 900; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</div>
                                    <div style="font-size: 10px; color: var(--text-muted);">Akun Supporter</div>
                                </div>
                                <a href="{{ route('profile.index') }}" class="dropdown-item">
                                    <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Edit Profil Saya
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout">
                                        <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 0.65rem 1.5rem; border-radius: 999px; font-size: 0.875rem; font-weight: 800; text-decoration: none;">Masuk</a>
                        @endauth
                    </div>
                </div>
            </nav>
        @endif

            <!-- MAIN CONTENT -->
            <div style="flex: 1; padding: {{ request()->is('admin*') ? '0' : '0 2rem' }};">
                @yield('content')
            </div>

            <!-- FOOTER -->
            <footer style="background: #ffffff; border-top: 1px solid var(--border); padding: 2.5rem 2rem; margin-top: auto;">
                <div style="max-width: 1200px; margin: 0 auto; text-align: center; color: var(--text-muted); font-size: 0.8125rem; font-weight: 700;">
                    &copy; 2026 Duta Kampus UIN Madura. All Rights Reserved.
                </div>
            </footer>
        </div>
    </div>

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
                </div>
                <div class="toast-progress" :style="'width: ' + progress + '%'"></div>
            </div>
        </div>
    </template>

    <!-- Welcome Modal -->
    <template x-if="showWelcomeModal">
        <div class="modal-overlay" @click.self="closeModal">
            <div class="modal-card" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                <div class="modal-header">
                    <div class="modal-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7V17L12 22L21 17V7L12 2Z"/><path d="M12 22V12"/><path d="M21 7L12 12L3 7"/></svg>
                    </div>
                    <h2 style="font-size: 1.75rem; font-weight: 900; color: var(--text-main); margin-bottom: 0.5rem;">Siap Memberi Dukungan?</h2>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">Halo! Untuk mulai memberikan suara (vote) kepada kandidat favorit Anda, pastikan Anda memiliki poin yang cukup.</p>
                </div>
                <div class="modal-body">
                    <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: 1.25rem; padding: 1.5rem; margin-bottom: 2rem;">
                        <p style="font-weight: 700; color: var(--text-main); margin-bottom: 0.25rem;">Langkah Cepat:</p>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Silakan lakukan <strong>Top Up Poin</strong> terlebih dahulu untuk mendukung calon Duta pilihan Anda.</p>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <a href="{{ route('topup.index') }}" class="btn btn-primary" style="padding: 1rem; font-size: 1rem; font-weight: 800; border-radius: 1rem; text-decoration: none;">Top Up Sekarang</a>
                        <button @click="closeModal" style="background: transparent; border: none; font-weight: 700; color: var(--text-muted); cursor: pointer; padding: 0.5rem;">Nanti Saja</button>
                    </div>

                    <div style="margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.8125rem; font-weight: 600; color: var(--text-muted);">
                            <input type="checkbox" x-model="dontShowAgain" style="width: 16px; height: 16px; border-radius: 4px; border: 1px solid var(--border);">
                            Jangan tampilkan pesan ini lagi
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </template>

    @stack('scripts')
</body>
</html>
