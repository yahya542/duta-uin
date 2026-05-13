import React, { useState, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Pagination from '@/Components/Pagination';

export default function Transactions({ transactions, stats }) {
    const [filter, setFilter] = useState('all');
    const [search, setSearch] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [confirmingAction, setConfirmingAction] = useState(null); // { id, action, voter_name }
    const itemsPerPage = 10;

    const actionForm = useForm();

    // Reset page when search or filter changes
    useEffect(() => {
        setCurrentPage(1);
    }, [search, filter]);

    const filteredTransactions = transactions.filter(tx => {
        const matchesFilter = filter === 'all' || tx.status === filter;
        const matchesSearch = 
            (tx.vote?.voter_name || '').toLowerCase().includes(search.toLowerCase()) ||
            (tx.candidate?.name || '').toLowerCase().includes(search.toLowerCase());
        
        return matchesFilter && matchesSearch;
    });

    const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
    const paginatedTransactions = filteredTransactions.slice(
        (currentPage - 1) * itemsPerPage,
        currentPage * itemsPerPage
    );

    const handleAction = (id, action, voter_name) => {
        setConfirmingAction({ id, action, voter_name });
    };

    const submitAction = () => {
        if (!confirmingAction) return;
        
        actionForm.post(`/admin/transactions/${confirmingAction.id}/${confirmingAction.action}`, {
            onSuccess: () => setConfirmingAction(null)
        });
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
                    <h2 className="text-xl font-black text-[#0f172a] flex items-center gap-3">
                        <span className="w-2 h-7 bg-[#2563eb] rounded-full"></span>
                        Daftar Pembayaran
                    </h2>
                    
                    <div className="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                        {/* Search Input */}
                        <div className="relative group w-full sm:w-[280px]">
                            <input 
                                type="text" 
                                placeholder="Cari pengirim/kandidat..." 
                                className="w-full bg-[#f8fafc] border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold focus:bg-white focus:border-blue-500 focus:shadow-xl focus:shadow-blue-500/10 outline-none transition-all duration-300"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>

                        {/* Filter Tabs */}
                        <div className="bg-[#f1f5f9] p-1.5 rounded-2xl flex gap-1 border border-black/5 shadow-inner w-full sm:w-auto overflow-x-auto">
                            {['all', 'pending', 'success', 'rejected'].map(f => (
                                <button 
                                    key={f}
                                    onClick={() => setFilter(f)}
                                    className={`px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap ${filter === f ? 'bg-white text-[#2563eb] shadow-sm' : 'text-[#64748b] hover:text-[#0f172a]'}`}
                                >
                                    {f === 'all' ? 'Semua' : f}
                                </button>
                            ))}
                        </div>
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
                            {paginatedTransactions.length > 0 ? paginatedTransactions.map((tx) => (
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
                                                    onClick={() => handleAction(tx.id, 'approve', tx.vote?.voter_name)}
                                                    className="bg-green-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-md shadow-green-100"
                                                >
                                                    Terima
                                                </button>
                                                <button 
                                                    onClick={() => handleAction(tx.id, 'reject', tx.vote?.voter_name)}
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

                <Pagination 
                    currentPage={currentPage}
                    totalPages={totalPages}
                    onPageChange={setCurrentPage}
                    totalItems={filteredTransactions.length}
                    itemsPerPage={itemsPerPage}
                />
            </div>

            {/* CUSTOM ACTION MODAL */}
            {confirmingAction && (
                <div className="fixed inset-0 z-[5000] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md animate-in fade-in duration-300" onClick={() => setConfirmingAction(null)}>
                    <div 
                        className="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-[0_40px_100px_rgba(0,0,0,0.2)] relative animate-in zoom-in-95 duration-300"
                        onClick={e => e.stopPropagation()}
                    >
                        <div className="text-center">
                            <div className={`w-20 h-20 ${confirmingAction.action === 'approve' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'} rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner`}>
                                {confirmingAction.action === 'approve' ? (
                                    <svg className="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" /></svg>
                                ) : (
                                    <svg className="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                )}
                            </div>

                            <h3 className="text-2xl font-black text-[#0f172a] mb-4 tracking-tight">
                                {confirmingAction.action === 'approve' ? 'Setujui Pembayaran?' : 'Tolak Pembayaran?'}
                            </h3>
                            <p className="text-[#64748b] font-bold text-sm leading-relaxed mb-10 px-4">
                                Anda akan {confirmingAction.action === 'approve' ? 'menyetujui' : 'menolak'} pembayaran dari <span className="text-[#0f172a] font-black underline decoration-blue-500/30 underline-offset-4">{confirmingAction.voter_name}</span>. Aksi ini akan mempengaruhi saldo poin pengguna.
                            </p>

                            <div className="flex flex-col gap-3">
                                <button 
                                    onClick={submitAction}
                                    disabled={actionForm.processing}
                                    className={`w-full py-4 rounded-2xl text-[11px] font-black uppercase tracking-[2px] text-white shadow-xl transition-all hover:scale-[1.02] active:scale-95 disabled:opacity-50 ${confirmingAction.action === 'approve' ? 'bg-green-600 shadow-green-200' : 'bg-red-500 shadow-red-200'}`}
                                >
                                    {actionForm.processing ? 'Memproses...' : `Ya, ${confirmingAction.action === 'approve' ? 'Setujui' : 'Tolak'} Sekarang`}
                                </button>
                                <button 
                                    onClick={() => setConfirmingAction(null)}
                                    className="w-full py-4 rounded-2xl text-[11px] font-black uppercase tracking-[2px] text-[#64748b] hover:bg-slate-50 transition-all"
                                >
                                    Batalkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
