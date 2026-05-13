import React, { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import Toast from '@/Components/Toast';

export default function AuthenticatedLayout({ children }) {
    const { auth, flash } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);
    const [toast, setToast] = useState(null);

    useEffect(() => {
        if (flash?.success) {
            setToast({ message: flash.success, type: 'success' });
        } else if (flash?.error) {
            setToast({ message: flash.error, type: 'error' });
        }
    }, [flash]);

    const isAdminRoute = window.location.pathname.startsWith('/admin');

    return (
        <div className="min-h-screen bg-[#f8fafc] font-sans selection:bg-blue-100 selection:text-blue-600">
            {/* SIDEBAR OVERLAY */}
            {sidebarOpen && (
                <div 
                    className="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[2000] transition-all duration-300" 
                    onClick={() => setSidebarOpen(false)}
                />
            )}

            {/* SIDEBAR */}
            <aside className={`fixed top-0 left-0 h-full w-[280px] bg-white border-r border-slate-200/60 z-[2100] transition-transform duration-500 ease-out shadow-2xl ${sidebarOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                <div className="h-24 px-10 flex items-center justify-between border-b border-slate-100/80">
                    <Link href="/" className="flex items-center gap-4 group">
                        <div className="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-xl shadow-blue-500/20 group-hover:rotate-6 transition-transform duration-300">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <span className="text-2xl font-black text-slate-900 tracking-tighter">DUTA<span className="text-blue-600">KAMPUS</span></span>
                    </Link>
                    <button onClick={() => setSidebarOpen(false)} className="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-all">
                        <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <nav className="p-8 space-y-2">
                    <Link href="/" className={`flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm transition-all duration-300 ${window.location.pathname === '/' ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/30' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'}`}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Beranda Utama
                    </Link>
                    <Link href="/#leaderboard" className="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all duration-300">
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        Leaderboard
                    </Link>
                    <Link href="/tutorial" className={`flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm transition-all duration-300 ${window.location.pathname === '/tutorial' ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/30' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'}`}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        Panduan Voting
                    </Link>
                    {auth.user && (
                        <Link href="/topup" className={`flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sm transition-all duration-300 ${window.location.pathname === '/topup' ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/30' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'}`}>
                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 16v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2m5-13V3m0 0L9 5m3-2l3 2" /></svg>
                            Beli Poin
                        </Link>
                    )}
                </nav>

                {auth.user && (
                    <div className="mt-auto p-8 border-t border-slate-100">
                        <Link href="/profile" className="flex items-center gap-4 p-4 rounded-3xl hover:bg-slate-50 transition-all duration-300 group">
                            <img 
                                src={`https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user.name || 'U')}&background=2563eb&color=fff&bold=true`} 
                                className="w-12 h-12 rounded-2xl border-2 border-white shadow-lg group-hover:scale-110 transition-transform duration-300" 
                            />
                            <div className="min-w-0">
                                <p className="text-sm font-black text-slate-900 truncate tracking-tight">{auth.user.name}</p>
                                <p className="text-[10px] font-bold text-slate-400 uppercase tracking-[1.5px]">Pengaturan Akun</p>
                            </div>
                        </Link>
                    </div>
                )}
            </aside>

            {/* MAIN CONTENT AREA */}
            <div className={`flex-1 flex flex-col transition-all duration-500 ease-in-out`}>
                {!isAdminRoute && (
                    <header className="sticky top-0 z-[1900] bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 px-4 lg:px-16 h-24 flex items-center">
                        <div className="w-full mx-auto flex items-center justify-between">
                            <div className="flex items-center gap-6">
                                <button onClick={() => setSidebarOpen(true)} className="w-12 h-12 flex items-center justify-center bg-white border border-slate-200 rounded-2xl text-slate-600 hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition-all shadow-sm active:scale-90 group">
                                    <svg className="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
                                </button>
                                <div className="hidden sm:block">
                                    <div className="flex items-center gap-3">
                                        <div className="w-1.5 h-6 bg-blue-600 rounded-full"></div>
                                        <h2 className="text-[11px] font-black text-slate-400 uppercase tracking-[4px]">E-VOTING PORTAL 2026</h2>
                                    </div>
                                </div>
                            </div>

                            <div className="flex items-center gap-4 lg:gap-8">
                                {auth.user ? (
                                    <>
                                        <div className="hidden md:flex items-center gap-3 bg-white px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
                                            <div className="w-7 h-7 bg-amber-400 rounded-lg flex items-center justify-center text-white shadow-lg shadow-amber-200">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            </div>
                                            <span className="font-black text-slate-800 text-base">{auth.user.points.toLocaleString()} <span className="text-[10px] text-slate-400 uppercase tracking-widest ml-1">Poin</span></span>
                                        </div>

                                        <div className="relative">
                                            <button 
                                                onClick={() => setProfileOpen(!profileOpen)}
                                                className="flex items-center gap-4 bg-white border border-slate-200 p-1.5 pr-5 rounded-2xl hover:border-blue-400 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 active:scale-95"
                                            >
                                                <img 
                                                    src={`https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user.name || 'U')}&background=2563eb&color=fff&bold=true`} 
                                                    className="w-10 h-10 rounded-xl border border-white shadow-md" 
                                                />
                                                <span className="hidden sm:block text-sm font-black text-slate-700 tracking-tight">{auth.user.username}</span>
                                                <svg className={`w-4 h-4 text-slate-300 transition-transform duration-500 ${profileOpen ? 'rotate-180' : ''}`} fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="4"><path d="M19 9l-7 7-7-7" /></svg>
                                            </button>
                                            
                                            {profileOpen && (
                                                <>
                                                    <div className="fixed inset-0 z-[2000]" onClick={() => setProfileOpen(false)}></div>
                                                    <div className="absolute right-0 mt-4 w-[300px] bg-white border border-slate-200 rounded-[2.5rem] shadow-[0_30px_100px_rgba(0,0,0,0.12)] z-[2100] py-6 overflow-hidden animate-in fade-in zoom-in-95 duration-300">
                                                        <div className="px-8 py-4 border-b border-slate-50 bg-slate-50/50 mb-4">
                                                            <p className="text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-1">Email Terdaftar</p>
                                                            <p className="text-sm font-bold text-slate-900 truncate">{auth.user.email}</p>
                                                        </div>
                                                        <div className="px-3 space-y-1.5">
                                                            {auth.user.role === 'admin' && (
                                                                <Link href="/admin" className="flex items-center gap-4 w-full p-4 px-6 text-sm font-bold text-slate-700 hover:bg-blue-600 hover:text-white rounded-[1.5rem] transition-all duration-300 group">
                                                                    <svg className="w-5 h-5 opacity-60 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                                    Dashboard Admin
                                                                </Link>
                                                            )}
                                                            <Link href="/profile" className="flex items-center gap-4 w-full p-4 px-6 text-sm font-bold text-slate-700 hover:bg-blue-600 hover:text-white rounded-[1.5rem] transition-all duration-300 group">
                                                                <svg className="w-5 h-5 opacity-60 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                                                Profil & Keamanan
                                                            </Link>
                                                            <Link href="/logout" method="post" as="button" className="flex items-center gap-4 w-full p-4 px-6 text-sm font-bold text-red-500 hover:bg-red-50 rounded-[1.5rem] transition-all duration-300 group">
                                                                <svg className="w-5 h-5 opacity-60 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                                                Keluar
                                                            </Link>
                                                        </div>
                                                    </div>
                                                </>
                                            )}
                                        </div>
                                    </>
                                ) : (
                                    <div className="flex items-center gap-3">
                                        <Link href="/login" className="px-10 py-4 bg-blue-600 text-white text-[11px] font-black uppercase tracking-[2.5px] rounded-2xl shadow-2xl shadow-blue-500/30 hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300 active:translate-y-0">Masuk Akun</Link>
                                        <Link href="/register" className="hidden sm:block px-10 py-4 bg-white border border-slate-200 text-slate-700 text-[11px] font-black uppercase tracking-[2.5px] rounded-2xl hover:bg-slate-50 transition-all duration-300">Daftar</Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </header>
                )}

                <main className={`flex-1 px-4 lg:px-16 py-12 lg:py-16`}>
                    <div className="max-w-7xl mx-auto">
                        {children}
                    </div>
                </main>

                {!isAdminRoute && (
                    <footer className="bg-white border-t border-black/10 py-10 px-8 mt-auto">
                        <div className="max-w-[1200px] mx-auto text-center text-[#64748b] text-[13px] font-bold">
                            &copy; 2026 Duta Kampus UIN Madura. All Rights Reserved.
                        </div>
                    </footer>
                )}
            </div>

            {/* TOAST NOTIFICATION */}
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
