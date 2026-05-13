import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Dashboard({ stats, topCandidates, recentTransactions }) {
    return (
        <AdminLayout title="Ringkasan Ekosistem" kicker="Monitoring utama">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total Suara</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.total_votes.toLocaleString()}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Pendapatan</span>
                    <strong className="block text-3xl font-black text-green-600">Rp {stats.total_revenue.toLocaleString()}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Pending Verifikasi</span>
                    <strong className="block text-3xl font-black text-red-500">{stats.pending_transactions}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">User Voter</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.total_users.toLocaleString()}</strong>
                </div>
            </div>

            <div className="grid grid-cols-1 xl:grid-cols-[1fr_1.5fr] gap-10">
                {/* Top Candidates */}
                <div className="bg-white border border-black/5 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                    <h2 className="text-lg font-black text-[#0f172a] mb-8 flex items-center gap-2">
                        <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                        Kandidat Teratas
                    </h2>
                    <div className="space-y-4">
                        {topCandidates.length > 0 ? topCandidates.map((candidate) => (
                            <div key={candidate.id} className="flex items-center justify-between gap-4 p-5 bg-[#f8fafc] rounded-2xl group hover:bg-blue-50 transition-colors">
                                <div className="flex items-center gap-4 min-width-0">
                                    <img 
                                        src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&size=80&background=2563eb&color=ffffff`} 
                                        className="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md"
                                        alt={candidate.name} 
                                    />
                                    <div className="min-width-0">
                                        <strong className="block text-[#0f172a] font-black text-sm truncate">{candidate.name}</strong>
                                        <span className="inline-block px-3 py-1 bg-blue-100 text-[#2563eb] text-[9px] font-black uppercase tracking-widest rounded-full mt-1">
                                            {candidate.category}
                                        </span>
                                    </div>
                                </div>
                                <strong className="text-[#2563eb] text-lg font-black">{candidate.total_votes.toLocaleString()}</strong>
                            </div>
                        )) : (
                            <div className="text-center py-10 text-[#64748b] font-bold">Belum ada kandidat.</div>
                        )}
                    </div>
                </div>

                {/* Recent Transactions */}
                <div className="bg-white border border-black/5 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 overflow-hidden">
                    <h2 className="text-lg font-black text-[#0f172a] mb-8 flex items-center gap-2">
                        <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                        Transaksi Terbaru
                    </h2>
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                    <th className="px-6 pb-2">Voter</th>
                                    <th className="px-6 pb-2">Tujuan</th>
                                    <th className="px-6 pb-2">Nominal</th>
                                    <th className="px-6 pb-2 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {recentTransactions.length > 0 ? recentTransactions.map((tx) => (
                                    <tr key={tx.id} className="group">
                                        <td className="bg-[#f8fafc] px-6 py-5 rounded-l-2xl font-bold text-[#0f172a] group-hover:bg-gray-50 transition-colors">
                                            {tx.vote?.voter_name || '-'}
                                        </td>
                                        <td className="bg-[#f8fafc] px-6 py-5 font-bold text-[#64748b] group-hover:bg-gray-50 transition-colors">
                                            {tx.candidate?.name || 'Top Up Poin'}
                                        </td>
                                        <td className="bg-[#f8fafc] px-6 py-5 font-black text-[#0f172a] group-hover:bg-gray-50 transition-colors">
                                            Rp {tx.nominal.toLocaleString()}
                                        </td>
                                        <td className="bg-[#f8fafc] px-6 py-5 rounded-r-2xl text-right group-hover:bg-gray-50 transition-colors">
                                            <span className={`inline-block px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest ${
                                                tx.status === 'success' ? 'bg-green-100 text-green-700' : 
                                                tx.status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                                            }`}>
                                                {tx.status}
                                            </span>
                                        </td>
                                    </tr>
                                )) : (
                                    <tr><td colSpan="4" className="text-center py-10 text-[#64748b] font-bold">Belum ada transaksi.</td></tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
