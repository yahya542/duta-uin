import React, { useState, useEffect } from 'react';
import { Link, usePage, Head } from '@inertiajs/react';
import Toast from '@/Components/Toast';

export default function AdminLayout({ children, title, kicker }) {
    const { auth, flash } = usePage().props;
    const { url } = usePage();
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [isCollapsed, setIsCollapsed] = useState(false);
    const [toast, setToast] = useState(null);

    useEffect(() => {
        if (flash?.success) {
            setToast({ message: flash.success, type: 'success' });
        } else if (flash?.error) {
            setToast({ message: flash.error, type: 'error' });
        }
    }, [flash]);

    const navigation = [
        { name: 'Ringkasan', href: '/admin', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        )},
        { name: 'Verifikasi Pembayaran', href: '/admin/transactions', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        )},
        { name: 'Manajemen User', href: '/admin/users', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        )},
        { name: 'Kelola Kandidat', href: '/admin/candidates', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        )},
    ];

    const isActive = (href) => {
        if (!url) return false;
        if (href === '/admin') return url === '/admin';
        return url.startsWith(href);
    };

    return (
        <div className="min-h-screen bg-[#f1f5f3] font-sans selection:bg-blue-100 selection:text-blue-600 overflow-x-hidden">
            <Head title={title} />
            {toast && <Toast message={toast.message} type={toast.type} onClose={() => setToast(null)} />}

            <div className="flex">
                {/* Sidebar */}
                <aside className={`fixed lg:sticky top-0 left-0 h-screen bg-white flex flex-col z-[1000] transition-all duration-500 ease-in-out border-r border-slate-100 ${sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'} ${isCollapsed ? 'w-[100px] p-6' : 'w-[280px] p-8'}`}>
                    {/* Logo & Toggle */}
                    <div className={`mb-12 flex items-center transition-all duration-500 ${isCollapsed ? 'justify-center' : 'gap-4'}`}>
                        <div className="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-500/20 shrink-0">
                            <svg className="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        {!isCollapsed && (
                            <div className="flex-1 animate-in fade-in slide-in-from-left-2 duration-300">
                                <span className="text-2xl font-black text-slate-900 tracking-tighter">Gymove<span className="text-blue-600">.</span></span>
                            </div>
                        )}
                        <button 
                            onClick={() => setIsCollapsed(!isCollapsed)}
                            className={`hidden lg:flex w-8 h-8 bg-slate-50 border border-slate-100 rounded-lg items-center justify-center text-slate-400 hover:text-blue-600 transition-all ${isCollapsed ? 'rotate-180' : ''}`}
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M15 19l-7-7 7-7" /></svg>
                        </button>
                    </div>

                    {/* Navigation */}
                    <div className="mb-8 overflow-y-auto custom-scrollbar flex-1">
                        {!isCollapsed && <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-6 px-4 animate-in fade-in duration-300">Main Menu</span>}
                        <nav className="space-y-3">
                            {navigation.map((item) => (
                                <Link 
                                    key={item.name}
                                    href={item.href}
                                    className={`flex items-center gap-4 py-4 rounded-2xl font-bold text-sm transition-all duration-300 relative group ${isCollapsed ? 'px-0 justify-center' : 'px-6'} ${isActive(item.href) ? 'bg-blue-600 text-white shadow-2xl shadow-blue-500/30' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50'}`}
                                >
                                    <div className={`w-5 h-5 shrink-0 transition-colors ${isActive(item.href) ? 'text-white' : 'text-slate-400 group-hover:text-slate-900'}`}>
                                        {item.icon}
                                    </div>
                                    {!isCollapsed && <span className="truncate animate-in fade-in slide-in-from-left-2 duration-300">{item.name}</span>}
                                    {isActive(item.href) && !isCollapsed && <div className="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-blue-300 rounded-l-full"></div>}
                                </Link>
                            ))}
                        </nav>
                    </div>

                    {!isCollapsed ? (
                        <div className="p-6 bg-blue-600 rounded-[2rem] text-center relative overflow-hidden group animate-in zoom-in-95 duration-300">
                            <div className="absolute -top-10 -right-10 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                            <div className="relative z-10">
                                <div className="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 text-white">
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                </div>
                                <p className="text-white font-black text-xs uppercase tracking-widest mb-1">Duta UIN</p>
                                <p className="text-white/60 text-[10px] font-bold">Admin Panel</p>
                            </div>
                        </div>
                    ) : (
                        <div className="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white mx-auto shadow-lg shadow-blue-500/20 cursor-pointer hover:scale-110 transition-transform">
                             <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                    )}
                </aside>

                {/* Main Content */}
                <main className="flex-1 min-w-0 flex flex-col p-4 lg:p-8 transition-all duration-500 ease-in-out">
                    {/* Topbar */}
                    <header className="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                        <div className="flex items-center gap-6 w-full md:w-auto">
                            <button onClick={() => setSidebarOpen(!sidebarOpen)} className="lg:hidden w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-900 shadow-sm border border-slate-100">
                                <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M4 6h16M4 12h16m-7 6h7" /></svg>
                            </button>
                            <h1 className="text-2xl font-black text-slate-900 truncate tracking-tight">{title || 'Dashboard'}</h1>
                        </div>

                        <div className="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                            <div className="relative flex-1 md:w-[320px]">
                                <input 
                                    type="text" 
                                    placeholder="Search statistics..." 
                                    className="w-full bg-white border border-transparent rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-900 placeholder:text-slate-400 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 outline-none transition-all"
                                />
                                <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>

                            <div className="flex items-center gap-3 shrink-0">
                                <button className="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm relative border border-slate-50">
                                    <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    <span className="absolute top-3 right-3 w-2.5 h-2.5 bg-orange-500 border-2 border-white rounded-full"></span>
                                </button>
                                <div className="h-12 w-px bg-slate-200 mx-2 hidden md:block"></div>
                                <div className="flex items-center gap-4 group cursor-pointer">
                                    <div className="text-right hidden md:block">
                                        <p className="text-sm font-black text-slate-900 leading-none mb-1 group-hover:text-blue-600 transition-colors">{auth.user.name}</p>
                                        <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                                    </div>
                                    <img 
                                        src={`https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user.name)}&background=2563eb&color=fff&bold=true`} 
                                        className="w-12 h-12 rounded-2xl border-2 border-white shadow-lg group-hover:scale-105 transition-transform duration-300" 
                                    />
                                </div>
                            </div>
                        </div>
                    </header>

                    <div className="flex-1 animate-in fade-in slide-in-from-bottom-4 duration-500">
                        {children}
                    </div>
                </main>
            </div>

            {/* Global Overlay for Mobile Sidebar */}
            {sidebarOpen && (
                <div 
                    className="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[900] lg:hidden animate-in fade-in duration-300" 
                    onClick={() => setSidebarOpen(false)}
                />
            )}
        </div>
    );
}
