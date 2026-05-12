<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOTE DUTA KAMPUS — UIN Madura 2026')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-brand">
            <img src="https://ui-avatars.com/api/?name=UIN&background=0D1B2A&color=C9A84C" alt="Logo UIN">
            <div class="nav-divider"></div>
            <div class="nav-brand-text">
                DUTA KAMPUS
                <small>UIN MADURA 2026</small>
            </div>
        </div>
        
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">BERANDA</a></li>
            <li><a href="#leaderboard">LEADERBOARD</a></li>
            <li><a href="#tutorial">TUTORIAL</a></li>
        </ul>

        @auth
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="nav-links a">DASHBOARD</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-secondary">LOGOUT</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-secondary">ADMIN LOGIN</a>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
