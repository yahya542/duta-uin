import React, { useState } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Transactions({ transactions, stats }) {
    const [filter, setFilter] = useState('all');

    const filteredTransactions = transactions.filter(tx => {
        if (filter === 'all') return true;
        return tx.status === filter;
    });

    const handleAction = (id, action) => {
        if (confirm(`Apakah Anda yakin ingin ${action === 'approve' ? 'menyetujui' : 'menolak'} pembayaran ini?`)) {
            useForm().post(`/admin/transactions/${id}/${action}`);
        }
    };

    return (
        <AdminLayout title="Verifikasi Pembayaran" kicker="Kelola top up poin">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Menunggu</span>
                    <strong className="block text-3xl font-black text-yellow-600">{stats.pending}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Disetujui</span>
                    <strong className="block text-3xl font-black text-green-600">{stats.success}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Ditolak</span>
                    <strong className="block text-3xl font-black text-red-500">{stats.rejected}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total Masuk</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">Rp {stats.revenue.toLocaleString()}</strong>
                </div>
            </div>

            <div className="bg-white border border-black/5 rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50">
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                    <h2 className="text-lg font-black text-[#0f172a] flex items-center gap-2">
                        <span className="w-2 h-6 bg-[#2563eb] rounded-full"></span>
                        Daftar Pembayaran
                    </h2>
                    
                    {/* Filter Tabs */}
                    <div className="bg-[#f1f5f9] p-1.5 rounded-2xl flex gap-1 border border-black/5 shadow-inner">
                        {['all', 'pending', 'success', 'rejected'].map(f => (
                            <button 
                                key={f}
                                onClick={() => setFilter(f)}
                                className={`px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all ${filter === f ? 'bg-white text-[#2563eb] shadow-sm' : 'text-[#64748b] hover:text-[#0f172a]'}`}
                            >
                                {f === 'all' ? 'Semua' : f}
                            </button>
                        ))}
                    </div>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                <th className="px-6 pb-2">Tanggal</th>
                                <th className="px-6 pb-2">Pengirim</th>
                                <th className="px-6 pb-2">Kandidat</th>
                                <th className="px-6 pb-2">Poin</th>
                                <th className="px-6 pb-2">Nominal</th>
                                <th className="px-6 pb-2">Bukti</th>
                                <th className="px-6 pb-2 text-center">Status</th>
                                <th className="px-6 pb-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filteredTransactions.length > 0 ? filteredTransactions.map((tx) => (
                                <tr key={tx.id} className="group">
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-l-2xl group-hover:bg-blue-50 transition-colors text-[11px] font-bold text-[#64748b]">
                                        {new Date(tx.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <div className="flex items-center gap-3">
                                            <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(tx.vote?.voter_name || 'U')}&size=80&background=f1f5f9&color=64748b`} className="w-8 h-8 rounded-full border-2 border-white shadow-sm" />
                                            <strong className="text-sm font-black text-[#0f172a]">{tx.vote?.voter_name || '-'}</strong>
                                        </div>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <div className="flex items-center gap-3">
                                            <img 
                                                src={tx.candidate?.photo ? `/storage/${tx.candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(tx.candidate?.name || 'C')}&size=80&background=f1f5f9&color=64748b`} 
                                                className="w-8 h-8 rounded-full border-2 border-white shadow-sm" 
                                            />
                                            <strong className="text-sm font-black text-[#64748b]">{tx.candidate?.name || 'Top Up Saja'}</strong>
                                        </div>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors text-sm font-black text-[#0f172a]">
                                        {(tx.vote?.vote_point || 0).toLocaleString()} PTS
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors text-sm font-black text-[#0f172a]">
                                        Rp {tx.nominal.toLocaleString()}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <a href={`/storage/${tx.proof_image}`} target="_blank" className="bg-white border border-black/5 px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest text-[#2563eb] hover:bg-blue-50 transition-all inline-block shadow-sm">Lihat Bukti</a>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 text-center group-hover:bg-blue-50 transition-colors">
                                        <span className={`inline-block px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest ${
                                            tx.status === 'success' ? 'bg-green-100 text-green-700' : 
                                            tx.status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                                        }`}>
                                            {tx.status}
                                        </span>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-r-2xl text-right group-hover:bg-blue-50 transition-colors">
                                        {tx.status === 'pending' ? (
                                            <div className="flex justify-end gap-2">
                                                <button 
                                                    onClick={() => handleAction(tx.id, 'approve')}
                                                    className="bg-green-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-md shadow-green-100"
                                                >
                                                    Terima
                                                </button>
                                                <button 
                                                    onClick={() => handleAction(tx.id, 'reject')}
                                                    className="bg-red-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-md shadow-red-100"
                                                >
                                                    Tolak
                                                </button>
                                            </div>
                                        ) : (
                                            <span className="text-[10px] font-black text-[#64748b] uppercase tracking-widest opacity-50">SELESAI</span>
                                        )}
                                    </td>
                                </tr>
                            )) : (
                                <tr><td colSpan="8" className="text-center py-20 text-[#64748b] font-bold">Belum ada data pembayaran.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
