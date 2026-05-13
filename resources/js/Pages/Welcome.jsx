import React, { useState } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Welcome({ putra, putri, totalVotes }) {
    const { auth } = usePage().props;
    const [category, setCategory] = useState('putra');
    const [isVoteModalOpen, setIsVoteModalOpen] = useState(false);
    const [selectedCandidate, setSelectedCandidate] = useState(null);
    const [votePoints, setVotePoints] = useState(1);

    const candidates = category === 'putra' ? putra : putri;
    const totalCategoryVotes = candidates.reduce((sum, c) => sum + c.total_votes, 0);

    const topThree = candidates.slice(0, 3);
    const remaining = candidates.slice(3);

    // Podium order: 2nd, 1st, 3rd
    const podiumOrder = [topThree[1], topThree[0], topThree[2]];

    const openVoteModal = (candidate) => {
        if (!auth.user) {
            window.location.href = '/login';
            return;
        }
        setSelectedCandidate(candidate);
        setVotePoints(1);
        setIsVoteModalOpen(true);
    };

    return (
        <AuthenticatedLayout>
            <Head title="Pilih Duta Favorit Anda Sekarang" />
            
            <section className="pt-16 pb-24 px-6">
                <div className="max-w-7xl mx-auto">
                    {/* Hero Content */}
                    <div className="text-center mb-24">
                        <h1 className="text-5xl lg:text-7xl font-extrabold text-slate-900 mb-8 tracking-tight leading-[1.1]">
                            Pilih <span className="text-blue-600">Duta Favorit</span> <br className="hidden lg:block" /> Anda Sekarang
                        </h1>
                        <p className="max-w-2xl mx-auto text-slate-500 text-lg lg:text-xl font-medium leading-relaxed opacity-80">
                            Gunakan poin Anda untuk mendukung kandidat terbaik mewakili UIN Madura tahun 2026. Dukung sekarang sebelum voting ditutup!
                        </p>
                    </div>

                    {/* Stats Bar */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-24">
                        {[
                            { label: 'Total Kandidat', value: putra.length + putri.length, icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' },
                            { label: 'Total Suara', value: totalVotes.toLocaleString(), icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' },
                            { label: 'Tahun Pelaksanaan', value: '2026', icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z' },
                            { label: 'Sisa Waktu', value: '30 Hari', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' }
                        ].map((stat, i) => (
                            <div key={i} className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/20 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 group">
                                <div className="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                    <svg className="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d={stat.icon} /></svg>
                                </div>
                                <span className="block text-4xl font-black text-slate-900 mb-1 tracking-tighter">{stat.value}</span>
                                <span className="text-[11px] font-bold text-slate-400 uppercase tracking-[2px]">{stat.label}</span>
                            </div>
                        ))}
                    </div>

                    {/* LEADERBOARD CONTENT */}
                    <div id="leaderboard" className="bg-white rounded-[3.5rem] p-8 lg:p-20 border border-slate-100 shadow-2xl relative overflow-hidden">
                        {/* Premium Segmented Switch */}
                        <div className="flex justify-center mb-24 relative z-40">
                            <div className="bg-slate-100/80 backdrop-blur-md p-2 rounded-[32px] flex gap-2 border border-slate-200 shadow-inner">
                                <button 
                                    onClick={() => setCategory('putra')}
                                    className={`px-12 py-4 rounded-[24px] font-black text-xs uppercase tracking-widest flex items-center gap-3 transition-all duration-500 ${category === 'putra' ? 'bg-blue-600 text-white shadow-2xl shadow-blue-500/40 scale-105' : 'text-slate-500 hover:text-slate-900'}`}
                                >
                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Duta Putra
                                </button>
                                <button 
                                    onClick={() => setCategory('putri')}
                                    className={`px-12 py-4 rounded-[24px] font-black text-xs uppercase tracking-widest flex items-center gap-3 transition-all duration-500 ${category === 'putri' ? 'bg-blue-600 text-white shadow-2xl shadow-blue-500/40 scale-105' : 'text-slate-500 hover:text-slate-900'}`}
                                >
                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Duta Putri
                                </button>
                            </div>
                        </div>

                        {/* Podium Section */}
                        <div className="flex flex-col lg:flex-row justify-center items-center lg:items-end gap-16 lg:gap-8 mb-32 relative">
                            {podiumOrder.map((candidate, idx) => {
                                if (!candidate) return null;
                                const rank = candidate.id === topThree[0]?.id ? 1 : (candidate.id === topThree[1]?.id ? 2 : 3);
                                const pct = totalCategoryVotes > 0 ? (candidate.total_votes / totalCategoryVotes) * 100 : 0;
                                
                                return (
                                    <div key={candidate.id} className={`text-center relative w-full max-w-[260px] transition-all duration-700 ${rank === 1 ? 'lg:max-w-[340px] z-20 lg:-translate-y-6' : 'z-10'}`}>
                                        <div className="relative p-2.5 rounded-full mb-12 group">
                                            {rank === 1 ? (
                                                <div className="absolute -top-16 left-1/2 -translate-x-1/2 -rotate-12 z-30 drop-shadow-[0_20px_20px_rgba(255,215,0,0.5)] animate-bounce duration-[3000ms]">
                                                    <svg width="100" height="100" viewBox="0 0 24 24" fill="none"><path d="M5 16L3 5L8.5 10L12 4L15.5 10L21 5L19 16H5ZM19 19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V18H19V19Z" fill="#FFD700" stroke="#B8860B" strokeWidth="0.5"/></svg>
                                                </div>
                                            ) : (
                                                <span className={`absolute -top-6 left-1/2 -translate-x-1/2 px-6 py-2 rounded-full text-[11px] font-black uppercase tracking-[2px] whitespace-nowrap z-30 flex items-center gap-2 shadow-2xl border-4 border-white ${rank === 2 ? 'bg-slate-400 text-white' : 'bg-orange-600 text-white'}`}>
                                                    RANK #{rank}
                                                </span>
                                            )}
                                            <div className={`aspect-square rounded-full p-4 transition-transform duration-500 group-hover:scale-[1.02] ${rank === 1 ? 'bg-gradient-to-tr from-yellow-400 via-yellow-100 to-yellow-600 shadow-[0_30px_90px_rgba(255,215,0,0.4)]' : rank === 2 ? 'bg-gradient-to-tr from-slate-400 via-slate-100 to-slate-600 shadow-[0_25px_60px_rgba(148,163,184,0.2)]' : 'bg-gradient-to-tr from-orange-500 via-orange-100 to-orange-800 shadow-[0_25px_60px_rgba(234,88,12,0.2)]'}`}>
                                                <img 
                                                    className="w-full h-full rounded-full object-cover border-[8px] border-white shadow-inner bg-slate-50" 
                                                    src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&size=400&background=f8fafc&color=2563eb&bold=true`} 
                                                    alt={candidate.name} 
                                                />
                                            </div>
                                        </div>
                                        <h3 className={`font-black text-slate-900 mb-3 tracking-tight ${rank === 1 ? 'text-4xl' : 'text-2xl'}`}>{candidate.name}</h3>
                                        <div className="flex flex-col items-center gap-3">
                                            <div className="flex items-baseline gap-1.5">
                                                <span className="text-3xl font-black text-blue-600 tracking-tighter">{candidate.total_votes.toLocaleString()}</span>
                                                <span className="text-xs font-bold text-slate-400 uppercase tracking-widest">Suara</span>
                                            </div>
                                            <div className="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                                <div className="h-full bg-blue-600 rounded-full transition-all duration-[1500ms]" style={{ width: `${pct}%` }}></div>
                                            </div>
                                            <span className="text-[12px] font-black text-slate-500 uppercase tracking-tighter bg-slate-50 px-3 py-1 rounded-full">{pct.toFixed(1)}% Kontribusi</span>
                                        </div>
                                        <button 
                                            onClick={() => openVoteModal(candidate)}
                                            className="mt-10 py-4 px-12 bg-blue-600 text-white text-[11px] font-black uppercase tracking-[2px] rounded-2xl shadow-2xl shadow-blue-500/30 hover:bg-blue-700 hover:-translate-y-1.5 active:translate-y-0 transition-all duration-300"
                                        >
                                            VOTE KANDIDAT
                                        </button>
                                    </div>
                                );
                            })}
                        </div>

                        {/* Table Section */}
                        <div className="border-t border-slate-100 pt-20 overflow-x-auto">
                            <table className="w-full border-separate border-spacing-y-5 min-w-[800px]">
                                <thead>
                                    <tr className="text-[11px] font-black text-slate-400 uppercase tracking-[3px]">
                                        <th className="text-left px-10 pb-6">Peringkat</th>
                                        <th className="text-left px-10 pb-6">Informasi Kandidat</th>
                                        <th className="text-right px-10 pb-6">Total Perolehan</th>
                                        <th className="text-right px-10 pb-6">Statistik %</th>
                                        <th className="text-right px-10 pb-6">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {remaining.map((candidate, idx) => {
                                        const pct = totalCategoryVotes > 0 ? (candidate.total_votes / totalCategoryVotes) * 100 : 0;
                                        return (
                                            <tr key={candidate.id} className="group">
                                                <td className="bg-slate-50/50 group-hover:bg-blue-50 px-10 py-6 rounded-l-[2rem] transition-all duration-500">
                                                    <span className="text-3xl font-black text-slate-200 group-hover:text-blue-100 italic transition-colors">#{idx + 4}</span>
                                                </td>
                                                <td className="bg-slate-50/50 group-hover:bg-blue-50 px-10 py-6 transition-all duration-500">
                                                    <div className="flex items-center gap-6">
                                                        <img 
                                                            className="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-xl group-hover:scale-110 transition-all duration-500" 
                                                            src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&size=200&background=f1f5f9&color=2563eb&bold=true`} 
                                                        />
                                                        <span className="font-black text-slate-900 text-xl tracking-tight group-hover:text-blue-600 transition-colors">{candidate.name}</span>
                                                    </div>
                                                </td>
                                                <td className="bg-slate-50/50 group-hover:bg-blue-50 px-10 py-6 text-right transition-all duration-500">
                                                    <span className="font-black text-slate-900 text-2xl tracking-tighter">{candidate.total_votes.toLocaleString()}</span>
                                                </td>
                                                <td className="bg-slate-50/50 group-hover:bg-blue-50 px-10 py-6 text-right transition-all duration-500">
                                                    <span className="bg-white text-blue-600 px-5 py-2 rounded-2xl text-xs font-black shadow-lg shadow-blue-500/5 border border-slate-100">{pct.toFixed(1)}%</span>
                                                </td>
                                                <td className="bg-slate-50/50 group-hover:bg-blue-50 px-10 py-6 text-right rounded-r-[2rem] transition-all duration-500">
                                                    <button 
                                                        onClick={() => openVoteModal(candidate)}
                                                        className="py-4 px-10 bg-white border border-slate-200 text-[10px] font-black uppercase tracking-[2px] rounded-2xl shadow-sm group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all active:scale-95"
                                                    >
                                                        Vote
                                                    </button>
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {/* VOTE MODAL */}
            {isVoteModalOpen && selectedCandidate && (
                <div className="vote-modal-backdrop is-open flex items-center justify-center fixed inset-0 z-[3000] bg-black/40 backdrop-blur-xl p-6" onClick={() => setIsVoteModalOpen(false)}>
                    <div className="vote-modal-card bg-white w-full max-w-[440px] p-8 rounded-[2rem] shadow-2xl relative" onClick={e => e.stopPropagation()}>
                        <div className="flex justify-between items-start mb-6">
                            <div>
                                <span className="text-[11px] font-black text-[#2563eb] uppercase tracking-widest block mb-1">Konfirmasi Voting</span>
                                <h2 className="text-2xl font-black text-[#0f172a] leading-tight">{selectedCandidate.name}</h2>
                            </div>
                            <button onClick={() => setIsVoteModalOpen(false)} className="w-9 h-9 flex items-center justify-center rounded-xl bg-[#f8fafc] border border-black/5 text-[#64748b] hover:text-[#2563eb] transition-colors">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        {auth.user.points <= 0 ? (
                            <div className="space-y-6">
                                <div className="bg-red-50 border border-red-100 p-4 rounded-2xl">
                                    <strong className="text-red-500 block mb-1 font-bold">Poin Anda belum tersedia.</strong>
                                    <p className="text-sm text-red-400">Silakan lakukan top-up terlebih dahulu untuk memberikan dukungan.</p>
                                </div>
                                <Link href="/topup" className="btn btn-primary w-full py-4 font-black uppercase tracking-widest rounded-2xl shadow-lg">Top Up Sekarang</Link>
                            </div>
                        ) : (
                            <form action="/votes" method="POST" className="space-y-6">
                                <input type="hidden" name="candidate_id" value={selectedCandidate.id} />
                                
                                <div className="flex justify-between items-center bg-blue-50/50 border border-blue-100/50 p-4 rounded-2xl">
                                    <span className="text-[10px] font-black text-[#64748b] uppercase tracking-wider">Saldo Poin</span>
                                    <strong className="text-[#2563eb] text-lg font-black">{auth.user.points.toLocaleString()} PTS</strong>
                                </div>

                                <div>
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-wider block mb-2">Jumlah poin yang digunakan</label>
                                    <input 
                                        type="number" 
                                        className="form-input text-center text-2xl font-black py-4" 
                                        value={votePoints}
                                        min="1"
                                        max={auth.user.points}
                                        onChange={(e) => setVotePoints(Math.min(Math.max(1, parseInt(e.target.value) || 0), auth.user.points))}
                                    />
                                    <div className="grid grid-cols-4 gap-2 mt-4">
                                        {[1, 5, 10, 'max'].map(val => (
                                            <button 
                                                key={val} 
                                                type="button" 
                                                onClick={() => setVotePoints(val === 'max' ? auth.user.points : val)}
                                                className={`py-3 rounded-xl text-[10px] font-black border transition-all ${votePoints === (val === 'max' ? auth.user.points : val) ? 'bg-[#2563eb] text-white border-[#2563eb]' : 'bg-[#f8fafc] text-[#0f172a] border-black/5'}`}
                                            >
                                                {val === 'max' ? 'Semua' : val}
                                            </button>
                                        ))}
                                    </div>
                                </div>

                                <p className="text-[13px] text-[#64748b] leading-relaxed">
                                    Poin yang dipilih akan langsung dikurangi dari saldo Anda dan ditambahkan ke total voting kandidat.
                                </p>

                                <button className="btn btn-primary w-full py-4 font-black uppercase tracking-widest rounded-2xl shadow-xl hover:scale-[1.02] transition-transform">
                                    Gunakan {votePoints} Poin
                                </button>
                            </form>
                        )}
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
