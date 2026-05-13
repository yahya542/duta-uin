import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Leaderboard({ putra, putri, totalVotes }) {
    const leader = [...putra, ...putri].sort((a, b) => b.total_votes - a.total_votes)[0];

    const renderCategory = (title, items) => {
        const categoryTotal = items.reduce((sum, item) => sum + item.total_votes, 0);
        
        return (
            <div className="bg-white border border-black/5 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                <h2 className="text-lg font-black text-[#0f172a] mb-8 flex items-center gap-2">
                    <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                    {title}
                </h2>
                <div className="space-y-4">
                    {items.length > 0 ? items.map((candidate, index) => {
                        const percentage = categoryTotal > 0 ? (candidate.total_votes / categoryTotal) * 100 : 0;
                        return (
                            <div key={candidate.id} className="p-5 bg-[#f8fafc] rounded-2xl border border-black/5 group hover:bg-blue-50 transition-colors">
                                <div className="flex items-center justify-between gap-4 mb-4">
                                    <div className="flex items-center gap-3 min-width-0">
                                        <span className="w-8 h-8 rounded-full bg-[#2563eb] text-white flex items-center justify-center text-[10px] font-black shrink-0 shadow-lg shadow-blue-100">{index + 1}</span>
                                        <strong className="text-sm font-black text-[#0f172a] truncate">{candidate.name}</strong>
                                    </div>
                                    <strong className="text-[#2563eb] font-black text-sm">{candidate.total_votes.toLocaleString()}</strong>
                                </div>
                                <div className="h-2 bg-gray-200/50 rounded-full overflow-hidden">
                                    <div 
                                        className="h-full bg-[#2563eb] rounded-full transition-all duration-1000 ease-out" 
                                        style={{ width: `${percentage}%` }}
                                    ></div>
                                </div>
                                <span className="block mt-2 text-[10px] font-black text-[#64748b] uppercase tracking-wider">{percentage.toFixed(1)}% dari total kategori</span>
                            </div>
                        );
                    }) : (
                        <div className="text-center py-10 text-[#64748b] font-bold">Belum ada kandidat.</div>
                    )}
                </div>
            </div>
        );
    };

    return (
        <AdminLayout title="Leaderboard Voting" kicker="Performa kandidat">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total Voting</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{totalVotes.toLocaleString()}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Kandidat Putra</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{putra.length}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Kandidat Putri</span>
                    <strong className="block text-3xl font-black text-[#2563eb]">{putri.length}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Pemimpin Saat Ini</span>
                    <strong className="block text-sm font-black text-[#0f172a] truncate mt-2">{leader?.name || '-'}</strong>
                </div>
            </div>

            <div className="grid grid-cols-1 xl:grid-cols-2 gap-10">
                {renderCategory('Duta Putra', putra)}
                {renderCategory('Duta Putri', putri)}
            </div>
        </AdminLayout>
    );
}
