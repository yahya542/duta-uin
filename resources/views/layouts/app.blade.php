<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOTE DUTA KAMPUS — UIN Madura 2026')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        <div style="position: fixed; top: 90px; right: 2rem; z-index: 9999; animation: slideIn 0.3s ease-out;">
            <div style="background: var(--bg-card); border: 1px solid; border-radius: 1rem; padding: 1rem 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4); backdrop-filter: blur(10px); min-width: 300px; overflow: hidden; position: relative;"
                 :style="toastType === 'success' ? 'border-color: var(--primary)' : 'border-color: #ef4444'">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
                         :style="toastType === 'success' ? 'background: rgba(59, 130, 246, 0.1); color: var(--primary)' : 'background: rgba(239, 68, 68, 0.1); color: #ef4444'">
                        <template x-if="toastType === 'success'">
                            <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </template>
                        <template x-if="toastType === 'error'">
                            <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </template>
                    </div>
                    <span style="font-weight: 700; font-size: 0.875rem; color: white; flex-grow: 1;" x-text="toastMsg"></span>
                    <button @click="showToast = false" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px;">
                        <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div style="position: absolute; bottom: 0; left: 0; height: 3px; transition: width 0.05s linear;" 
                     :style=" (toastType === 'success' ? 'background: var(--primary);' : 'background: #ef4444;') + ' width: ' + progress + '%'"></div>
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
                        <span style="font-size: 14px; font-weight: 900; color: var(--primary);">{{ number_format(Auth::user()->points) }} <span style="font-size: 10px; color: white;">PTS</span></span>
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
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    </style>
</body>
</html>
