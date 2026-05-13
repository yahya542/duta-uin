import React, { useState, useRef } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function TopUp() {
    const { auth } = usePage().props;
    const paymentRef = useRef(null);
    const [preview, setPreview] = useState(null);
    const [selectedPkg, setSelectedPkg] = useState(null);

    const { data, setData, post, processing, errors, reset } = useForm({
        nominal: '',
        vote_point: '',
        voter_name: '',
        proof_image: null,
    });

    const packages = [
        { name: 'Starter', desc: 'Dukungan awal untuk kandidat.', price: 5000, points: 1, features: ['1x Poin Suara'] },
        { name: 'Lite', desc: 'Pilihan praktis untuk supporter.', price: 10000, points: 2, features: ['2x Poin Suara'] },
        { name: 'Popular', desc: 'Dukungan yang signifikan.', price: 25000, points: 5, features: ['5x Poin Suara'] },
        { name: 'Pro', desc: 'Dukungan kuat untuk menang.', price: 50000, points: 10, features: ['10x Poin Suara'] },
        { name: 'Ultra', desc: 'Bawa kandidatmu ke puncak.', price: 100000, points: 20, features: ['20x Poin Suara'] },
        { name: 'Whale', desc: 'Dukungan maksimal tanpa batas.', price: 250000, points: 50, features: ['50x Poin Suara'] }
    ];

    const handleSelectPackage = (pkg) => {
        setSelectedPkg(pkg);
        setData({
            ...data,
            nominal: pkg.price,
            vote_point: pkg.points
        });
        paymentRef.current?.scrollIntoView({ behavior: 'smooth' });
    };

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setData('proof_image', file);
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => setPreview(e.target.result);
            reader.readAsDataURL(file);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post('/topup', {
            onSuccess: () => {
                reset();
                setPreview(null);
                setSelectedPkg(null);
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Top Up Poin Voting" />
            
            <section className="topup-pricing-section">
                {/* Blue Header Area */}
                <div className="bg-gradient-to-br from-[#2563eb] to-[#1e40af] py-24 text-center text-white">
                    <div className="container mx-auto px-6">
                        <h1 className="text-4xl lg:text-6xl font-black mb-6 tracking-tight">Dukung Kandidat Favoritmu</h1>
                        <p className="text-xl opacity-90 max-w-2xl mx-auto leading-relaxed">
                            Pilih paket poin voting di bawah ini untuk membantu kandidat jagoanmu memenangkan Duta Kampus UIN Madura 2026.
                        </p>
                    </div>
                </div>

                <div className="container mx-auto px-6 -mt-32">
                    {/* Pricing Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-24">
                        {packages.map((pkg) => (
                            <div 
                                key={pkg.name}
                                className={`bg-white border rounded-3xl p-10 flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group ${selectedPkg?.name === pkg.name ? 'border-[#2563eb] ring-2 ring-blue-100 shadow-xl' : 'border-black/5 shadow-sm'}`}
                            >
                                <div className="text-center mb-8">
                                    <h3 className="text-xl font-black text-[#0f172a] mb-2">{pkg.name}</h3>
                                    <p className="text-xs text-[#64748b] leading-relaxed">{pkg.desc}</p>
                                </div>
                                <div className="text-center mb-10">
                                    <div className="flex items-baseline justify-center gap-1">
                                        <span className="text-base font-bold text-[#0f172a]">Rp</span>
                                        <span className="text-5xl font-black text-[#0f172a]">{Math.floor(pkg.price / 1000)}k</span>
                                    </div>
                                    <p className="text-[10px] font-black text-[#64748b] uppercase mt-2 tracking-widest">{pkg.points} Voting Points</p>
                                </div>
                                <button 
                                    onClick={() => handleSelectPackage(pkg)}
                                    className={`w-full py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] transition-all ${selectedPkg?.name === pkg.name ? 'bg-[#2563eb] text-white shadow-lg' : 'bg-[#f8fafc] text-[#0f172a] border border-black/5 hover:bg-blue-50 hover:text-[#2563eb]'}`}
                                >
                                    {selectedPkg?.name === pkg.name ? 'Paket Terpilih' : 'Pilih Paket'}
                                </button>
                                <div className="mt-10 pt-8 border-t border-black/5">
                                    <ul className="space-y-3">
                                        {pkg.features.map((f, i) => (
                                            <li key={i} className="flex items-center gap-3 text-xs font-black text-[#0f172a]">
                                                <div className="w-5 h-5 bg-[#fbbf24] rounded-full flex items-center justify-center shadow-md">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                </div>
                                                {f}
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Payment Confirmation Section */}
                    <div ref={paymentRef} className="max-w-[1000px] mx-auto mb-32 scroll-mt-24">
                        <div className="bg-white border-2 border-black/5 rounded-[2.5rem] p-8 lg:p-16 shadow-2xl relative overflow-hidden">
                            <div className="absolute top-0 left-0 w-full h-2 bg-[#2563eb]"></div>
                            
                            <form onSubmit={submit} className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                                {/* Info Side */}
                                <div>
                                    <h2 className="text-3xl font-black mb-6">Konfirmasi <span className="text-[#2563eb]">Pembayaran</span></h2>
                                    <p className="text-[#64748b] leading-relaxed mb-10">
                                        Silakan scan kode QRIS di bawah ini atau transfer ke rekening yang tertera. Setelah transfer, upload bukti pembayaran Anda.
                                    </p>

                                    <div className="bg-[#f8fafc] border border-black/5 rounded-3xl p-8 flex flex-col sm:flex-row items-center gap-8">
                                        <div className="bg-white p-3 rounded-2xl border-2 border-black/5 shadow-lg shrink-0">
                                            <img src="/qris/qris-dana.png" className="w-32 h-32 rounded-lg" alt="QRIS" />
                                        </div>
                                        <div>
                                            <span className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block mb-2">Scan & Bayar Via</span>
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" className="h-5 mb-4" />
                                            <div className="bg-white border border-black/5 px-4 py-2 rounded-xl text-xs font-black">Rek: 6281932551947</div>
                                        </div>
                                    </div>
                                </div>

                                {/* Form Side */}
                                <div className="bg-[#f8fafc] border border-black/5 rounded-[2rem] p-8 lg:p-10 space-y-8">
                                    <div className="summary-box border-b-2 border-dashed border-black/10 pb-6 space-y-3">
                                        <div className="flex justify-between items-center text-sm">
                                            <span className="text-[#64748b] font-bold">Paket Dipilih</span>
                                            <span className="text-[#2563eb] font-black">{selectedPkg ? selectedPkg.name : 'Pilih Paket Di Atas'}</span>
                                        </div>
                                        <div className="flex justify-between items-center text-sm">
                                            <span className="text-[#64748b] font-bold">Total Poin</span>
                                            <span className="text-[#0f172a] font-black">{selectedPkg ? selectedPkg.points + ' PTS' : '-'}</span>
                                        </div>
                                        <div className="flex justify-between items-center pt-4">
                                            <span className="text-lg font-black text-[#0f172a]">Total Bayar</span>
                                            <span className="text-3xl font-black text-[#0f172a]">Rp {selectedPkg ? selectedPkg.price.toLocaleString() : '0'}</span>
                                        </div>
                                    </div>

                                    <div className="space-y-6">
                                        <div>
                                            <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block mb-2">Nama Pengirim</label>
                                            <input 
                                                type="text" 
                                                className="w-full bg-white border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                                placeholder="Nama sesuai bukti transfer"
                                                value={data.voter_name}
                                                onChange={e => setData('voter_name', e.target.value)}
                                                required
                                            />
                                            {errors.voter_name && <p className="text-red-500 text-xs mt-1">{errors.voter_name}</p>}
                                        </div>

                                        <div>
                                            <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block mb-2">Bukti Transfer</label>
                                            <div className="relative group">
                                                <input 
                                                    type="file" 
                                                    className="absolute inset-0 opacity-0 cursor-pointer z-10"
                                                    onChange={handleFileChange}
                                                    required
                                                />
                                                <div className={`bg-white border-2 border-dashed border-black/10 rounded-2xl p-6 flex flex-col items-center gap-4 transition-all ${preview ? 'border-[#2563eb] bg-blue-50/30' : 'group-hover:border-blue-300'}`}>
                                                    <div className="flex items-center gap-4 w-full">
                                                        <div className="w-10 h-10 bg-blue-50 text-[#2563eb] rounded-full flex items-center justify-center shrink-0">
                                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 4v16m8-8H4" /></svg>
                                                        </div>
                                                        <span className="text-xs font-bold text-[#64748b] truncate">
                                                            {data.proof_image ? data.proof_image.name : 'Pilih file foto bukti transfer...'}
                                                        </span>
                                                    </div>
                                                    {preview && (
                                                        <img src={preview} className="w-full max-h-48 object-contain rounded-xl border border-black/5" />
                                                    )}
                                                </div>
                                            </div>
                                            {errors.proof_image && <p className="text-red-500 text-xs mt-1">{errors.proof_image}</p>}
                                        </div>

                                        <button 
                                            type="submit" 
                                            disabled={processing || !selectedPkg}
                                            className="w-full bg-[#2563eb] text-white py-5 rounded-2xl font-black uppercase tracking-[2px] text-xs shadow-xl shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50 disabled:grayscale disabled:hover:scale-100"
                                        >
                                            {processing ? 'Sedang Diproses...' : 'Konfirmasi Top Up'}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </AuthenticatedLayout>
    );
}
