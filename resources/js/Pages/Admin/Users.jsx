import React, { useState, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Pagination from '@/Components/Pagination';

export default function Users({ users, stats }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [search, setSearch] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [confirmingDeletion, setConfirmingDeletion] = useState(null);
    const [avatarPreview, setAvatarPreview] = useState(null);
    const itemsPerPage = 10;

    // Reset page when search changes
    useEffect(() => {
        setCurrentPage(1);
    }, [search]);

    const filteredUsers = users.filter(user => {
        const query = search.toLowerCase();
        return (
            (user.name || '').toLowerCase().includes(query) ||
            (user.username || '').toLowerCase().includes(query) ||
            (user.email || '').toLowerCase().includes(query)
        );
    });

    const totalPages = Math.ceil(filteredUsers.length / itemsPerPage);
    const paginatedUsers = filteredUsers.slice(
        (currentPage - 1) * itemsPerPage,
        currentPage * itemsPerPage
    );

    const { data, setData, post, processing, errors, reset, delete: destroy } = useForm({
        _method: 'PUT',
        name: '',
        username: '',
        whatsapp: '',
        role: 'voter',
        points: 0,
        avatar: null,
    });

    const openEditModal = (user) => {
        setSelectedUser(user);
        setData({
            _method: 'PUT',
            name: user.name || '',
            username: user.username || '',
            whatsapp: user.whatsapp || '',
            role: user.role || 'voter',
            points: user.points || 0,
            avatar: null,
        });
        setAvatarPreview(null);
        setIsModalOpen(true);
    };

    const submit = (e) => {
        e.preventDefault();
        post(`/admin/users/${selectedUser.id}`, {
            onSuccess: () => {
                setIsModalOpen(false);
                reset();
                setAvatarPreview(null);
            },
        });
    };

    const handleDelete = (id) => {
        setConfirmingDeletion(id);
    };

    const confirmDelete = () => {
        destroy(`/admin/users/${confirmingDeletion}`, {
            onSuccess: () => setConfirmingDeletion(null),
        });
    };

    return (
        <AdminLayout title="Kelola User" kicker="Data pemilih & admin">
            <div className="space-y-8">
                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total User</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.total_users.toLocaleString()}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Voters</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.voters.toLocaleString()}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Admins</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.admins.toLocaleString()}</h3>
                        </div>
                    </div>
                    <div className="bg-white border border-white rounded-[2rem] p-5 shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 16v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2" /></svg>
                        </div>
                        <div>
                            <p className="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Poin</p>
                            <h3 className="text-lg font-black text-slate-900 leading-none">{stats.total_points.toLocaleString()}</h3>
                        </div>
                    </div>
                </div>

                <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-white">
                    <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <h2 className="text-xl font-black text-slate-900 flex items-center gap-3">
                            <span className="w-2 h-7 bg-blue-600 rounded-full"></span>
                            User List
                        </h2>

                        <div className="relative group w-full md:w-[320px]">
                            <input 
                                type="text" 
                                placeholder="Cari nama, email, username..." 
                                className="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold focus:bg-white focus:border-blue-500 focus:shadow-xl focus:shadow-blue-500/10 outline-none transition-all duration-300"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                    
                    <div className="hidden lg:grid grid-cols-12 gap-8 px-6 mb-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <div className="col-span-4">Detail Pengguna</div>
                        <div className="col-span-3">Kontak & Email</div>
                        <div className="col-span-2 text-right">Saldo Poin</div>
                        <div className="col-span-3 text-right">Aksi</div>
                    </div>

                    <div className="space-y-4 mb-10">
                        {paginatedUsers.length > 0 ? paginatedUsers.map((user) => (
                            <div key={user.id} className="group bg-slate-50/50 p-6 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white transition-all hover:shadow-xl hover:shadow-slate-200/20">
                                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center w-full">
                                    {/* User Details */}
                                    <div className="col-span-4">
                                        <div className="flex items-center gap-4">
                                            <div className="relative shrink-0">
                                                <img 
                                                    src={user.avatar ? `/storage/${user.avatar}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || user.username)}&background=f1f5f9&color=64748b&bold=true`} 
                                                    className="w-12 h-12 rounded-2xl object-cover shadow-sm"
                                                />
                                                <div className={`absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white ${user.role === 'admin' ? 'bg-blue-500' : 'bg-slate-300'}`}></div>
                                            </div>
                                            <div className="min-w-0">
                                                <h4 className="text-sm font-black text-slate-900 truncate">{user.name || '-'}</h4>
                                                <p className="text-[10px] font-bold text-slate-400 truncate">@{user.username || 'no-username'}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Contact */}
                                    <div className="col-span-3">
                                        <div className="flex flex-col gap-0.5">
                                            <p className="text-xs font-bold text-slate-600 truncate">{user.email}</p>
                                            <p className="text-[10px] font-bold text-slate-400">{user.whatsapp || '-'}</p>
                                        </div>
                                    </div>

                                    {/* Points */}
                                    <div className="col-span-2 text-center lg:text-right">
                                        <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 lg:hidden">Points</p>
                                        <p className="text-sm font-black text-blue-600">{user.points.toLocaleString()} PTS</p>
                                    </div>

                                    {/* Actions */}
                                    <div className="col-span-3 flex justify-center lg:justify-end gap-2">
                                        <button 
                                            onClick={() => openEditModal(user)}
                                            className="w-10 h-10 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-100 shadow-sm transition-all"
                                        >
                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button 
                                            onClick={() => handleDelete(user.id)}
                                            className="w-10 h-10 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-100 shadow-sm transition-all"
                                        >
                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        )) : (
                            <div className="bg-slate-50/50 p-20 rounded-[2.5rem] border border-dashed border-slate-200 text-center">
                                <h3 className="text-slate-400 font-bold italic">Belum ada user yang ditemukan.</h3>
                            </div>
                        )}
                    </div>

                    <Pagination 
                        currentPage={currentPage}
                        totalPages={totalPages}
                        onPageChange={setCurrentPage}
                        totalItems={filteredUsers.length}
                        itemsPerPage={itemsPerPage}
                    />
                </div>
            </div>

            {/* MODAL EDIT USER */}
            {isModalOpen && (
                <div className="fixed inset-0 z-[3000] flex items-center justify-center p-6" onClick={() => setIsModalOpen(false)}>
                    <div className="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                    <div className="bg-white w-full max-w-[500px] rounded-[2.5rem] p-10 shadow-2xl relative z-10 animate-in zoom-in-95 duration-200" onClick={e => e.stopPropagation()}>
                        <div className="flex justify-between items-start mb-8">
                            <div>
                                <span className="text-[10px] font-black text-[#2563eb] uppercase tracking-widest block mb-1">Profil Pengguna</span>
                                <h2 className="text-2xl font-black text-[#0f172a]">{selectedUser.name || 'Edit User'}</h2>
                            </div>
                            <button onClick={() => setIsModalOpen(false)} className="w-10 h-10 bg-[#f8fafc] border border-black/5 rounded-2xl flex items-center justify-center text-[#64748b] hover:text-red-500 transition-colors">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <form onSubmit={submit} className="space-y-6">
                            <div className="flex flex-col items-center gap-4 mb-8">
                                <div className="relative group">
                                    <div className="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl group-hover:border-blue-100 transition-all">
                                        <img 
                                            src={avatarPreview || (selectedUser.avatar ? `/storage/${selectedUser.avatar}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(selectedUser.name || selectedUser.username)}&size=200&background=2563eb&color=ffffff`)} 
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
                                                setData('avatar', file);
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => setAvatarPreview(e.target.result);
                                                    reader.readAsDataURL(file);
                                                }
                                            }}
                                        />
                                    </label>
                                </div>
                                <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Klik ikon kamera untuk ganti avatar</p>
                            </div>

                            <div className="space-y-2">
                                <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                    value={data.name}
                                    onChange={e => setData('name', e.target.value)}
                                    required
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div className="space-y-2">
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Username</label>
                                    <input 
                                        type="text" 
                                        className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                        value={data.username}
                                        onChange={e => setData('username', e.target.value)}
                                    />
                                </div>
                                <div className="space-y-2">
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">WhatsApp</label>
                                    <input 
                                        type="text" 
                                        className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                        value={data.whatsapp}
                                        onChange={e => setData('whatsapp', e.target.value)}
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div className="space-y-2">
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Role</label>
                                    <select 
                                        className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all appearance-none"
                                        value={data.role}
                                        onChange={e => setData('role', e.target.value)}
                                    >
                                        <option value="voter">Voter</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div className="space-y-2">
                                    <label className="text-[10px] font-black text-[#64748b] uppercase tracking-widest block px-1">Poin</label>
                                    <input 
                                        type="number" 
                                        className="w-full bg-[#f8fafc] border border-black/10 rounded-2xl px-5 py-4 font-bold text-sm outline-none focus:border-[#2563eb] transition-all"
                                        value={data.points}
                                        onChange={e => setData('points', e.target.value)}
                                    />
                                </div>
                            </div>

                            <div className="pt-6">
                                <button 
                                    type="submit" 
                                    disabled={processing}
                                    className="w-full bg-[#2563eb] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-blue-100 hover:scale-[1.02] active:scale-95 transition-all"
                                >
                                    {processing ? 'Menyimpan...' : 'Update Profil'}
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
                            <svg className="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <h3 className="text-xl font-black text-[#0f172a] text-center mb-2">Hapus Pengguna?</h3>
                        <p className="text-sm font-bold text-slate-500 text-center mb-8 leading-relaxed">Tindakan ini permanen. Seluruh riwayat transaksi dan poin milik user ini akan ikut terhapus.</p>
                        
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
