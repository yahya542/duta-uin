<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOTE DUTA KAMPUS — UIN Madura 2026')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="{ showToast: {{ session('success') ? 'true' : 'false' }}, toastMsg: '{{ session('success') }}' }" x-init="if(showToast) setTimeout(() => showToast = false, 5000)">
    <!-- Toast Notification -->
    <template x-if="showToast">
        <div style="position: fixed; top: 90px; right: 2rem; z-index: 9999; animation: slideIn 0.3s ease-out;">
            <div style="background: var(--bg-card); border: 1px solid var(--primary); border-radius: 1rem; padding: 1rem 1.5rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4); backdrop-filter: blur(10px);">
                <div style="width: 32px; height: 32px; background: rgba(59, 130, 246, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 18px; height: 18px; color: var(--primary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span style="font-weight: 700; font-size: 0.875rem; color: white;" x-text="toastMsg"></span>
                <button @click="showToast = false" style="background: none; border: none; color: var(--text-muted); cursor: pointer; margin-left: 0.5rem;">
                    <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
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
            </ul>

            <div style="display: flex; gap: 1rem; align-items: center;">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Keluar</button>
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
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    </style>
</body>
</html>
