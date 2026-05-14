import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Dashboard({ stats, topCandidates, recentTransactions }) {
    return (
        <AdminLayout title="Ringkasan Ekosistem" kicker="Global Monitoring">
            <div className="space-y-12">
                {/* Stats Grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {[
                        { label: 'Total Votes', value: stats.total_votes.toLocaleString(), icon: (
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        ), color: 'text-blue-600', bg: 'bg-blue-50' },
                        { label: 'Revenue', value: `Rp ${stats.total_revenue.toLocaleString()}`, icon: (
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 16v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2m5-13V3m0 0L9 5m3-2l3 2" /></svg>
                        ), color: 'text-orange-500', bg: 'bg-orange-50' },
                        { label: 'Pending', value: stats.pending_transactions, icon: (
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        ), color: 'text-red-500', bg: 'bg-red-50' },
                        { label: 'Active Users', value: stats.total_users.toLocaleString(), icon: (
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        ), color: 'text-teal-500', bg: 'bg-teal-50' },
                    ].map((s, idx) => (
                        <div key={idx} className="bg-white p-5 rounded-[2rem] shadow-sm border border-white flex items-center gap-4 group hover:shadow-lg hover:shadow-slate-200/50 transition-all duration-500">
                            <div className={`w-12 h-12 ${s.bg} ${s.color} rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform`}>
                                {s.icon}
                            </div>
                            <div>
                                <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{s.label}</p>
                                <h3 className="text-lg font-black text-slate-900 leading-none">{s.value}</h3>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="grid grid-cols-1 xl:grid-cols-[1.2fr_1fr] gap-8 items-start">
                    {/* Recent Transactions */}
                    <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-white">
                        <div className="flex justify-between items-center mb-10">
                            <h2 className="text-lg font-black text-slate-900 tracking-tight">Recent Activity</h2>
                            <Link href="/admin/transactions" className="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">View All</Link>
                        </div>
                        <div className="space-y-4">
                            {recentTransactions.length > 0 ? recentTransactions.map((tx) => (
                                <div key={tx.id} className="flex items-center justify-between p-5 bg-slate-50/50 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white transition-all group">
                                    <div className="flex items-center gap-4">
                                        <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(tx.vote?.voter_name || 'U')}&background=f1f5f9&color=64748b&bold=true`} className="w-10 h-10 rounded-xl" />
                                        <div>
                                            <p className="text-sm font-black text-slate-900 leading-none mb-1">{tx.vote?.voter_name || 'User'}</p>
                                            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{tx.candidate?.name || 'Top Up'}</p>
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <p className="text-sm font-black text-blue-600 mb-1">Rp {tx.nominal.toLocaleString()}</p>
                                        <span className={`text-[8px] font-black uppercase tracking-widest px-2 py-1 rounded-md ${tx.status === 'success' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600'}`}>
                                            {tx.status}
                                        </span>
                                    </div>
                                </div>
                            )) : (
                                <p className="text-center py-10 text-slate-400 font-bold italic">No recent activity</p>
                            )}
                        </div>
                    </div>

                    {/* Top Candidates */}
                    <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-white">
                        <h2 className="text-lg font-black text-slate-900 tracking-tight mb-10">Top Rank Candidates</h2>
                        <div className="space-y-6">
                            {topCandidates.length > 0 ? topCandidates.map((c, idx) => (
                                <div key={c.id} className="flex items-center gap-6">
                                    <div className="relative shrink-0">
                                        <img 
                                            src={c.photo ? `/storage/${c.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(c.name)}&background=2563eb&color=fff&bold=true`} 
                                            className="w-16 h-16 rounded-[2rem] object-cover border-4 border-slate-50 shadow-sm"
                                        />
                                        <div className={`absolute -top-2 -left-2 w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black text-white shadow-lg ${idx === 0 ? 'bg-orange-500' : idx === 1 ? 'bg-slate-400' : 'bg-amber-600'}`}>
                                            #{idx + 1}
                                        </div>
                                    </div>
                                    <div className="flex-1 min-w-0">
                                        <div className="flex justify-between items-end mb-2">
                                            <p className="text-sm font-black text-slate-900 truncate tracking-tight">{c.name}</p>
                                            <p className="text-xs font-black text-blue-600 leading-none">{c.total_votes.toLocaleString()}</p>
                                        </div>
                                        <div className="w-full h-2 bg-slate-50 rounded-full overflow-hidden">
                                            <div 
                                                className={`h-full rounded-full transition-all duration-1000 ${idx === 0 ? 'bg-orange-500' : 'bg-blue-600'}`} 
                                                style={{ width: `${(c.total_votes / topCandidates[0].total_votes) * 100}%` }}
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            )) : (
                                <p className="text-center py-10 text-slate-400 font-bold italic">No candidates available</p>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
