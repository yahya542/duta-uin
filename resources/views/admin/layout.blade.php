@extends('layouts.app')

@section('content')
<section class="admin-shell" x-data="{ sidebarOpen: false }">
    <aside class="admin-sidebar" :class="sidebarOpen ? 'is-open' : ''">
        <div class="admin-sidebar-head">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">Admin<span>Panel</span></a>
            <button type="button" class="admin-sidebar-close" @click="sidebarOpen = false" aria-label="Tutup sidebar">x</button>
        </div>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></span> 
                Ringkasan
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                <span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span> 
                Verifikasi Pembayaran
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span> 
                Manajemen User
            </a>
            <a href="{{ route('admin.leaderboard') }}" class="{{ request()->routeIs('admin.leaderboard') ? 'active' : '' }}">
                <span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></span> 
                Leaderboard
            </a>
            <a href="{{ route('admin.activity') }}" class="{{ request()->routeIs('admin.activity') ? 'active' : '' }}">
                <span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></span> 
                Laporan Aktivitas
            </a>
            <a href="{{ route('admin.candidates.index') }}" class="{{ request()->routeIs('admin.candidates.*') ? 'active' : '' }}">
                <span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></span> 
                Kelola Kandidat
            </a>
        </nav>

        <div class="admin-sidebar-foot">
            <span>Login sebagai</span>
            <strong>{{ Auth::user()->name ?? Auth::user()->username }}</strong>
        </div>
    </aside>

    <div class="admin-overlay" :class="sidebarOpen ? 'is-open' : ''" @click="sidebarOpen = false"></div>

    <div class="admin-main">
        <header class="admin-topbar">
            <button type="button" class="admin-menu-btn" @click="sidebarOpen = true" aria-label="Buka sidebar">Nav</button>
            <div>
                <p class="admin-kicker">@yield('admin-kicker', 'Admin Dashboard')</p>
                <h1>@yield('admin-title')</h1>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline admin-home-link">Lihat Situs</a>
        </header>

        @yield('admin-content')
    </div>
</section>

<style>
.admin-shell {
    display: grid;
    grid-template-columns: 280px minmax(0, 1fr);
    gap: 0;
    min-height: calc(100vh - 72px);
    padding-top: 72px;
    background: var(--bg-dark);
}

.admin-sidebar {
    position: sticky;
    top: 72px;
    height: calc(100vh - 72px);
    padding: 1.25rem;
    background: #ffffff;
    border-right: 1px solid var(--border);
    box-shadow: 8px 0 30px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
    z-index: 1100;
}

.admin-sidebar-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.admin-brand {
    color: var(--text-main);
    font-size: 1.05rem;
    font-weight: 900;
    text-decoration: none;
}

.admin-brand span { color: var(--primary); }
.admin-sidebar-close { display: none; }

.admin-nav {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}

.admin-nav a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 0.95rem;
    color: var(--text-muted);
    border: 1px solid transparent;
    border-radius: 0.875rem;
    font-size: 0.875rem;
    font-weight: 800;
    text-decoration: none;
    transition: all 0.2s;
}

.admin-nav a span {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.85rem;
    background: #f8fafc;
    color: var(--primary);
    flex-shrink: 0;
}

.admin-nav a span svg {
    width: 20px;
    height: 20px;
}

.admin-nav a:hover,
.admin-nav a.active {
    color: var(--primary);
    background: rgba(37, 99, 235, 0.07);
    border-color: rgba(37, 99, 235, 0.16);
}

.admin-nav a.active span {
    color: #ffffff;
    background: var(--primary);
}

.admin-sidebar-foot {
    margin-top: auto;
    padding: 1rem;
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 1rem;
}

.admin-sidebar-foot span {
    display: block;
    color: var(--text-muted);
    font-size: 0.6875rem;
    font-weight: 800;
    text-transform: uppercase;
}

.admin-sidebar-foot strong {
    display: block;
    margin-top: 0.25rem;
    color: var(--text-main);
    font-size: 0.9rem;
}

.admin-main {
    min-width: 0;
    padding: 2rem;
}

.admin-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.admin-kicker {
    margin-bottom: 0.25rem;
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 900;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.admin-topbar h1 {
    color: var(--text-main);
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 900;
    line-height: 1.1;
}

.admin-menu-btn,
.admin-sidebar-close {
    width: 40px;
    height: 40px;
    color: var(--text-main);
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 0.75rem;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
}

.admin-menu-btn { display: none; }

.admin-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    box-shadow: 0 16px 45px rgba(15, 23, 42, 0.06);
}

.admin-card-pad { padding: 1.25rem; }

.admin-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.admin-stat {
    padding: 1.25rem;
}

.admin-stat span {
    display: block;
    color: var(--text-muted);
    font-size: 0.7rem;
    font-weight: 900;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.admin-stat strong {
    display: block;
    margin-top: 0.45rem;
    color: var(--text-main);
    font-size: 1.65rem;
    font-weight: 900;
}

.admin-grid-2 {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.5fr);
    gap: 1rem;
}

.admin-section-title {
    margin-bottom: 1rem;
    color: var(--text-main);
    font-size: 1rem;
    font-weight: 900;
}

.admin-table-wrap {
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    min-width: 720px;
    border-collapse: separate;
    border-spacing: 0 0.55rem;
}

.admin-table th {
    padding: 0 0.9rem 0.35rem;
    color: var(--text-muted);
    font-size: 0.68rem;
    font-weight: 900;
    letter-spacing: 1px;
    text-align: left;
    text-transform: uppercase;
}

.admin-table td {
    padding: 0.9rem;
    background: #f8fafc;
    color: var(--text-main);
    font-size: 0.875rem;
    vertical-align: middle;
}

.admin-table td:first-child { border-radius: 0.85rem 0 0 0.85rem; }
.admin-table td:last-child { border-radius: 0 0.85rem 0.85rem 0; }

.admin-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.65rem;
    border-radius: 999px;
    font-size: 0.68rem;
    font-weight: 900;
    text-transform: uppercase;
}

.admin-badge.success { color: #15803d; background: rgba(34, 197, 94, 0.12); }
.admin-badge.warning { color: #a16207; background: rgba(234, 179, 8, 0.14); }
.admin-badge.danger { color: #b91c1c; background: rgba(239, 68, 68, 0.12); }
.admin-badge.info { color: var(--primary); background: rgba(37, 99, 235, 0.1); }

.admin-empty {
    padding: 3rem 1rem;
    color: var(--text-muted);
    text-align: center;
}

.admin-overlay { display: none; }

@media (max-width: 1100px) {
    .admin-stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .admin-grid-2 { grid-template-columns: 1fr; }
}

@media (max-width: 860px) {
    .admin-shell {
        display: block;
    }

    .admin-main {
        padding: 1rem;
    }

    .admin-menu-btn,
    .admin-sidebar-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: min(320px, 88vw);
        transform: translateX(-105%);
        transition: transform 0.25s;
    }

    .admin-sidebar.is-open {
        transform: translateX(0);
    }

    .admin-overlay.is-open {
        display: block;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(15, 23, 42, 0.38);
    }

    .admin-home-link { display: none; }
}

@media (max-width: 560px) {
    .admin-stat-grid { grid-template-columns: 1fr; }
}
</style>
@endsection
