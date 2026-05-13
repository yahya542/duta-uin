import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Register() {
    const [step, setStep] = useState(1);
    const [localErrors, setLocalErrors] = useState({});

    const { data, setData, post, processing, errors } = useForm({
        first_name: '',
        last_name: '',
        username: '',
        email: '',
        whatsapp: '',
        password: '',
        password_confirmation: '',
    });

    const validateStep1 = () => {
        const newErrors = {};
        if (!data.first_name) newErrors.first_name = 'Nama depan wajib diisi.';
        if (!data.last_name) newErrors.last_name = 'Nama belakang wajib diisi.';
        if (!data.username) newErrors.username = 'Username wajib diisi.';
        
        if (Object.keys(newErrors).length > 0) {
            setLocalErrors(newErrors);
            return;
        }
        setLocalErrors({});
        setStep(2);
    };

    const validateStep2 = () => {
        const newErrors = {};
        if (!data.email) newErrors.email = 'Email wajib diisi.';
        if (!data.whatsapp) newErrors.whatsapp = 'Nomor WhatsApp wajib diisi.';
        if (!data.password) newErrors.password = 'Password wajib diisi.';
        if (data.password.length < 8) newErrors.password = 'Password minimal 8 karakter.';
        if (data.password !== data.password_confirmation) newErrors.password_confirmation = 'Konfirmasi password tidak cocok.';

        if (Object.keys(newErrors).length > 0) {
            setLocalErrors(newErrors);
            return;
        }
        setLocalErrors({});
        setStep(3);
    };

    const submit = (e) => {
        e.preventDefault();
        post('/register');
    };

    const steps = [
        { id: 1, label: 'Pribadi' },
        { id: 2, label: 'Akun' },
        { id: 3, label: 'Review' },
    ];

    return (
        <AuthenticatedLayout>
            <Head title="Daftar Akun" />
            
            <div className="auth-container mt-12 mb-20">
                <div className="auth-card bg-white border border-black/5 p-10 rounded-[2.5rem] shadow-xl w-full max-w-[500px] mx-auto">
                    {/* Stepper */}
                    <div className="relative flex justify-between mb-12">
                        <div className="absolute top-[18px] left-0 right-0 h-0.5 bg-black/5 z-0"></div>
                        <div 
                            className="absolute top-[18px] left-0 h-0.5 bg-[#2563eb] z-0 transition-all duration-500" 
                            style={{ width: `${((step - 1) / (steps.length - 1)) * 100}%` }}
                        ></div>
                        
                        {steps.map((s) => (
                            <div key={s.id} className="relative z-10 flex flex-col items-center gap-2">
                                <div className={`w-9 h-9 rounded-full flex items-center justify-center text-xs font-black transition-all duration-300 border-2 ${step >= s.id ? 'bg-[#2563eb] text-white border-[#2563eb] shadow-lg shadow-blue-200' : 'bg-white text-[#64748b] border-black/10'}`}>
                                    {step > s.id ? '✓' : s.id}
                                </div>
                                <span className={`text-[9px] font-black uppercase tracking-widest ${step >= s.id ? 'text-[#0f172a]' : 'text-[#64748b]'}`}>{s.label}</span>
                            </div>
                        ))}
                    </div>

                    <div className="auth-header text-center mb-10">
                        <h1 className="auth-title text-3xl font-black mb-2">
                            {step === 1 ? 'Data Pribadi' : step === 2 ? 'Kontak & Keamanan' : 'Ringkasan Data'}
                        </h1>
                        <p className="auth-subtitle text-[#64748b]">Silakan isi formulir pendaftaran bertahap.</p>
                    </div>

                    <form onSubmit={submit}>
                        {/* STEP 1: PRIBADI */}
                        {step === 1 && (
                            <div className="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="form-group">
                                        <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Nama Depan</label>
                                        <input 
                                            type="text" 
                                            className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                            placeholder="Depan"
                                            value={data.first_name}
                                            onChange={e => setData('first_name', e.target.value)}
                                        />
                                        {(localErrors.first_name || errors.first_name) && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{localErrors.first_name || errors.first_name}</p>}
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Nama Belakang</label>
                                        <input 
                                            type="text" 
                                            className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                            placeholder="Belakang"
                                            value={data.last_name}
                                            onChange={e => setData('last_name', e.target.value)}
                                        />
                                        {(localErrors.last_name || errors.last_name) && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{localErrors.last_name || errors.last_name}</p>}
                                    </div>
                                </div>

                                <div className="form-group">
                                    <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Username</label>
                                    <input 
                                        type="text" 
                                        className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                        placeholder="Pilih username"
                                        value={data.username}
                                        onChange={e => setData('username', e.target.value)}
                                    />
                                    {(localErrors.username || errors.username) && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{localErrors.username || errors.username}</p>}
                                </div>

                                <button type="button" onClick={validateStep1} className="w-full bg-[#2563eb] text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all">
                                    Lanjutkan <span className="ml-2">→</span>
                                </button>
                            </div>
                        )}

                        {/* STEP 2: KONTAK & AKUN */}
                        {step === 2 && (
                            <div className="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">
                                <div className="form-group">
                                    <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Email Address</label>
                                    <input 
                                        type="email" 
                                        className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                        placeholder="name@example.com"
                                        value={data.email}
                                        onChange={e => setData('email', e.target.value)}
                                    />
                                    {(localErrors.email || errors.email) && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{localErrors.email || errors.email}</p>}
                                </div>

                                <div className="form-group">
                                    <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Nomor WhatsApp</label>
                                    <input 
                                        type="text" 
                                        className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                        placeholder="08xxxxxxxxx"
                                        value={data.whatsapp}
                                        onChange={e => setData('whatsapp', e.target.value)}
                                    />
                                    {(localErrors.whatsapp || errors.whatsapp) && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{localErrors.whatsapp || errors.whatsapp}</p>}
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div className="form-group">
                                        <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Password</label>
                                        <input 
                                            type="password" 
                                            className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                            placeholder="Min. 8"
                                            value={data.password}
                                            onChange={e => setData('password', e.target.value)}
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-2">Konfirmasi</label>
                                        <input 
                                            type="password" 
                                            className="form-input w-full px-4 py-3 rounded-xl border border-black/10 focus:border-[#2563eb] focus:ring-4 focus:ring-blue-100 outline-none transition-all" 
                                            placeholder="Ulangi"
                                            value={data.password_confirmation}
                                            onChange={e => setData('password_confirmation', e.target.value)}
                                        />
                                    </div>
                                </div>
                                {(localErrors.password || errors.password || localErrors.password_confirmation) && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{localErrors.password || errors.password || localErrors.password_confirmation}</p>}

                                <div className="grid grid-cols-[1fr_2fr] gap-4">
                                    <button type="button" onClick={() => setStep(1)} className="w-full bg-[#f8fafc] text-[#0f172a] border border-black/5 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-gray-100 transition-all">
                                        Kembali
                                    </button>
                                    <button type="button" onClick={validateStep2} className="w-full bg-[#2563eb] text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:scale-[1.02] transition-all">
                                        Lanjutkan <span className="ml-2">→</span>
                                    </button>
                                </div>
                            </div>
                        )}

                        {/* STEP 3: REVIEW */}
                        {step === 3 && (
                            <div className="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">
                                <div className="bg-[#f8fafc] border border-black/5 rounded-2xl p-6 space-y-4">
                                    <div className="flex justify-between items-center text-sm">
                                        <span className="text-[#64748b] font-bold">Nama Lengkap</span>
                                        <span className="text-[#0f172a] font-black">{data.first_name} {data.last_name}</span>
                                    </div>
                                    <div className="flex justify-between items-center text-sm">
                                        <span className="text-[#64748b] font-bold">Username</span>
                                        <span className="text-[#2563eb] font-black">@{data.username}</span>
                                    </div>
                                    <div className="flex justify-between items-center text-sm">
                                        <span className="text-[#64748b] font-bold">Email</span>
                                        <span className="text-[#0f172a] font-black">{data.email}</span>
                                    </div>
                                    <div className="flex justify-between items-center text-sm">
                                        <span className="text-[#64748b] font-bold">WhatsApp</span>
                                        <span className="text-[#0f172a] font-black">{data.whatsapp}</span>
                                    </div>
                                </div>

                                <p className="text-[11px] text-[#64748b] text-center leading-relaxed">
                                    Dengan mendaftar, Anda menyetujui syarat dan ketentuan voting Duta Kampus 2026.
                                </p>

                                <div className="grid grid-cols-[1fr_2fr] gap-4">
                                    <button type="button" onClick={() => setStep(2)} className="w-full bg-[#f8fafc] text-[#0f172a] border border-black/5 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-gray-100 transition-all">
                                        Kembali
                                    </button>
                                    <button 
                                        type="submit" 
                                        disabled={processing}
                                        className="w-full bg-[#2563eb] text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50"
                                    >
                                        {processing ? 'Mendaftarkan...' : 'Daftar Sekarang'}
                                    </button>
                                </div>
                            </div>
                        )}
                    </form>

                    <div className="auth-footer text-center mt-10 text-sm text-[#64748b]">
                        Sudah punya akun? <Link href="/login" className="text-[#2563eb] font-black hover:underline ml-1">Login di sini</Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
