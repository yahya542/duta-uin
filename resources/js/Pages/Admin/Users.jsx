import React, { useState, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Pagination from '@/Components/Pagination';

export default function Users({ users, stats }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedUser, setSelectedUser] = useState(null);
    const [search, setSearch] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
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
        setIsModalOpen(true);
    };

    const submit = (e) => {
        e.preventDefault();
        post(`/admin/users/${selectedUser.id}`, {
            onSuccess: () => {
                setIsModalOpen(false);
                reset();
            },
        });
    };

    const handleDelete = () => {
        if (confirm('Hapus user ini secara permanen?')) {
            destroy(`/admin/users/${selectedUser.id}`, {
                onSuccess: () => setIsModalOpen(false),
            });
        }
    };

    return (
        <AdminLayout title="Kelola User" kicker="Data pemilih & admin">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total User</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.total_users.toLocaleString()}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Voters</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.voters.toLocaleString()}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Admins</span>
                    <strong className="block text-3xl font-black text-[#2563eb]">{stats.admins.toLocaleString()}</strong>
                </div>
                <div className="bg-white border border-black/5 rounded-3xl p-8 shadow-xl shadow-gray-200/50">
                    <span className="block text-[10px] font-black text-[#64748b] uppercase tracking-widest mb-3">Total Poin</span>
                    <strong className="block text-3xl font-black text-[#0f172a]">{stats.total_points.toLocaleString()}</strong>
                </div>
            </div>

            <div className="bg-white border border-black/5 rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50">
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                    <h2 className="text-xl font-black text-[#0f172a] flex items-center gap-3">
                        <span className="w-2 h-7 bg-[#2563eb] rounded-full"></span>
                        Daftar Pengguna
                    </h2>

                    {/* Search Input */}
                    <div className="relative group w-full md:w-[320px]">
                        <input 
                            type="text" 
                            placeholder="Cari nama, email, atau username..." 
                            className="w-full bg-[#f8fafc] border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold focus:bg-white focus:border-blue-500 focus:shadow-xl focus:shadow-blue-500/10 outline-none transition-all duration-300"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                        />
                        <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>
                
                <div className="overflow-x-auto">
                    <table className="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr className="text-[10px] font-black text-[#64748b] uppercase tracking-widest">
                                <th className="px-6 pb-2"></th>
                                <th className="px-6 pb-2">Nama</th>
                                <th className="px-6 pb-2">Username</th>
                                <th className="px-6 pb-2">Email</th>
                                <th className="px-6 pb-2">WhatsApp</th>
                                <th className="px-6 pb-2 text-center">Role</th>
                                <th className="px-6 pb-2 text-right">Poin</th>
                                <th className="px-6 pb-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {paginatedUsers.length > 0 ? paginatedUsers.map((user) => (
                                <tr key={user.id} className="group">
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-l-2xl group-hover:bg-blue-50 transition-colors">
                                        <img 
                                            src={user.avatar ? `/storage/${user.avatar}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || user.username)}&size=80&background=f1f5f9&color=64748b`} 
                                            className="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm"
                                        />
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 group-hover:bg-blue-50 transition-colors">
                                        <strong className="text-[#0f172a] font-black text-sm">{user.name || '-'}</strong>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 text-[#64748b] font-bold text-xs group-hover:bg-blue-50 transition-colors">
                                        {user.username ? `@${user.username}` : '-'}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 text-[#64748b] font-bold text-xs group-hover:bg-blue-50 transition-colors">
                                        {user.email}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 text-[#64748b] font-bold text-xs group-hover:bg-blue-50 transition-colors">
                                        {user.whatsapp || '-'}
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 text-center group-hover:bg-blue-50 transition-colors">
                                        <span className={`inline-block px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest ${user.role === 'admin' ? 'bg-blue-100 text-[#2563eb]' : 'bg-gray-100 text-[#64748b]'}`}>
                                            {user.role}
                                        </span>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 text-right group-hover:bg-blue-50 transition-colors">
                                        <strong className="text-[#2563eb] font-black">{user.points.toLocaleString()}</strong>
                                    </td>
                                    <td className="bg-[#f8fafc] px-6 py-4 rounded-r-2xl text-right group-hover:bg-blue-50 transition-colors">
                                        <button 
                                            onClick={() => openEditModal(user)}
                                            className="px-4 py-2 bg-white border border-black/5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-white hover:border-[#2563eb] hover:text-[#2563eb] shadow-sm transition-all"
                                        >
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            )) : (
                                <tr><td colSpan="8" className="text-center py-20 text-[#64748b] font-bold">Belum ada user.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <Pagination 
                    currentPage={currentPage}
                    totalPages={totalPages}
                    onPageChange={setCurrentPage}
                    totalItems={filteredUsers.length}
                    itemsPerPage={itemsPerPage}
                />
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
                            <div className="flex justify-center mb-4">
                                <img 
                                    src={selectedUser.avatar ? `/storage/${selectedUser.avatar}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(selectedUser.name || selectedUser.username)}&size=200&background=2563eb&color=ffffff`} 
                                    className="w-24 h-24 rounded-full object-cover border-4 border-white shadow-2xl"
                                />
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

                            <div className="grid grid-cols-[1fr_auto] gap-4 pt-6">
                                <button 
                                    type="submit" 
                                    disabled={processing}
                                    className="bg-[#2563eb] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-blue-100 hover:scale-[1.02] active:scale-95 transition-all"
                                >
                                    {processing ? 'Menyimpan...' : 'Update Profil'}
                                </button>
                                <button 
                                    type="button"
                                    onClick={handleDelete}
                                    className="px-5 bg-red-50 text-red-500 border border-red-100 rounded-2xl hover:bg-red-100 transition-colors"
                                >
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
