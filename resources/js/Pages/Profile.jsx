import React, { useState } from 'react';
import { Head, useForm, usePage, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Profile() {
    const { auth } = usePage().props;
    const [preview, setPreview] = useState(null);

    const { data, setData, post, processing, errors } = useForm({
        _method: 'PUT',
        name: auth.user.name || '',
        username: auth.user.username || '',
        email: auth.user.email || '',
        whatsapp: auth.user.whatsapp || '',
        avatar: null,
        password: '',
        password_confirmation: '',
    });

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setData('avatar', file);
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => setPreview(e.target.result);
            reader.readAsDataURL(file);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post('/profile');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Profil Saya" />
            
            <div className="min-h-screen bg-[#f1f5f9] py-20 lg:py-32">
                <div className="container mx-auto px-6">
                    <div className="max-w-[1000px] mx-auto grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-10 items-start">
                        
                        {/* Sidebar Profile */}
                        <div className="lg:sticky lg:top-32">
                            <div className="bg-white border border-black/5 rounded-[2rem] p-10 text-center shadow-xl">
                                <div className="relative w-40 h-40 mx-auto mb-8">
                                    <img 
                                        src={preview || (auth.user.avatar ? `/storage/${auth.user.avatar}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user.name)}&size=200&background=2563eb&color=ffffff`)} 
                                        className="w-full h-full rounded-full object-cover border-4 border-white shadow-2xl"
                                        alt="Avatar"
                                    />
                                    <label htmlFor="avatarInput" className="absolute bottom-1 right-1 w-11 h-11 bg-[#2563eb] text-white rounded-full flex items-center justify-center cursor-pointer border-4 border-white shadow-lg hover:scale-110 transition-transform">
                                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </label>
                                    <input type="file" id="avatarInput" hidden accept="image/*" onChange={handleFileChange} />
                                </div>
                                <h2 className="text-2xl font-black text-[#0f172a] mb-1">{auth.user.name}</h2>
                                <p className="inline-block px-4 py-1.5 bg-blue-50 text-[#2563eb] text-[10px] font-black uppercase tracking-widest rounded-full">{auth.user.role}</p>
                                
                                <div className="mt-10 pt-8 border-t border-black/5 space-y-4 text-left">
                                    <div className="flex justify-between items-center">
                                        <span className="text-[10px] font-black text-[#64748b] uppercase tracking-wider">ID USER</span>
                                        <span className="text-[10px] font-black text-[#0f172a]">#{auth.user.id}</span>
                                    </div>
                                    <div className="flex justify-between items-center">
                                        <span className="text-[10px] font-black text-[#64748b] uppercase tracking-wider">SALDO POIN</span>
                                        <span className="text-sm font-black text-[#2563eb]">{auth.user.points.toLocaleString()} PTS</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Main Form */}
                        <div className="bg-white border border-black/5 rounded-[2.5rem] p-8 lg:p-12 shadow-2xl">
                            <h1 className="text-3xl font-black text-[#0f172a] mb-12 flex items-center gap-4">
                                <div className="w-12 h-12 bg-blue-50 text-[#2563eb] rounded-2xl flex items-center justify-center">
                                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                Pengaturan Akun
                            </h1>

                            <form onSubmit={submit} className="space-y-8">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div className="space-y-2">
                                        <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Nama Lengkap</label>
                                        <input 
                                            type="text" 
                                            className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] focus:bg-white transition-all"
                                            value={data.name}
                                            onChange={e => setData('name', e.target.value)}
                                            required
                                        />
                                        {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Username</label>
                                        <input 
                                            type="text" 
                                            className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] focus:bg-white transition-all"
                                            value={data.username}
                                            onChange={e => setData('username', e.target.value)}
                                            required
                                        />
                                        {errors.username && <p className="text-red-500 text-xs mt-1">{errors.username}</p>}
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div className="space-y-2">
                                        <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Email</label>
                                        <input 
                                            type="email" 
                                            className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] focus:bg-white transition-all"
                                            value={data.email}
                                            onChange={e => setData('email', e.target.value)}
                                            required
                                        />
                                        {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
                                    </div>
                                    <div className="space-y-2">
                                        <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">WhatsApp</label>
                                        <input 
                                            type="text" 
                                            className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] focus:bg-white transition-all"
                                            placeholder="Contoh: 08123456789"
                                            value={data.whatsapp}
                                            onChange={e => setData('whatsapp', e.target.value)}
                                        />
                                        {errors.whatsapp && <p className="text-red-500 text-xs mt-1">{errors.whatsapp}</p>}
                                    </div>
                                </div>

                                <div className="pt-10 border-t-2 border-black/5 mt-12 space-y-8">
                                    <div>
                                        <h3 className="text-xl font-black text-[#0f172a] mb-2">Ganti Kata Sandi</h3>
                                        <p className="text-xs text-[#64748b] font-bold">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                                    </div>
                                    
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div className="space-y-2">
                                            <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Kata Sandi Baru</label>
                                            <input 
                                                type="password" 
                                                className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] focus:bg-white transition-all"
                                                value={data.password}
                                                onChange={e => setData('password', e.target.value)}
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Konfirmasi</label>
                                            <input 
                                                type="password" 
                                                className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] focus:bg-white transition-all"
                                                value={data.password_confirmation}
                                                onChange={e => setData('password_confirmation', e.target.value)}
                                            />
                                        </div>
                                    </div>
                                    {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password}</p>}
                                </div>

                                <div className="flex justify-end gap-4 pt-10">
                                    <Link href="/" className="px-8 py-4 font-black uppercase tracking-widest text-[10px] text-[#64748b] hover:text-[#0f172a] transition-colors">Batal</Link>
                                    <button 
                                        type="submit" 
                                        disabled={processing}
                                        className="bg-[#2563eb] text-white px-10 py-4 rounded-[1.25rem] font-black uppercase tracking-widest text-[10px] shadow-xl shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50"
                                    >
                                        {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
