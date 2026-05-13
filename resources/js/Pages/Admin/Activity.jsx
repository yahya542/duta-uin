import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Activity({ transactions, votes, logs }) {
    return (
        <AdminLayout title="Laporan Aktivitas" kicker="Audit ekosistem">
            <div className="grid grid-cols-1 xl:grid-cols-2 gap-10 mb-10">
                {/* Transaction Activity */}
                <div className="bg-white border border-black/5 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                    <h2 className="text-lg font-black text-[#0f172a] mb-8 flex items-center gap-2">
                        <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                        Aktivitas Pembayaran
                    </h2>
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-separate border-spacing-y-2">
                            <thead>
                                <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                    <th className="px-4 pb-2">Waktu</th>
                                    <th className="px-4 pb-2">User</th>
                                    <th className="px-4 pb-2">Nominal</th>
                                    <th className="px-4 pb-2 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {transactions.length > 0 ? transactions.map((tx) => (
                                    <tr key={tx.id} className="group">
                                        <td className="bg-[#f8fafc] px-4 py-4 rounded-l-2xl group-hover:bg-blue-50 transition-colors text-[10px] font-bold text-[#64748b]">
                                            {new Date(tx.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' })}
                                        </td>
                                        <td className="bg-[#f8fafc] px-4 py-4 group-hover:bg-blue-50 transition-colors">
                                            <div className="flex items-center gap-3">
                                                <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(tx.vote?.voter_name || 'U')}&size=60&background=f1f5f9&color=64748b`} className="w-6 h-6 rounded-full" />
                                                <span className="text-xs font-black text-[#0f172a] truncate max-w-[100px]">{tx.vote?.voter_name || '-'}</span>
                                            </div>
                                        </td>
                                        <td className="bg-[#f8fafc] px-4 py-4 group-hover:bg-blue-50 transition-colors text-xs font-black text-[#0f172a]">
                                            Rp {tx.nominal.toLocaleString()}
                                        </td>
                                        <td className="bg-[#f8fafc] px-4 py-4 rounded-r-2xl text-right group-hover:bg-blue-50 transition-colors">
                                            <span className={`inline-block px-2 py-1 rounded-full text-[8px] font-black uppercase tracking-widest ${
                                                tx.status === 'success' ? 'bg-green-100 text-green-700' : 
                                                tx.status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                                            }`}>
                                                {tx.status}
                                            </span>
                                        </td>
                                    </tr>
                                )) : (
                                    <tr><td colSpan="4" className="text-center py-10 text-[#64748b] font-bold">Belum ada aktivitas.</td></tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Point Activity */}
                <div className="bg-white border border-black/5 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                    <h2 className="text-lg font-black text-[#0f172a] mb-8 flex items-center gap-2">
                        <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                        Aktivitas Poin
                    </h2>
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-separate border-spacing-y-2">
                            <thead>
                                <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                    <th className="px-4 pb-2">Waktu</th>
                                    <th className="px-4 pb-2">User</th>
                                    <th className="px-4 pb-2">Poin</th>
                                    <th className="px-4 pb-2 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {votes.length > 0 ? votes.map((vote) => (
                                    <tr key={vote.id} className="group">
                                        <td className="bg-[#f8fafc] px-4 py-4 rounded-l-2xl group-hover:bg-blue-50 transition-colors text-[10px] font-bold text-[#64748b]">
                                            {new Date(vote.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' })}
                                        </td>
                                        <td className="bg-[#f8fafc] px-4 py-4 group-hover:bg-blue-50 transition-colors">
                                            <div className="flex items-center gap-3">
                                                <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(vote.voter_name || 'U')}&size=60&background=f1f5f9&color=64748b`} className="w-6 h-6 rounded-full" />
                                                <span className="text-xs font-black text-[#0f172a] truncate max-w-[100px]">{vote.voter_name}</span>
                                            </div>
                                        </td>
                                        <td className="bg-[#f8fafc] px-4 py-4 group-hover:bg-blue-50 transition-colors text-xs font-black text-[#2563eb]">
                                            {vote.vote_point.toLocaleString()} PTS
                                        </td>
                                        <td className="bg-[#f8fafc] px-4 py-4 rounded-r-2xl text-right group-hover:bg-blue-50 transition-colors">
                                            <span className={`inline-block px-2 py-1 rounded-full text-[8px] font-black uppercase tracking-widest ${
                                                vote.status === 'success' ? 'bg-green-100 text-green-700' : 
                                                vote.status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                                            }`}>
                                                {vote.status}
                                            </span>
                                        </td>
                                    </tr>
                                )) : (
                                    <tr><td colSpan="4" className="text-center py-10 text-[#64748b] font-bold">Belum ada aktivitas.</td></tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {/* Leaderboard Log */}
            <div className="bg-white border border-black/5 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                <h2 className="text-lg font-black text-[#0f172a] mb-8 flex items-center gap-2">
                    <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                    Log Leaderboard Terbaru
                </h2>
                <div className="overflow-x-auto">
                    <table className="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                <th className="px-6 pb-2">Waktu</th>
                                <th className="px-6 pb-2">Kandidat</th>
                                <th className="px-6 pb-2">Total Voting</th>
                                <th className="px-6 pb-2">Persentase</th>
                                <th className="px-6 pb-2 text-right">Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            {logs.length > 0 ? logs.map((log) => (
                                <tr key={log.id} className="group">
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-l-2xl group-hover:bg-blue-50 transition-colors text-xs font-bold text-[#64748b]">
                                        {new Date(log.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <div className="flex items-center gap-3">
                                            <img 
                                                src={log.candidate?.photo ? `/storage/${log.candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(log.candidate?.name || 'C')}&size=60&background=f1f5f9&color=64748b`} 
                                                className="w-7 h-7 rounded-full border border-white shadow-sm" 
                                            />
                                            <strong className="text-sm font-black text-[#0f172a]">{log.candidate?.name || '-'}</strong>
                                        </div>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors text-sm font-black text-[#2563eb]">
                                        {log.total_votes.toLocaleString()}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <span className="bg-blue-50 text-[#2563eb] px-3 py-1 rounded-full text-[10px] font-black">{log.percentage.toFixed(1)}%</span>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-r-2xl text-right group-hover:bg-blue-50 transition-colors text-lg font-black text-[#0f172a]">
                                        #{log.ranking}
                                    </td>
                                </tr>
                            )) : (
                                <tr><td colSpan="5" className="text-center py-20 text-[#64748b] font-bold">Belum ada log leaderboard.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
