import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Tutorial() {
    return (
        <AuthenticatedLayout>
            <Head title="Panduan Voting" />
            
            <section className="candidate-section">
                <div className="container mx-auto max-w-[900px] pt-12">
                    <div className="text-center mb-16">
                        <h1 className="hero-title text-4xl lg:text-6xl font-black mb-4">
                            Panduan <span className="text-[#2563eb]">Voting</span>
                        </h1>
                        <p className="hero-desc text-[#64748b]">
                            Ikuti langkah-langkah di bawah ini untuk memberikan dukungan kepada kandidat favorit Anda.
                        </p>
                    </div>

                    <div className="leaderboard-container bg-white rounded-[2.5rem] p-10 lg:p-16 border border-black/5 shadow-xl">
                        {/* Step 1 */}
                        <div className="flex gap-8 mb-16 items-start">
                            <div className="flex-shrink-0 w-[60px] h-[60px] bg-[#2563eb] rounded-[1.5rem] flex items-center justify-center text-2xl font-black text-white shadow-lg">1</div>
                            <div>
                                <h3 className="text-2xl font-extrabold mb-3 text-[#0f172a]">Buat Akun / Masuk</h3>
                                <p className="text-[#64748b] leading-relaxed text-lg">
                                    Klik tombol <strong>Daftar</strong> jika Anda belum memiliki akun, atau <strong>Login</strong> jika sudah pernah mendaftar. Pastikan data diri Anda valid agar proses verifikasi berjalan lancar.
                                </p>
                            </div>
                        </div>

                        {/* Step 2 */}
                        <div className="flex gap-8 mb-16 items-start">
                            <div className="flex-shrink-0 w-[60px] h-[60px] bg-[#f8fafc] border border-black/5 rounded-[1.5rem] flex items-center justify-center text-2xl font-black text-[#64748b]">2</div>
                            <div>
                                <h3 className="text-2xl font-extrabold mb-3 text-[#0f172a]">Pilih Kandidat Favorit</h3>
                                <p className="text-[#64748b] leading-relaxed text-lg">
                                    Jelajahi halaman utama untuk melihat daftar kandidat <strong>Putra</strong> dan <strong>Putri</strong>. Anda bisa melihat profil dan perolehan suara sementara mereka di Leaderboard.
                                </p>
                            </div>
                        </div>

                        {/* Step 3 */}
                        <div className="flex gap-8 mb-16 items-start">
                            <div className="flex-shrink-0 w-[60px] h-[60px] bg-[#f8fafc] border border-black/5 rounded-[1.5rem] flex items-center justify-center text-2xl font-black text-[#64748b]">3</div>
                            <div>
                                <h3 className="text-2xl font-extrabold mb-3 text-[#0f172a]">Lakukan Top-Up Poin</h3>
                                <p className="text-[#64748b] leading-relaxed text-lg">
                                    Klik tombol <strong>Vote Sekarang</strong> pada kandidat pilihan. Anda akan diarahkan ke halaman pembayaran. Pilih paket poin yang diinginkan, lakukan pembayaran melalui <strong>QRIS</strong> atau <strong>Transfer Bank</strong>, lalu unggah bukti pembayaran.
                                </p>
                            </div>
                        </div>

                        {/* Step 4 */}
                        <div className="flex gap-8 items-start">
                            <div className="flex-shrink-0 w-[60px] h-[60px] bg-[#f8fafc] border border-black/5 rounded-[1.5rem] flex items-center justify-center text-2xl font-black text-[#64748b]">4</div>
                            <div>
                                <h3 className="text-2xl font-extrabold mb-3 text-[#0f172a]">Tunggu Verifikasi Admin</h3>
                                <p className="text-[#64748b] leading-relaxed text-lg">
                                    Setelah mengunggah bukti, Admin akan memverifikasi transaksi Anda. Jika disetujui, poin voting Anda akan otomatis masuk ke kandidat tersebut dan leaderboard akan diperbarui secara real-time.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-[#eff6ff] border border-[#2563eb]/20 rounded-[1.5rem] p-8 mt-12 flex gap-6 items-center">
                        <div className="w-12 h-12 bg-[#2563eb] rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        </div>
                        <p className="text-[#0f172a] font-bold text-sm leading-relaxed m-0">
                            <span className="text-[#2563eb] font-black uppercase block mb-1">Penting:</span>
                            Setiap transaksi top up yang Anda lakukan memerlukan verifikasi manual oleh Admin. Mohon tunggu persetujuan dari Admin (maksimal 1x24 jam) sebelum poin voting masuk ke akun Anda.
                        </p>
                    </div>

                    <div className="text-center mt-20">
                        <Link href="/" className="btn btn-primary px-10 py-4 font-black uppercase tracking-widest rounded-2xl shadow-xl hover:scale-105 transition-transform inline-block">
                            Kembali ke Beranda
                        </Link>
                    </div>
                </div>
            </section>
        </AuthenticatedLayout>
    );
}
