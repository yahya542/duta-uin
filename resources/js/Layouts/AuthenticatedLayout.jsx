import React, { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function AuthenticatedLayout({ children }) {
    const { auth, flash } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);
    const [showToast, setShowToast] = useState(!!(flash.success || flash.error));
    const [progress, setProgress] = useState(100);

    useEffect(() => {
        if (showToast) {
            const timer = setInterval(() => {
                setProgress((prev) => {
                    if (prev <= 0) {
                        clearInterval(timer);
                        setShowToast(false);
                        return 0;
                    }
                    return prev - 1;
                });
            }, 50);
            return () => clearInterval(timer);
        }
    }, [showToast]);

    const isAdminRoute = window.location.pathname.startsWith('/admin');

    return (
        <div className="app-layout min-h-screen bg-[#f8fafc]">
            {/* BACKGROUND DECORATIONS */}
            <div className="decoration-blob blob-1"></div>
            <div className="decoration-blob blob-2"></div>
            <div className="decoration-dots"></div>

            {!isAdminRoute && (
                <>
                    {/* SIDEBAR OVERLAY */}
                    {sidebarOpen && (
                        <div 
                            className="sidebar-overlay fixed inset-0 bg-black/40 backdrop-blur-[4px] z-[999] lg:hidden" 
                            onClick={() => setSidebarOpen(false)}
                        />
                    )}

                    {/* SIDEBAR */}
                    <aside className={`sidebar ${sidebarOpen ? 'open' : ''} lg:translate-x-0`}>
                        <div className="sidebar-header">
                            <Link href="/" className="nav-brand text-xl font-black text-[#0f172a]">
                                DUTA<span className="text-[#2563eb]">KAMPUS</span>
                            </Link>
                        </div>
                        <nav className="sidebar-nav">
                            <Link href="/" className={`sidebar-link ${window.location.pathname === '/' ? 'active' : ''}`}>
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                Beranda
                            </Link>
                            <Link href="/#leaderboard" className={`sidebar-link ${window.location.hash === '#leaderboard' ? 'active' : ''}`}>
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                Leaderboard
                            </Link>
                            <Link href="/tutorial" className={`sidebar-link ${window.location.pathname === '/tutorial' ? 'active' : ''}`}>
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                Tutorial
                            </Link>
                            {auth.user && (
                                <Link href="/topup" className={`sidebar-link ${window.location.pathname === '/topup' ? 'active' : ''}`}>
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 16v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2m5-13V3m0 0L9 5m3-2l3 2" /></svg>
                                    Top Up Poin
                                </Link>
                            )}
                        </nav>
                    </aside>
                </>
            )}

            <div className={`main-content flex-1 flex flex-col min-h-screen transition-all duration-300 ${!isAdminRoute && 'lg:ml-[280px]'}`}>
                {!isAdminRoute && (
                    <nav className="navbar">
                        <div className="nav-container">
                            <div className="flex items-center">
                                <button onClick={() => setSidebarOpen(!sidebarOpen)} className="hamburger-btn lg:hidden mr-4">
                                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                </button>
                            </div>

                            <div className="flex items-center gap-6">
                                {auth.user ? (
                                    <>
                                        <div className="flex items-center gap-2 bg-[#fffbeb] px-4 py-2 rounded-full border border-[#fef3c7]">
                                            <div className="w-6 h-6 bg-[#fbbf24] rounded-full flex items-center justify-center text-white">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            </div>
                                            <span className="font-black text-[#92400e] text-sm">{auth.user.points.toLocaleString()} <span className="text-[10px] uppercase">pts</span></span>
                                        </div>

                                        <div className="profile-dropdown" onClick={() => setProfileOpen(!profileOpen)}>
                                            <button className="flex items-center gap-3 bg-white border border-black/10 px-2 py-1.5 pl-4 rounded-full">
                                                <span className="font-bold text-sm text-[#0f172a]">{auth.user.name || auth.user.username}</span>
                                                <img 
                                                    src={`https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user.name || auth.user.username)}&background=2563eb&color=fff`} 
                                                    className="w-8 h-8 rounded-full" 
                                                    alt="Avatar" 
                                                />
                                            </button>
                                            
                                            {profileOpen && (
                                                <div className="dropdown-menu">
                                                    <div className="px-4 py-2 pb-4 border-bottom mb-2">
                                                        <p className="text-xs text-[#64748b] mb-1">Email Anda</p>
                                                        <p className="text-[13px] font-bold text-[#0f172a] break-all">{auth.user.email}</p>
                                                    </div>
                                                    <Link href="/logout" method="post" as="button" className="dropdown-item logout">
                                                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                                        Keluar Sesi
                                                    </Link>
                                                </div>
                                            )}
                                        </div>
                                    </>
                                ) : (
                                    <Link href="/login" className="btn btn-primary px-6 py-2.5 text-sm font-bold rounded-full">Masuk Akun</Link>
                                )}
                            </div>
                        </div>
                    </nav>
                )}

                <div className={`flex-1 ${!isAdminRoute ? 'px-8 py-0' : 'p-0'}`}>
                    {children}
                </div>

                {!isAdminRoute && (
                    <footer className="bg-white border-t border-black/10 py-10 px-8 mt-auto">
                        <div className="max-w-[1200px] mx-auto text-center text-[#64748b] text-[13px] font-bold">
                            &copy; 2026 Duta Kampus UIN Madura. All Rights Reserved.
                        </div>
                    </footer>
                )}
            </div>

            {/* TOAST NOTIFICATION */}
            {showToast && (
                <div className="toast-wrap">
                    <div className={`toast-card ${flash.success ? 'toast-success' : 'toast-error'}`}>
                        <div className="toast-content">
                            <div className="toast-icon">
                                {flash.success ? (
                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" /></svg>
                                ) : (
                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                )}
                            </div>
                            <span className="toast-message">{flash.success || flash.error}</span>
                        </div>
                        <div className="toast-progress" style={{ width: `${progress}%` }}></div>
                    </div>
                </div>
            )}
        </div>
    );
}
