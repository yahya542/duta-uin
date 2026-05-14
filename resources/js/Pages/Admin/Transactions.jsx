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
            <div className="space-y-8">
                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.pending}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Disetujui</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.success}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Ditolak</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.rejected}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 16v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Masuk</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">Rp {stats.revenue.toLocaleString()}</h3>
                        </div>
                    </div>
                </div>

                <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-white">
                    <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <div>
                            <h2 className="text-xl font-black text-slate-900 mb-1">Transaction List</h2>
                            <p className="text-xs font-bold text-slate-400">Manage and verify user top-up points</p>
                        </div>
                        
                        <div className="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                            <div className="bg-slate-200/50 p-1 rounded-2xl flex gap-1 border border-white shadow-inner w-full sm:w-auto">
                                {[
                                    { id: 'all', label: 'All' },
                                    { id: 'pending', label: 'Pending' },
                                    { id: 'success', label: 'Finished' },
                                    { id: 'rejected', label: 'Rejected' }
                                ].map(f => (
                                    <button 
                                        key={f.id}
                                        onClick={() => setFilter(f.id)}
                                        className={`px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all whitespace-nowrap ${filter === f.id ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-900'}`}
                                    >
                                        {f.label}
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>

                    <div className="space-y-4 mb-10">
                        {paginatedTransactions.length > 0 ? paginatedTransactions.map((tx) => (
                            <div 
                                key={tx.id} 
                                className={`group bg-slate-50/50 p-6 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white flex flex-col lg:flex-row items-center gap-8 transition-all hover:shadow-xl hover:shadow-slate-200/20 ${tx.status === 'pending' ? 'ring-1 ring-blue-600/10' : ''}`}
                            >
                                <div className="flex flex-col items-center justify-center w-16 h-16 bg-white rounded-2xl shrink-0 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    <span className="text-lg font-black">{new Date(tx.created_at).getDate()}</span>
                                    <span className="text-[8px] font-black uppercase opacity-60">
                                        {new Date(tx.created_at).toLocaleString('id-ID', { month: 'short' })}
                                    </span>
                                </div>

                                <div className="flex-1 min-w-0 flex flex-col sm:flex-row items-center gap-8">
                                    <div className="flex items-center gap-4">
                                        <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(tx.vote?.voter_name || 'U')}&background=f1f5f9&color=64748b&bold=true`} className="w-10 h-10 rounded-xl" />
                                        <div>
                                            <h4 className="text-sm font-black text-slate-900 truncate">{tx.vote?.voter_name || 'Anonymous'}</h4>
                                            <span className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{tx.status}</span>
                                        </div>
                                    </div>

                                    <div className="hidden xl:block h-8 w-px bg-slate-100"></div>

                                    <div className="flex-1">
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Candidate</p>
                                        <p className="text-xs font-bold text-slate-900 truncate">{tx.candidate?.name || 'Points Only'}</p>
                                    </div>

                                    <div className="text-right shrink-0">
                                        <p className="text-sm font-black text-blue-600 mb-1">Rp {tx.nominal.toLocaleString()}</p>
                                        <a href={`/storage/${tx.proof_image}`} target="_blank" className="text-[9px] font-black uppercase tracking-[2px] text-slate-400 hover:text-blue-600 transition-colors">View Proof</a>
                                    </div>
                                </div>

                                <div className="flex items-center gap-2 shrink-0">
                                    {tx.status === 'pending' ? (
                                        <>
                                            <button 
                                                onClick={() => handleAction(tx.id, 'approve', tx.vote?.voter_name)}
                                                className="px-6 py-3 bg-blue-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-lg shadow-blue-500/20"
                                            >
                                                Approve
                                            </button>
                                            <button 
                                                onClick={() => handleAction(tx.id, 'reject', tx.vote?.voter_name)}
                                                className="p-3.5 bg-white text-slate-400 rounded-2xl hover:text-red-500 hover:bg-red-50 transition-all shadow-sm"
                                            >
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </>
                                    ) : (
                                        <div className="px-6 py-3 text-[10px] font-black text-slate-300 uppercase tracking-widest">Processed</div>
                                    )}
                                </div>
                            </div>
                        )) : (
                            <div className="bg-white p-20 rounded-[2.5rem] border border-dashed border-slate-200 text-center">
                                <div className="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg className="w-10 h-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 className="text-slate-900 font-black text-lg">No transactions found</h3>
                                <p className="text-slate-400 font-bold text-sm">Try adjusting your filters or search query.</p>
                            </div>
                        )}
                    </div>

                    <Pagination 
                        currentPage={currentPage}
                        totalPages={totalPages}
                        onPageChange={setCurrentPage}
                        totalItems={filteredTransactions.length}
                        itemsPerPage={itemsPerPage}
                    />
                </div>
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
