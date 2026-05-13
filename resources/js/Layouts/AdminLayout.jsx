import React, { useState } from 'react';
import { Link, usePage, Head } from '@inertiajs/react';

export default function AdminLayout({ children, title, kicker }) {
    const { auth, url } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState('');

    const navigation = [
        { name: 'Ringkasan', href: '/admin', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        )},
        { name: 'Verifikasi Pembayaran', href: '/admin/transactions', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        )},
        { name: 'Manajemen User', href: '/admin/users', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        )},
        { name: 'Laporan Aktivitas', href: '/admin/activity', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        )},
        { name: 'Kelola Kandidat', href: '/admin/candidates', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        )},
    ];

    const isActive = (href) => {
        if (href === '/admin') return url === '/admin';
        return url.startsWith(href);
    };

    return (
        <div className="admin-shell min-h-screen lg:grid lg:grid-cols-[280px_minmax(0,1fr)] bg-[#f8fafc]">
            <Head title={title} />
            
            {/* Sidebar */}
            <aside className={`admin-sidebar fixed lg:sticky top-0 left-0 h-screen w-[280px] bg-white border-r border-black/5 p-6 flex flex-col z-[1100] transition-transform duration-300 ${sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'}`}>
                <div className="admin-sidebar-head flex items-center justify-between mb-10">
                    <Link href="/admin" className="text-xl font-black text-[#0f172a]">Admin<span className="text-[#2563eb]">Panel</span></Link>
                    <button onClick={() => setSidebarOpen(false)} className="lg:hidden text-2xl">×</button>
                </div>

                <nav className="admin-nav space-y-2">
                    {navigation.map((item) => (
                        <Link 
                            key={item.name}
                            href={item.href}
                            className={`flex items-center gap-4 p-4 rounded-2xl font-extrabold text-sm transition-all ${isActive(item.href) ? 'bg-blue-50 text-[#2563eb] border border-blue-100/50' : 'text-[#64748b] hover:bg-gray-50 hover:text-[#0f172a]'}`}
                        >
                            <span className={`w-9 h-9 rounded-xl flex items-center justify-center transition-colors ${isActive(item.href) ? 'bg-[#2563eb] text-white shadow-lg shadow-blue-100' : 'bg-gray-50 text-[#2563eb]'}`}>
                                {item.icon}
                            </span>
                            {item.name}
                        </Link>
                    ))}
                </nav>

                <div className="admin-sidebar-foot mt-auto bg-[#f8fafc] border border-black/5 rounded-2xl p-5">
                    <span className="block text-[9px] font-black text-[#64748b] uppercase tracking-widest mb-1">Login sebagai</span>
                    <strong className="block text-[#0f172a] font-black text-sm mb-4 truncate">{auth.user.name}</strong>
                    <Link 
                        href="/logout" 
                        method="post" 
                        as="button" 
                        className="flex items-center gap-2 w-full pt-4 border-t border-black/5 text-[10px] font-black text-red-500 uppercase tracking-wider hover:translate-x-1 transition-transform"
                    >
                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar Sesi
                    </Link>
                </div>
            </aside>

            {/* Overlay */}
            {sidebarOpen && (
                <div onClick={() => setSidebarOpen(false)} className="fixed inset-0 bg-black/20 backdrop-blur-sm z-[1050] lg:hidden animate-in fade-in duration-300"></div>
            )}

            {/* Main Content */}
            <main className="admin-main p-6 lg:p-10">
                <header className="admin-topbar sticky top-0 bg-[#f8fafc]/80 backdrop-blur-md z-[1000] border-b border-black/5 mb-10 py-6 flex items-center gap-4">
                    <button onClick={() => setSidebarOpen(true)} className="lg:hidden w-10 h-10 bg-white border border-black/5 rounded-xl flex items-center justify-center shadow-sm">
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    </button>
                    <div className="flex-grow">
                        <p className="text-[10px] font-black text-[#2563eb] uppercase tracking-widest mb-1">{kicker || 'Admin Dashboard'}</p>
                        <h1 className="text-3xl lg:text-4xl font-black text-[#0f172a] leading-tight">{title}</h1>
                    </div>

                    <div className="hidden md:flex items-center gap-4">
                        <div className="relative">
                            <input 
                                type="text" 
                                placeholder="Cari data..." 
                                className="bg-white border border-black/5 rounded-xl pl-10 pr-4 py-2.5 text-sm font-bold w-[240px] focus:w-[320px] focus:border-[#2563eb] outline-none transition-all"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                            />
                            <svg className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#64748b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <Link href="/" className="px-5 py-2.5 bg-white border border-black/5 rounded-xl text-[10px] font-black uppercase tracking-wider text-[#0f172a] hover:bg-gray-50 shadow-sm transition-all">Lihat Situs</Link>
                    </div>
                </header>

                <div className="animate-in fade-in slide-in-from-bottom-4 duration-500">
                    {children}
                </div>
            </main>
        </div>
    );
}
