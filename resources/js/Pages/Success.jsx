import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Success({ waUrl, gformUrl }) {
    return (
        <AuthenticatedLayout>
            <Head title="Top Up Berhasil" />
            
            <div className="auth-container mt-20 mb-32">
                <div className="auth-card bg-white border border-black/5 p-12 lg:p-16 rounded-[3rem] shadow-2xl w-full max-w-[640px] mx-auto text-center relative overflow-hidden">
                    <div className="absolute top-0 left-0 w-full h-2 bg-green-500"></div>
                    
                    <div className="mb-10 flex justify-center">
                        <div className="w-24 h-24 bg-green-50 text-green-500 rounded-full flex items-center justify-center border-2 border-green-100 shadow-lg shadow-green-100 animate-bounce">
                            <svg className="w-12 h-12" fill="none" viewBox="0 0 24 24" strokeWidth="3" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    
                    <h1 className="text-4xl lg:text-5xl font-black text-[#0f172a] mb-6">Berhasil Diunggah!</h1>
                    <p className="text-lg text-[#64748b] leading-relaxed mb-12 max-w-lg mx-auto">
                        Bukti transfer Anda telah kami terima. Mohon tunggu verifikasi dari Admin. Untuk proses yang lebih cepat, silakan klik tombol konfirmasi WhatsApp di bawah ini. Poin Anda akan otomatis bertambah setelah transaksi disetujui.
                    </p>

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">
                        <a 
                            href={waUrl} 
                            target="_blank" 
                            className="bg-white border-2 border-black/5 p-8 rounded-[2rem] transition-all duration-300 hover:border-green-500 hover:-translate-y-2 hover:shadow-2xl group text-center"
                        >
                            <div className="w-12 h-12 bg-green-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-green-200">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </div>
                            <h3 className="text-[#0f172a] font-black text-lg mb-2">WhatsApp Admin</h3>
                            <p className="text-[#64748b] text-xs font-bold uppercase tracking-widest">Konfirmasi Cepat</p>
                        </a>

                        <a 
                            href={gformUrl} 
                            target="_blank" 
                            className="bg-white border-2 border-black/5 p-8 rounded-[2rem] transition-all duration-300 hover:border-[#2563eb] hover:-translate-y-2 hover:shadow-2xl group text-center"
                        >
                            <div className="w-12 h-12 bg-[#2563eb] text-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-blue-200">
                                <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 className="text-[#0f172a] font-black text-lg mb-2">Google Form</h3>
                            <p className="text-[#64748b] text-xs font-bold uppercase tracking-widest">Data Pelengkap</p>
                        </a>
                    </div>

                    <div className="space-y-4">
                        <Link href="/#leaderboard" className="btn btn-primary w-full py-5 rounded-2xl font-black uppercase tracking-[2px] text-xs shadow-xl shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all block text-center">
                            Selesai & Mulai Voting
                        </Link>
                        <Link href="/" className="text-[#64748b] font-black text-xs uppercase tracking-widest hover:text-[#2563eb] transition-colors block py-2">
                            Kembali ke Beranda
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
