import React, { useState, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Pagination from '@/Components/Pagination';

export default function Transactions({ transactions, stats }) {
    const [filter, setFilter] = useState('all');
    const [search, setSearch] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [confirmingAction, setConfirmingAction] = useState(null); // { id, action, voter_name }
    const [selectedProof, setSelectedProof] = useState(null);
    const [selectedTransaction, setSelectedTransaction] = useState(null);
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

    const handleExport = (format) => {
        const dataToExport = filteredTransactions.map(tx => ({
            Tanggal: new Date(tx.created_at).toLocaleDateString('id-ID'),
            Pemilih: tx.vote?.voter_name || 'Anonymous',
            Kandidat: tx.candidate?.name || 'Points Only',
            Nominal: tx.nominal,
            Status: tx.status.toUpperCase()
        }));

        if (format === 'csv' || format === 'excel') {
            const headers = Object.keys(dataToExport[0]).join(',');
            const rows = dataToExport.map(row => Object.values(row).join(',')).join('\n');
            const csvContent = "data:text/csv;charset=utf-8," + headers + '\n' + rows;
            const link = document.createElement("a");
            link.setAttribute("href", encodeURI(csvContent));
            link.setAttribute("download", `Laporan_Transaksi_${new Date().getTime()}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else if (format === 'pdf') {
            window.print();
        }
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

                <div className="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    {/* Header: Filters & Search */}
                    <div className="flex flex-col lg:flex-row justify-between items-center gap-6 mb-6">
                        <div className="flex items-center gap-3">
                            <div className="bg-white p-1.5 rounded-xl border border-slate-100 flex gap-1 shadow-sm">
                                {[
                                    { id: 'all', label: 'SEMUA' },
                                    { id: 'pending', label: 'MENUNGGU' },
                                    { id: 'success', label: 'SELESAI' }
                                ].map(f => (
                                    <button 
                                        key={f.id}
                                        onClick={() => setFilter(f.id)}
                                        className={`px-6 py-2.5 rounded-lg text-[11px] font-black tracking-widest transition-all ${filter === f.id ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-slate-600'}`}
                                    >
                                        {f.label}
                                    </button>
                                ))}
                            </div>

                            {/* Export Dropdown */}
                            <div className="relative group">
                                <button className="w-12 h-12 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 shadow-sm transition-all group-hover:border-blue-100">
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                </button>
                                <div className="absolute left-0 top-full mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 overflow-hidden translate-y-2 group-hover:translate-y-0">
                                    <button onClick={() => handleExport('pdf')} className="w-full px-6 py-4 text-left text-[10px] font-black text-slate-600 hover:bg-slate-50 hover:text-blue-600 flex items-center gap-3 transition-colors border-b border-slate-50">
                                        <div className="w-2 h-2 rounded-full bg-rose-500"></div> CETAK PDF
                                    </button>
                                    <button onClick={() => handleExport('excel')} className="w-full px-6 py-4 text-left text-[10px] font-black text-slate-600 hover:bg-slate-50 hover:text-emerald-600 flex items-center gap-3 transition-colors">
                                        <div className="w-2 h-2 rounded-full bg-emerald-500"></div> EXCEL (CSV)
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div className="relative w-full lg:w-[400px]">
                            <input 
                                type="text" 
                                placeholder="Cari ID atau Nama Klien..." 
                                className="w-full bg-[#f8fafc] border border-slate-100 rounded-xl pl-12 pr-4 py-4 text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-200 outline-none transition-all"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>

                    {/* Tip Banner */}
                    <div className="bg-[#f0f7ff] border-y border-slate-100 px-6 py-3 flex items-center gap-3 mb-8">
                        <div className="w-5 h-5 rounded-full border-2 border-blue-600 flex items-center justify-center text-blue-600">
                            <span className="text-[10px] font-black">i</span>
                        </div>
                        <span className="text-[10px] font-black text-blue-600 uppercase tracking-widest">TIP: KLIK BARIS UNTUK DETAIL TRANSAKSI LENGKAP</span>
                    </div>

                    {/* Table Headers */}
                    <div className="grid grid-cols-12 gap-8 px-6 mb-6 text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">
                        <div className="col-span-4">DATA TRANSAKSI</div>
                        <div className="col-span-2 text-center">LAYANAN</div>
                        <div className="col-span-2 text-center">NOMINAL</div>
                        <div className="col-span-2 text-center">BUKTI</div>
                        <div className="col-span-2 text-right">AKSI</div>
                    </div>

                    {/* Rows */}
                    <div className="divide-y divide-slate-50">
                        {paginatedTransactions.length > 0 ? paginatedTransactions.map((tx) => (
                            <div 
                                key={tx.id} 
                                onClick={() => setSelectedTransaction(tx)}
                                className="group grid grid-cols-1 lg:grid-cols-12 gap-8 px-6 py-6 items-center hover:bg-slate-50/50 transition-colors cursor-pointer"
                            >
                                {/* Data Transaksi */}
                                <div className="col-span-4 flex items-center gap-6">
                                    <div className="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 shrink-0">
                                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    </div>
                                    <div className="min-w-0">
                                        <h4 className="text-base font-black text-slate-800 leading-tight">{tx.vote?.voter_name || 'Anonymous'}</h4>
                                    </div>
                                </div>

                                {/* Layanan */}
                                <div className="col-span-2 text-center">
                                    <div className="inline-block px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-black rounded-lg mb-1">
                                        Duta UIN
                                    </div>
                                    <p className="text-[10px] font-bold text-slate-400">
                                        {new Date(tx.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                                    </p>
                                </div>

                                {/* Nominal */}
                                <div className="col-span-2 text-center">
                                    <span className="text-base font-black text-blue-700 tracking-tight">+Rp {tx.nominal.toLocaleString()}</span>
                                </div>

                                {/* Bukti (New Separate Column) */}
                                <div className="col-span-2 flex justify-center">
                                    <div 
                                        onClick={(e) => { e.stopPropagation(); setSelectedProof(`/storage/${tx.proof_image}`); }}
                                        className="group/proof relative w-16 h-10 bg-slate-100 rounded-xl overflow-hidden cursor-pointer border border-slate-200 transition-all hover:scale-110 active:scale-95 shadow-sm"
                                    >
                                        <img src={`/storage/${tx.proof_image}`} className="w-full h-full object-cover opacity-60 group-hover/proof:opacity-100 transition-opacity" />
                                        <div className="absolute inset-0 flex items-center justify-center opacity-0 group-hover/proof:opacity-100 bg-black/20 transition-opacity">
                                            <svg className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </div>
                                    </div>
                                </div>

                                {/* Aksi */}
                                <div className="col-span-2 flex justify-end gap-3" onClick={e => e.stopPropagation()}>
                                    {tx.status === 'pending' ? (
                                        <>
                                            <button 
                                                onClick={() => handleAction(tx.id, 'approve', tx.vote?.voter_name)}
                                                className="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-emerald-500 hover:border-emerald-100 shadow-sm transition-all"
                                            >
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                            <button 
                                                onClick={() => handleAction(tx.id, 'reject', tx.vote?.voter_name)}
                                                className="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-500 hover:border-rose-100 shadow-sm transition-all"
                                            >
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </>
                                    ) : (
                                        <span className={`text-[10px] font-black uppercase tracking-widest ${tx.status === 'success' ? 'text-emerald-500' : 'text-rose-500'}`}>
                                            {tx.status === 'success' ? 'Selesai' : 'Ditolak'}
                                        </span>
                                    )}
                                </div>
                            </div>
                        )) : (
                            <div className="py-20 text-center">
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
            {/* TRANSACTION DETAIL MODAL */}
            {selectedTransaction && (
                <div className="fixed inset-0 z-[5500] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md animate-in fade-in duration-300" onClick={() => setSelectedTransaction(null)}>
                    <div 
                        className="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300 flex flex-col md:flex-row"
                        onClick={e => e.stopPropagation()}
                    >
                        {/* Image Preview Side */}
                        <div className="w-full md:w-5/12 bg-slate-50 border-r border-slate-100 p-8 flex flex-col items-center justify-center">
                            <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Bukti Transfer</p>
                            <div 
                                onClick={() => setSelectedProof(`/storage/${selectedTransaction.proof_image}`)}
                                className="w-full aspect-[3/4] bg-white rounded-3xl overflow-hidden shadow-lg border-4 border-white cursor-zoom-in group/modal-img relative"
                            >
                                <img src={`/storage/${selectedTransaction.proof_image}`} className="w-full h-full object-cover transition-transform duration-500 group-hover/modal-img:scale-110" />
                                <div className="absolute inset-0 bg-blue-600/0 group-hover/modal-img:bg-blue-600/20 transition-all flex items-center justify-center opacity-0 group-hover/modal-img:opacity-100">
                                    <svg className="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                            </div>
                            <p className="text-[10px] font-bold text-slate-400 mt-6 text-center italic">Klik gambar untuk memperbesar</p>
                        </div>

                        {/* Content Side */}
                        <div className="flex-1 p-10 flex flex-col">
                            <div className="flex justify-between items-start mb-10">
                                <div>
                                    <h3 className="text-2xl font-black text-slate-900 tracking-tight leading-none mb-2">{selectedTransaction.vote?.voter_name || 'Anonymous'}</h3>
                                    <span className="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest">
                                        MIFA-{selectedTransaction.id.toString().padStart(3, '0')}
                                    </span>
                                </div>
                                <button onClick={() => setSelectedTransaction(null)} className="w-10 h-10 bg-slate-50 text-slate-400 hover:text-rose-500 rounded-xl flex items-center justify-center transition-colors">
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <div className="space-y-6 flex-1">
                                <div className="grid grid-cols-2 gap-6">
                                    <div>
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</p>
                                        <span className={`text-xs font-black uppercase tracking-widest ${selectedTransaction.status === 'success' ? 'text-emerald-500' : selectedTransaction.status === 'pending' ? 'text-amber-500' : 'text-rose-500'}`}>
                                            {selectedTransaction.status}
                                        </span>
                                    </div>
                                    <div>
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kandidat</p>
                                        <p className="text-xs font-bold text-slate-700 truncate">{selectedTransaction.candidate?.name || 'Top-up Poin'}</p>
                                    </div>
                                    <div>
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Waktu</p>
                                        <p className="text-xs font-bold text-slate-700">{new Date(selectedTransaction.created_at).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' })} WIB</p>
                                    </div>
                                    <div>
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal</p>
                                        <p className="text-xs font-bold text-slate-700">{new Date(selectedTransaction.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
                                    </div>
                                </div>

                                <div className="pt-6 border-t border-slate-100">
                                    <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Nominal</p>
                                    <p className="text-3xl font-black text-blue-600 tracking-tighter">Rp {selectedTransaction.nominal.toLocaleString()}</p>
                                </div>
                            </div>

                            <div className="mt-10 flex gap-3">
                                {selectedTransaction.status === 'pending' && (
                                    <>
                                        <button 
                                            onClick={() => { handleAction(selectedTransaction.id, 'approve', selectedTransaction.vote?.voter_name); setSelectedTransaction(null); }}
                                            className="flex-1 py-4 bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all"
                                        >
                                            Setujui Sekarang
                                        </button>
                                        <button 
                                            onClick={() => { handleAction(selectedTransaction.id, 'reject', selectedTransaction.vote?.voter_name); setSelectedTransaction(null); }}
                                            className="px-6 py-4 bg-rose-50 text-rose-500 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all"
                                        >
                                            Tolak
                                        </button>
                                    </>
                                )}
                                {selectedTransaction.status !== 'pending' && (
                                    <button 
                                        onClick={() => setSelectedTransaction(null)}
                                        className="w-full py-4 bg-slate-900 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all"
                                    >
                                        Tutup Detail
                                    </button>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* PROOF PREVIEW MODAL */}
            {selectedProof && (
                <div className="fixed inset-0 z-[6000] flex items-center justify-center p-6 sm:p-10 bg-slate-900/90 backdrop-blur-xl animate-in fade-in duration-300" onClick={() => setSelectedProof(null)}>
                    <button 
                        onClick={() => setSelectedProof(null)}
                        className="absolute top-8 right-8 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-2xl flex items-center justify-center backdrop-blur-md transition-all hover:rotate-90"
                    >
                        <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    
                    <div 
                        className="relative max-w-5xl w-full h-full flex items-center justify-center animate-in zoom-in-95 duration-300"
                        onClick={e => e.stopPropagation()}
                    >
                        <img 
                            src={selectedProof} 
                            className="max-w-full max-h-full object-contain rounded-3xl shadow-2xl border-8 border-white/5"
                            alt="Bukti Transfer"
                        />
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
