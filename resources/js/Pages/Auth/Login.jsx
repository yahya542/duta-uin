import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Login() {
    const [showPassword, setShowPassword] = React.useState(false);
    const { data, setData, post, processing, errors } = useForm({
        login: '',
        password: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Masuk Akun" />
            
            <div className="auth-container">
                <div className="auth-card bg-white border border-black/5 p-12 rounded-[2rem] shadow-xl w-full max-w-[440px] mx-auto mt-20">
                    <div className="auth-header text-center mb-8">
                        <h1 className="auth-title text-3xl font-black mb-2">Selamat Datang</h1>
                        <p className="auth-subtitle text-[#64748b]">Masuk ke akun Anda untuk melanjutkan voting.</p>
                    </div>

                    <form onSubmit={submit}>
                        {errors.login && (
                            <div className="error-alert bg-red-50 border border-red-100 p-4 rounded-xl flex items-center gap-3 mb-6 animate-pulse">
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span className="text-red-500 text-sm font-bold">{errors.login}</span>
                            </div>
                        )}

                        <div className="form-group mb-6">
                            <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Email / Username</label>
                            <input 
                                type="text" 
                                className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                placeholder="Masukkan email atau username"
                                value={data.login}
                                onChange={e => setData('login', e.target.value)}
                                required
                            />
                        </div>

                        <div className="form-group mb-8">
                            <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Kata Sandi</label>
                            <div className="relative group">
                                <input 
                                    type={showPassword ? 'text' : 'password'} 
                                    className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all pr-12" 
                                    placeholder="••••••••"
                                    value={data.password}
                                    onChange={e => setData('password', e.target.value)}
                                    required
                                />
                                <button 
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    className="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition-colors"
                                >
                                    {showPassword ? (
                                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    ) : (
                                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                                    )}
                                </button>
                            </div>
                        </div>

                        <button 
                            type="submit" 
                            disabled={processing}
                            className="btn-submit w-full bg-[#2563eb] text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50"
                        >
                            {processing ? 'Memproses...' : 'Masuk ke Akun'}
                        </button>
                    </form>

                    <div className="auth-footer text-center mt-8 text-sm text-[#64748b]">
                        Belum punya akun? <Link href="/register" className="text-[#2563eb] font-black hover:underline ml-1">Daftar di sini</Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
