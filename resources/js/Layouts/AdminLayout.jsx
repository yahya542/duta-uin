import React, { useState, useEffect } from 'react';
import { Link, usePage, Head } from '@inertiajs/react';
import Toast from '@/Components/Toast';

export default function AdminLayout({ children, title, kicker }) {
    const { auth, flash } = usePage().props;
    const { url } = usePage();
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState('');
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
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        )},
        { name: 'Verifikasi Pembayaran', href: '/admin/transactions', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        )},
        { name: 'Manajemen User', href: '/admin/users', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        )},
        { name: 'Kelola Kandidat', href: '/admin/candidates', icon: (
            <svg fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        )},
    ];

    const isActive = (href) => {
        if (!url) return false;
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
                            <span className={`w-10 h-10 rounded-xl flex items-center justify-center transition-colors shrink-0 ${isActive(item.href) ? 'bg-[#2563eb] text-white shadow-lg shadow-blue-100' : 'bg-gray-50 text-[#2563eb]'}`}>
                                <div className="w-5 h-5">
                                    {item.icon}
                                </div>
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
            <main className="admin-main flex-1 flex flex-col min-w-0">
                <header className="admin-topbar sticky top-0 z-[1900] bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 px-6 lg:px-10 h-24 flex items-center shadow-sm">
                    <div className="w-full flex items-center gap-4 lg:gap-8">
                        <button onClick={() => setSidebarOpen(true)} className="lg:hidden w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-600 shadow-sm active:scale-90 transition-all">
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                        
                        <div className="flex-grow min-w-0">
                            <div className="flex items-center gap-2 mb-1">
                                <div className="w-1 h-3 bg-blue-600 rounded-full"></div>
                                <p className="text-[10px] font-black text-blue-600 uppercase tracking-[2px] truncate">{kicker || 'Admin Dashboard'}</p>
                            </div>
                            <h1 className="text-xl lg:text-2xl font-black text-slate-900 leading-tight truncate">{title}</h1>
                        </div>

                        <div className="flex items-center gap-4 lg:gap-8">
                            <Link href="/" className="hidden sm:flex px-6 py-3 bg-white border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:border-blue-400 hover:text-blue-600 shadow-sm transition-all duration-300">Lihat Situs</Link>

                            <div className="relative">
                                <button 
                                    onClick={() => setProfileOpen(!profileOpen)}
                                    className="flex items-center gap-3 p-1 rounded-2xl hover:bg-slate-50 transition-all duration-300 group active:scale-95"
                                >
                                    <div className="w-11 h-11 rounded-2xl border-2 border-white shadow-lg overflow-hidden group-hover:border-blue-100 transition-all">
                                        <img 
                                            src={`https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user.name)}&background=2563eb&color=fff&bold=true`} 
                                            className="w-full h-full object-cover" 
                                        />
                                    </div>
                                    <div className="hidden md:block text-left">
                                        <p className="text-xs font-black text-slate-900 leading-none mb-1">{auth.user.username}</p>
                                        <p className="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none">Administrator</p>
                                    </div>
                                    <svg className={`hidden md:block w-4 h-4 text-slate-300 transition-transform duration-500 ${profileOpen ? 'rotate-180' : ''}`} fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="4"><path d="M19 9l-7 7-7-7" /></svg>
                                </button>

                                {profileOpen && (
                                    <>
                                        <div className="fixed inset-0 z-[2000]" onClick={() => setProfileOpen(false)}></div>
                                        <div className="absolute right-0 mt-4 w-[280px] bg-white border border-slate-200 rounded-[2.5rem] shadow-[0_30px_100px_rgba(0,0,0,0.12)] z-[2100] py-6 overflow-hidden animate-in fade-in zoom-in-95 duration-300">
                                            <div className="px-8 py-4 border-b border-slate-50 bg-slate-50/50 mb-4">
                                                <p className="text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-1 text-center">Profil Admin</p>
                                                <p className="text-sm font-bold text-slate-900 text-center truncate">{auth.user.email}</p>
                                            </div>
                                            <div className="px-3 space-y-1.5">
                                                <Link href="/profile" className="flex items-center gap-4 w-full p-4 px-6 text-sm font-bold text-slate-700 hover:bg-blue-600 hover:text-white rounded-[1.5rem] transition-all duration-300 group">
                                                    <svg className="w-5 h-5 opacity-60 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                                    Pengaturan Profil
                                                </Link>
                                                <Link href="/logout" method="post" as="button" className="flex items-center gap-4 w-full p-4 px-6 text-sm font-bold text-red-500 hover:bg-red-50 rounded-[1.5rem] transition-all duration-300 group text-left">
                                                    <svg className="w-5 h-5 opacity-60 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                                    Keluar
                                                </Link>
                                            </div>
                                        </div>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </header>

                <div className="p-6 lg:p-10 animate-in fade-in slide-in-from-bottom-4 duration-500">
                    {children}
                </div>
            </main>
            {/* Toast Notification */}
            {toast && (
                <Toast 
                    message={toast.message} 
                    type={toast.type} 
                    onClose={() => setToast(null)} 
                />
            )}
        </div>
    );
}
