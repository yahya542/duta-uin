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
    const [confirmingDeletion, setConfirmingDeletion] = useState(null);
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
        setConfirmingDeletion(id);
    };

    const confirmDelete = () => {
        useForm().delete(`/admin/candidates/${confirmingDeletion}`, {
            onSuccess: () => setConfirmingDeletion(null),
        });
    };

    return (
        <AdminLayout title="Kelola Kandidat" kicker="Data peserta voting">
            <div className="space-y-8">
                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Kandidat</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.total}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Duta Putra</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.putra}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Duta Putri</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.putri}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Suara</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.votes.toLocaleString()}</h3>
                        </div>
                    </div>
                </div>

                <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-white">
                    <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-10">
                        <h2 className="text-xl font-black text-slate-900 flex items-center gap-3">
                            <span className="w-2 h-7 bg-blue-600 rounded-full"></span>
                            Candidate List
                        </h2>

                        <div className="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                            <div className="relative group w-full sm:w-[280px]">
                                <input 
                                    type="text" 
                                    placeholder="Cari kandidat..." 
                                    className="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold focus:bg-white focus:border-blue-500 focus:shadow-xl focus:shadow-blue-500/10 outline-none transition-all duration-300"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                />
                                <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>

                            <button 
                                onClick={() => setIsAddModalOpen(true)}
                                className="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 shadow-xl shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all w-full sm:w-auto"
                            >
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M12 4v16m8-8H4" /></svg>
                                New Candidate
                            </button>
                        </div>
                    </div>

                    <div className="hidden lg:grid grid-cols-12 gap-8 px-6 mb-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <div className="col-span-4">Info Kandidat</div>
                        <div className="col-span-2 text-center">Kategori</div>
                        <div className="col-span-3">Progress Voting</div>
                        <div className="col-span-3 text-right">Aksi</div>
                    </div>

                    <div className="space-y-4 mb-10">
                        {paginatedCandidates.length > 0 ? paginatedCandidates.map((candidate) => (
                            <div 
                                key={candidate.id} 
                                className="group bg-slate-50/50 p-6 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white transition-all hover:shadow-xl hover:shadow-slate-200/20 cursor-pointer"
                                onClick={() => openEditModal(candidate)}
                            >
                                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center w-full">
                                    {/* Candidate Info */}
                                    <div className="col-span-4">
                                        <div className="flex items-center gap-4">
                                            <div className="relative shrink-0">
                                                <img 
                                                    src={candidate.photo ? `/storage/${candidate.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(candidate.name)}&background=f1f5f9&color=64748b&bold=true`} 
                                                    className="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-sm group-hover:scale-105 transition-transform"
                                                />
                                                <div className="absolute -top-2 -right-2 w-7 h-7 bg-white rounded-full flex items-center justify-center text-[10px] font-black text-slate-900 shadow-md">
                                                    #{candidate.id}
                                                </div>
                                            </div>
                                            <div className="min-w-0">
                                                <h4 className="text-base font-black text-slate-900 truncate tracking-tight">{candidate.name}</h4>
                                                <p className="text-[10px] font-bold text-slate-400">Peserta Voting</p>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Category */}
                                    <div className="col-span-2 text-center">
                                        <span className={`inline-block px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest ${candidate.category === 'putra' ? 'bg-indigo-50 text-indigo-600' : 'bg-purple-50 text-purple-600'}`}>
                                            {candidate.category}
                                        </span>
                                    </div>

                                    {/* Progress */}
                                    <div className="col-span-3">
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 lg:hidden">Voting Progress</p>
                                        <div className="flex items-center gap-3">
                                            <div className="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                <div 
                                                    className="h-full bg-blue-600 rounded-full transition-all duration-1000"
                                                    style={{ width: `${Math.min((candidate.total_votes / (stats.votes || 1)) * 100 * 2, 100)}%` }}
                                                ></div>
                                            </div>
                                            <span className="text-xs font-black text-slate-900 whitespace-nowrap">{candidate.total_votes.toLocaleString()} Votes</span>
                                        </div>
                                    </div>

                                    {/* Actions */}
                                    <div className="col-span-3 flex justify-center lg:justify-end gap-2" onClick={e => e.stopPropagation()}>
                                        <button 
                                            onClick={() => openEditModal(candidate)}
                                            className="w-10 h-10 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-100 shadow-sm transition-all"
                                        >
                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button 
                                            onClick={() => handleDelete(candidate.id)}
                                            className="w-10 h-10 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-100 shadow-sm transition-all"
                                        >
                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        )) : (
                            <div className="bg-slate-50/50 p-20 rounded-[2.5rem] border border-dashed border-slate-200 text-center">
                                <h3 className="text-slate-400 font-bold italic">Belum ada kandidat yang ditemukan.</h3>
                            </div>
                        )}
                    </div>

                    <Pagination 
                        currentPage={currentPage}
                        totalPages={totalPages}
                        onPageChange={setCurrentPage}
                        totalItems={filteredCandidates.length}
                        itemsPerPage={itemsPerPage}
                    />
                </div>
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

                            <div className="pt-8">
                                <button 
                                    type="submit" 
                                    disabled={editForm.processing}
                                    className="w-full bg-[#2563eb] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-blue-100 hover:scale-[1.02] active:scale-95 transition-all"
                                >
                                    {editForm.processing ? 'Memproses...' : 'Update Data'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* CUSTOM CONFIRM DELETION MODAL */}
            {confirmingDeletion && (
                <div className="fixed inset-0 z-[4000] flex items-center justify-center p-6">
                    <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-md animate-in fade-in duration-300"></div>
                    <div className="bg-white w-full max-w-[400px] rounded-[2.5rem] p-10 shadow-2xl relative z-10 animate-in zoom-in-95 duration-200">
                        <div className="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg className="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" /></svg>
                        </div>
                        <h3 className="text-xl font-black text-[#0f172a] text-center mb-2">Hapus Kandidat?</h3>
                        <p className="text-sm font-bold text-slate-500 text-center mb-8 leading-relaxed">Tindakan ini tidak bisa dibatalkan. Seluruh data voting terkait kandidat ini akan hilang selamanya.</p>
                        
                        <div className="grid grid-cols-2 gap-4">
                            <button 
                                onClick={() => setConfirmingDeletion(null)}
                                className="py-4 bg-slate-100 text-slate-600 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all"
                            >
                                Batal
                            </button>
                            <button 
                                onClick={confirmDelete}
                                className="py-4 bg-red-500 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-red-100 hover:scale-[1.02] active:scale-95 transition-all"
                            >
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
