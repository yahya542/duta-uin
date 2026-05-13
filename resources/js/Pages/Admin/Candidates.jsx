import React, { useState, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Pagination from '@/Components/Pagination';

export default function Candidates({ candidates, stats }) {
    const [isAddModalOpen, setIsAddModalOpen] = useState(false);
    const [isEditModalOpen, setIsEditModalOpen] = useState(false);
    const [selectedCandidate, setSelectedCandidate] = useState(null);
    const [voters, setVoters] = useState([]);
    const [loadingVoters, setLoadingVoters] = useState(false);
    const [addPreview, setAddPreview] = useState(null);
    const [editPreview, setEditPreview] = useState(null);
    const [search, setSearch] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 10;

    // Reset page when search changes
    useEffect(() => {
        setCurrentPage(1);
    }, [search]);

    const filteredCandidates = candidates.filter(candidate => {
        const query = search.toLowerCase();
        return (
            candidate.name.toLowerCase().includes(query) ||
            candidate.category.toLowerCase().includes(query)
        );
    });

    const totalPages = Math.ceil(filteredCandidates.length / itemsPerPage);
    const paginatedCandidates = filteredCandidates.slice(
        (currentPage - 1) * itemsPerPage,
        currentPage * itemsPerPage
    );

    const addForm = useForm({
        name: '',
        category: 'putra',
        photo: null,
        description: '',
    });

    const editForm = useForm({
        _method: 'PUT',
        name: '',
        category: 'putra',
        total_votes: 0,
        description: '',
        photo: null,
    });

    const openEditModal = (candidate) => {
        setSelectedCandidate(candidate);
        editForm.setData({
            _method: 'PUT',
            name: candidate.name,
            category: candidate.category,
            total_votes: candidate.total_votes,
            description: candidate.description || '',
            photo: null,
        });
        setEditPreview(null);
        setIsEditModalOpen(true);
        fetchVoters(candidate.id);
    };

    const fetchVoters = async (id) => {
        setLoadingVoters(true);
        try {
            const res = await fetch(`/admin/api/candidate-voters/${id}`);
            const data = await res.json();
            setVoters(data);
        } catch (e) {
            console.error(e);
        } finally {
            setLoadingVoters(false);
        }
    };

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/candidates', {
            onSuccess: () => {
                setIsAddModalOpen(false);
                addForm.reset();
                setAddPreview(null);
            },
        });
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.post(`/admin/candidates/${selectedCandidate.id}`, {
            onSuccess: () => {
                setIsEditModalOpen(false);
                editForm.reset();
                setEditPreview(null);
            },
        });
    };

    const handleDelete = (id) => {
        if (confirm('Hapus kandidat ini secara permanen? Seluruh data voting terkait juga akan hilang.')) {
            useForm().delete(`/admin/candidates/${id}`);
        }
    };

    const handleModalDelete = () => {
        if (confirm('Hapus kandidat ini secara permanen?')) {
            editForm.delete(`/admin/candidates/${selectedCandidate.id}`, {
                onSuccess: () => setIsEditModalOpen(false),
            });
        }
    };

    return (
        <AdminLayout title="Kelola Kandidat" kicker="Data peserta voting">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total Kandidat</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.total}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Duta Putra</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.putra}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Duta Putri</span>
                    <strong className="block text-3xl font-black text-[#2563eb]">{stats.putri}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total Suara</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.votes.toLocaleString()}</strong>
                </div>
            </div>

            <div className="bg-white border border-black/5 rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50">
                <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                    <h2 className="text-xl font-black text-[#0f172a] flex items-center gap-3">
                        <span className="w-2 h-7 bg-[#2563eb] rounded-full"></span>
                        Daftar Kandidat
                    </h2>

                    <div className="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        {/* Search Input */}
                        <div className="relative group w-full sm:w-[280px]">
                            <input 
                                type="text" 
                                placeholder="Cari kandidat..." 
                                className="w-full bg-[#f8fafc] border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold focus:bg-white focus:border-blue-500 focus:shadow-xl focus:shadow-blue-500/10 outline-none transition-all duration-300"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>

                        <button 
                            onClick={() => setIsAddModalOpen(true)}
                            className="bg-[#2563eb] text-white px-6 py-4 lg:py-3 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all w-full sm:w-auto"
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M12 4v16m8-8H4" /></svg>
                            Tambah Kandidat
                        </button>
                    </div>
                </div>

                <div className="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 mb-8 flex items-center gap-4 text-[#2563eb]">
                    <div className="w-8 h-8 bg-[#2563eb] text-white rounded-full flex items-center justify-center shrink-0 shadow-md">
                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p className="text-xs font-black uppercase tracking-wider">Klik pada baris data untuk melihat detail kandidat secara lengkap.</p>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                <th className="px-6 pb-2">Foto</th>
                                <th className="px-6 pb-2">Nama Lengkap</th>
                                <th className="px-6 pb-2">Kategori</th>
                                <th className="px-6 pb-2">Perolehan Suara</th>
                                <th className="px-6 pb-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {paginatedCandidates.length > 0 ? paginatedCandidates.map((candidate) => (
                                <tr 
                                    key={candidate.id} 
                                    className="group cursor-pointer"
                                    onClick={() => openEditModal(candidate)}
                                >
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-l-2xl group-hover:bg-blue-50 transition-colors">
                                        <img 
                                            src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&size=100&background=2563eb&color=ffffff`} 
                                            className="w-11 h-11 rounded-full object-cover border-2 border-white shadow-sm"
                                        />
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <strong className="text-[#0f172a] font-black text-sm">{candidate.name}</strong>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <span className="inline-block px-3 py-1 bg-blue-100 text-[#2563eb] text-[9px] font-black uppercase tracking-widest rounded-full">
                                            {candidate.category}
                                        </span>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <strong className="text-[#2563eb] font-black">{candidate.total_votes.toLocaleString()}</strong>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-r-2xl text-right group-hover:bg-blue-50 transition-colors">
                                        <div className="flex justify-end gap-2" onClick={e => e.stopPropagation()}>
                                            <button 
                                                onClick={() => openEditModal(candidate)}
                                                className="w-9 h-9 bg-white border border-black/5 rounded-xl flex items-center justify-center text-[#64748b] hover:text-[#2563eb] shadow-sm transition-all"
                                            >
                                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </button>
                                            <button 
                                                onClick={() => handleDelete(candidate.id)}
                                                className="w-9 h-9 bg-white border border-black/5 rounded-xl flex items-center justify-center text-[#64748b] hover:text-red-500 shadow-sm transition-all"
                                            >
                                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            )) : (
                                <tr><td colSpan="5" className="text-center py-20 text-[#64748b] font-bold">Belum ada kandidat.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <Pagination 
                    currentPage={currentPage}
                    totalPages={totalPages}
                    onPageChange={setCurrentPage}
                    totalItems={filteredCandidates.length}
                    itemsPerPage={itemsPerPage}
                />
            </div>

            {/* MODAL TAMBAH */}
            {isAddModalOpen && (
                <div className="fixed inset-0 z-[3000] flex items-center justify-center p-6" onClick={() => setIsAddModalOpen(false)}>
                    <div className="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                    <div className="bg-white w-full max-w-[500px] rounded-[2.5rem] p-10 shadow-2xl relative z-10 animate-in zoom-in-95 duration-200" onClick={e => e.stopPropagation()}>
                        <div className="flex justify-between items-start mb-8">
                            <div>
                                <span className="text-[10px] font-black text-[#2563eb] uppercase tracking-widest block mb-1">Input Peserta</span>
                                <h2 className="text-2xl font-black text-[#0f172a]">Tambah Kandidat</h2>
                            </div>
                            <button onClick={() => setIsAddModalOpen(false)} className="w-10 h-10 bg-[#f8fafc] border border-black/5 rounded-2xl flex items-center justify-center text-[#64748b] hover:text-red-500 transition-colors">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <form onSubmit={handleAddSubmit} className="space-y-6">
                            <div className="flex flex-col items-center gap-4 mb-8">
                                <div className="relative group">
                                    <div className="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl group-hover:border-blue-100 transition-all">
                                        <img 
                                            src={addPreview || 'https://ui-avatars.com/api/?name=C&size=200&background=f1f5f9&color=64748b'} 
                                            className="w-full h-full object-cover"
                                        />
                                    </div>
                                    <label className="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-xl cursor-pointer hover:scale-110 active:scale-90 transition-all border-4 border-white">
                                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        <input 
                                            type="file" 
                                            className="hidden"
                                            accept="image/*"
                                            onChange={e => {
                                                const file = e.target.files[0];
                                                addForm.setData('photo', file);
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => setAddPreview(e.target.result);
                                                    reader.readAsDataURL(file);
                                                }
                                            }}
                                        />
                                    </label>
                                </div>
                                <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Klik ikon kamera untuk upload foto</p>
                            </div>

                            <div className="space-y-2">
                                <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                    value={addForm.data.name}
                                    onChange={e => addForm.setData('name', e.target.value)}
                                    required
                                />
                            </div>
                            <div className="space-y-2">
                                <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Deskripsi</label>
                                <textarea 
                                    className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                    rows="3"
                                    value={addForm.data.description}
                                    onChange={e => addForm.setData('description', e.target.value)}
                                ></textarea>
                            </div>
                            <button 
                                type="submit" 
                                disabled={addForm.processing}
                                className="w-full bg-[#2563eb] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-blue-100 hover:scale-[1.02] active:scale-95 transition-all"
                            >
                                {addForm.processing ? 'Menyimpan...' : 'Simpan Kandidat'}
                            </button>
                        </form>
                    </div>
                </div>
            )}

            {/* MODAL EDIT */}
            {isEditModalOpen && (
                <div className="fixed inset-0 z-[3000] flex items-center justify-center p-6" onClick={() => setIsEditModalOpen(false)}>
                    <div className="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                    <div className="bg-white w-full max-w-[500px] rounded-[2.5rem] p-10 shadow-2xl relative z-10 animate-in zoom-in-95 duration-200 h-[90vh] overflow-y-auto" onClick={e => e.stopPropagation()}>
                        <div className="flex justify-between items-start mb-8 sticky top-0 bg-white pt-2 z-20">
                            <div>
                                <span className="text-[10px] font-black text-[#2563eb] uppercase tracking-widest block mb-1">Detail & Edit</span>
                                <h2 className="text-2xl font-black text-[#0f172a]">{selectedCandidate.name}</h2>
                            </div>
                            <button onClick={() => setIsEditModalOpen(false)} className="w-10 h-10 bg-[#f8fafc] border border-black/5 rounded-2xl flex items-center justify-center text-[#64748b] hover:text-red-500 transition-colors">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <form onSubmit={handleEditSubmit} className="space-y-6">
                            <div className="flex flex-col items-center gap-4 mb-8">
                                <div className="relative group">
                                    <div className="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl group-hover:border-blue-100 transition-all">
                                        <img 
                                            src={editPreview || (selectedCandidate.photo ? `/storage/${selectedCandidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(selectedCandidate.name)}&size=200&background=2563eb&color=ffffff`)} 
                                            className="w-full h-full object-cover" 
                                        />
                                    </div>
                                    <label className="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-xl cursor-pointer hover:scale-110 active:scale-90 transition-all border-4 border-white">
                                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        <input 
                                            type="file" 
                                            className="hidden"
                                            accept="image/*"
                                            onChange={e => {
                                                const file = e.target.files[0];
                                                editForm.setData('photo', file);
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => setEditPreview(e.target.result);
                                                    reader.readAsDataURL(file);
                                                }
                                            }}
                                        />
                                    </label>
                                </div>
                                <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Klik ikon kamera untuk ganti foto</p>
                            </div>

                            <div className="space-y-2">
                                <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                    value={editForm.data.name}
                                    onChange={e => editForm.setData('name', e.target.value)}
                                    required
                                />
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div className="space-y-2">
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Kategori</label>
                                    <select 
                                        className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all appearance-none"
                                        value={editForm.data.category}
                                        onChange={e => editForm.setData('category', e.target.value)}
                                    >
                                        <option value="putra">Duta Putra</option>
                                        <option value="putri">Duta Putri</option>
                                    </select>
                                </div>
                                <div className="space-y-2">
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Total Suara</label>
                                    <input 
                                        type="number" 
                                        className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                        value={editForm.data.total_votes}
                                        onChange={e => editForm.setData('total_votes', e.target.value)}
                                    />
                                </div>
                            </div>
                            <div className="space-y-2">
                                <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Deskripsi</label>
                                <textarea 
                                    className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                    rows="3"
                                    value={editForm.data.description}
                                    onChange={e => editForm.setData('description', e.target.value)}
                                ></textarea>
                            </div>

                            {/* VOTERS LIST SECTION */}
                            <div className="pt-8 border-t border-black/5 mt-8">
                                <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest flex justify-between items-center mb-6">
                                    Daftar Pendukung
                                    <span className="bg-blue-50 text-[#2563eb] px-3 py-1 rounded-full">{voters.length} Voter</span>
                                </label>
                                <div className="space-y-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                    {loadingVoters ? (
                                        <div className="text-center py-6 text-[#64748b] text-xs font-bold">Memuat data pendukung...</div>
                                    ) : voters.length > 0 ? voters.map((v, i) => (
                                        <div key={i} className="flex items-center justify-between gap-4 p-4 bg-[#f8fafc] rounded-2xl border border-black/5">
                                            <div className="flex items-center gap-3">
                                                <img src={v.avatar} className="w-8 h-8 rounded-full object-cover shadow-sm" />
                                                <div className="flex flex-col">
                                                    <strong className="text-xs font-black text-[#0f172a]">{v.name}</strong>
                                                    <span className="text-[9px] font-bold text-[#64748b] uppercase">{v.date}</span>
                                                </div>
                                            </div>
                                            <strong className="text-[#2563eb] text-xs font-black">{v.points.toLocaleString()} PTS</strong>
                                        </div>
                                    )) : (
                                        <div className="text-center py-6 text-[#64748b] text-xs font-bold">Belum ada pendukung.</div>
                                    )}
                                </div>
                            </div>

                            <div className="grid grid-cols-[1fr_auto] gap-4 pt-8">
                                <button 
                                    type="submit" 
                                    disabled={editForm.processing}
                                    className="bg-[#2563eb] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-blue-100 hover:scale-[1.02] active:scale-95 transition-all"
                                >
                                    {editForm.processing ? 'Memproses...' : 'Update Data'}
                                </button>
                                <button 
                                    type="button"
                                    onClick={handleModalDelete}
                                    className="px-5 bg-red-50 text-red-500 border border-red-100 rounded-2xl hover:bg-red-100 transition-colors"
                                >
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
