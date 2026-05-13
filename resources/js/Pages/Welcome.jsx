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
            
            <section className="candidate-section">
                <div className="container mx-auto">
                    {/* Hero Content */}
                    <div className="text-center mb-16 pt-12">
                        <h1 className="hero-title text-4xl lg:text-6xl font-black mb-4">
                            Pilih <span className="text-[#2563eb]">Duta Favorit</span> Anda Sekarang
                        </h1>
                        <p className="hero-desc max-w-2xl mx-auto text-[#64748b]">
                            Gunakan poin Anda untuk mendukung kandidat terbaik mewakili UIN Madura tahun 2026.
                        </p>
                    </div>

                    {/* Stats Bar */}
                    <div className="stats-grid grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
                        <div className="stat-card bg-white p-6 rounded-2xl border border-black/5 text-center shadow-sm">
                            <span className="stat-value block text-2xl font-black">{putra.length + putri.length}</span>
                            <span className="stat-label text-[10px] font-bold text-[#64748b] uppercase">Total Kandidat</span>
                        </div>
                        <div className="stat-card bg-white p-6 rounded-2xl border border-black/5 text-center shadow-sm">
                            <span className="stat-value block text-2xl font-black">{totalVotes.toLocaleString()}</span>
                            <span className="stat-label text-[10px] font-bold text-[#64748b] uppercase">Total Suara</span>
                        </div>
                        <div className="stat-card bg-white p-6 rounded-2xl border border-black/5 text-center shadow-sm">
                            <span className="stat-value block text-2xl font-black">2026</span>
                            <span className="stat-label text-[10px] font-bold text-[#64748b] uppercase">Tahun</span>
                        </div>
                        <div className="stat-card bg-white p-6 rounded-2xl border border-black/5 text-center shadow-sm">
                            <span className="stat-value block text-2xl font-black">30</span>
                            <span className="stat-label text-[10px] font-bold text-[#64748b] uppercase">Hari Lagi</span>
                        </div>
                    </div>

                    {/* LEADERBOARD CONTENT */}
                    <div className="leaderboard-container bg-white rounded-[2.5rem] p-8 lg:p-12 border border-black/5 shadow-xl relative">
                        {/* Premium Segmented Switch */}
                        <div className="flex justify-center mb-16">
                            <div className="switch-container bg-[#f1f5f9] p-2 rounded-[32px] flex gap-2 border border-black/5 shadow-inner">
                                <button 
                                    onClick={() => setCategory('putra')}
                                    className={`switch-btn px-8 py-3 rounded-[24px] font-extrabold text-sm flex items-center gap-2 transition-all duration-300 ${category === 'putra' ? 'bg-[#2563eb] text-white shadow-lg scale-105' : 'text-[#64748b]'}`}
                                >
                                    <svg className="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Duta Putra
                                </button>
                                <button 
                                    onClick={() => setCategory('putri')}
                                    className={`switch-btn px-8 py-3 rounded-[24px] font-extrabold text-sm flex items-center gap-2 transition-all duration-300 ${category === 'putri' ? 'bg-[#2563eb] text-white shadow-lg scale-105' : 'text-[#64748b]'}`}
                                >
                                    <svg className="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Duta Putri
                                </button>
                            </div>
                        </div>

                        {/* Podium Section */}
                        <div className="podium-circular flex flex-col lg:flex-row justify-center items-center lg:items-end gap-12 lg:gap-12 mb-20">
                            {podiumOrder.map((candidate, idx) => {
                                if (!candidate) return null;
                                const rank = candidate.id === topThree[0]?.id ? 1 : (candidate.id === topThree[1]?.id ? 2 : 3);
                                const pct = totalCategoryVotes > 0 ? (candidate.total_votes / totalCategoryVotes) * 100 : 0;
                                
                                return (
                                    <div key={candidate.id} className={`circular-item text-center relative w-full max-w-[200px] ${rank === 1 ? 'lg:max-w-[240px] z-20 order-first lg:order-none' : ''}`}>
                                        <div className="avatar-wrapper relative p-2 rounded-full mb-6 group">
                                            {rank === 1 ? (
                                                <div className="absolute -top-[45px] left-1/2 -translate-x-1/2 -rotate-[5deg] z-10 drop-shadow-xl">
                                                    <svg width="70" height="70" viewBox="0 0 24 24" fill="none"><path d="M5 16L3 5L8.5 10L12 4L15.5 10L21 5L19 16H5ZM19 19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V18H19V19Z" fill="#FFD700" stroke="#B8860B" strokeWidth="0.5"/></svg>
                                                </div>
                                            ) : (
                                                <span className={`rank-tag absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full text-[10px] font-black uppercase whitespace-nowrap z-10 flex items-center gap-1 ${rank === 2 ? 'bg-[#C0C0C0] text-gray-800' : 'bg-[#CD7F32] text-white'}`}>
                                                    {rank === 2 ? (
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" fill="#C0C0C0" stroke="#808080" strokeWidth="0.5"/><text x="12" y="15.5" fontSize="10" fontWeight="900" fill="white" textAnchor="middle">2</text></svg>
                                                    ) : (
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" fill="#CD7F32" stroke="#8B4513" strokeWidth="0.5"/><text x="12" y="15.5" fontSize="10" fontWeight="900" fill="white" textAnchor="middle">3</text></svg>
                                                    )}
                                                    Juara {rank}
                                                </span>
                                            )}
                                            <div className={`aspect-square rounded-full p-2 ${rank === 1 ? 'bg-[#FFD700] shadow-[0_15px_50px_rgba(255,215,0,0.4)]' : rank === 2 ? 'bg-[#C0C0C0] shadow-[0_10px_30px_rgba(192,192,192,0.3)]' : 'bg-[#CD7F32] shadow-[0_10px_30px_rgba(205,127,50,0.3)]'}`}>
                                                <img 
                                                    className="w-full h-full rounded-full object-cover border-4 border-white" 
                                                    src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&size=400&background=1e293b&color=${rank === 1 ? 'F59E0B' : rank === 2 ? '94A3B8' : 'EA580C'}`} 
                                                    alt={candidate.name} 
                                                />
                                            </div>
                                        </div>
                                        <h3 className={`circular-name font-black mb-1 ${rank === 1 ? 'text-2xl' : 'text-lg'}`}>{candidate.name}</h3>
                                        <div className="flex flex-col items-center gap-0.5">
                                            <p className="font-black text-[#2563eb] text-lg leading-none">
                                                {candidate.total_votes.toLocaleString()} <span className="text-xs font-bold text-gray-500 uppercase">Suara</span>
                                            </p>
                                            <span className="text-xs font-extrabold text-[#64748b]">({pct.toFixed(1)}%)</span>
                                        </div>
                                        <button 
                                            onClick={() => openVoteModal(candidate)}
                                            className="btn btn-primary mt-4 py-2 px-6 text-[10px] font-black uppercase tracking-wider rounded-full shadow-lg hover:scale-105 transition-transform"
                                        >
                                            Vote Sekarang
                                        </button>
                                    </div>
                                );
                            })}
                        </div>

                        {/* Table Section */}
                        <div className="lb-table-wrapper border-t border-black/5 pt-8">
                            <table className="lb-table w-full border-separate border-spacing-y-3">
                                <thead className="hidden lg:table-header-group">
                                    <tr>
                                        <th className="text-left px-6 py-4 text-[10px] font-black text-[#64748b] uppercase tracking-[2px]">Rank</th>
                                        <th className="text-left px-6 py-4 text-[10px] font-black text-[#64748b] uppercase tracking-[2px]">Kandidat</th>
                                        <th className="text-right px-6 py-4 text-[10px] font-black text-[#64748b] uppercase tracking-[2px]">Votes</th>
                                        <th className="text-right px-6 py-4 text-[10px] font-black text-[#64748b] uppercase tracking-[2px]">Persen</th>
                                        <th className="text-right px-6 py-4 text-[10px] font-black text-[#64748b] uppercase tracking-[2px]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {remaining.map((candidate, idx) => {
                                        const pct = totalCategoryVotes > 0 ? (candidate.total_votes / totalCategoryVotes) * 100 : 0;
                                        return (
                                            <tr key={candidate.id} className="group">
                                                <td className="bg-[#f8fafc] group-hover:bg-[#ebf2ff] px-6 py-4 rounded-l-2xl transition-colors">
                                                    <span className="text-xl font-black text-black/10">#{idx + 4}</span>
                                                </td>
                                                <td className="bg-[#f8fafc] group-hover:bg-[#ebf2ff] px-6 py-4 transition-colors">
                                                    <div className="flex items-center gap-4">
                                                        <img 
                                                            className="w-11 h-11 rounded-full object-cover border-2 border-black/5" 
                                                            src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&size=200&background=1e293b&color=3b82f6`} 
                                                        />
                                                        <span className="font-bold text-[#0f172a]">{candidate.name}</span>
                                                    </div>
                                                </td>
                                                <td className="bg-[#f8fafc] group-hover:bg-[#ebf2ff] px-6 py-4 text-right transition-colors">
                                                    <span className="font-black text-lg">{candidate.total_votes.toLocaleString()}</span>
                                                </td>
                                                <td className="bg-[#f8fafc] group-hover:bg-[#ebf2ff] px-6 py-4 text-right transition-colors">
                                                    <span className="font-black text-[#2563eb]">{pct.toFixed(1)}%</span>
                                                </td>
                                                <td className="bg-[#f8fafc] group-hover:bg-[#ebf2ff] px-6 py-4 text-right rounded-r-2xl transition-colors">
                                                    <button 
                                                        onClick={() => openVoteModal(candidate)}
                                                        className="btn btn-primary py-2 px-4 text-[10px] font-black uppercase tracking-wider rounded-xl shadow-md"
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
