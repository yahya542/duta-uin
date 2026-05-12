@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Kelola Kandidat</h1>
                <p class="mt-2 text-slate-500">Tambah, edit, dan pantau kandidat voting</p>
            </div>
            <button onclick="openAddModal()" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                Tambah Kandidat
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($candidates as $candidate)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&background=random' }}" 
                             alt="{{ $candidate->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold">{{ $candidate->name }}</h3>
                            <p class="text-xs text-slate-300">{{ number_format($candidate->total_votes) }} Suara • {{ number_format($candidate->percentage, 1) }}%</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-slate-500 mb-6 line-clamp-3">{{ $candidate->description }}</p>
                        <div class="flex gap-2">
                            <button onclick="openEditModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}', '{{ addslashes($candidate->description) }}', {{ $candidate->total_votes }})" 
                                    class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">
                                Edit Detail
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeAddModal()"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block transform overflow-hidden rounded-3xl bg-white text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Tambah Kandidat Baru</h3>
                <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Foto</label>
                        <input type="file" name="photo" class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Deskripsi/Visi-Misi</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mt-8 flex gap-3">
                        <button type="button" onclick="closeAddModal()" class="flex-1 px-4 py-4 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block transform overflow-hidden rounded-3xl bg-white text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Edit Kandidat</h3>
                <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="editName" required class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Total Poin Suara (Manual Edit)</label>
                        <input type="number" name="total_votes" id="editVotes" class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Foto Baru (Opsional)</label>
                        <input type="file" name="photo" class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-1">Deskripsi/Visi-Misi</label>
                        <textarea name="description" id="editDescription" rows="4" class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mt-8 flex gap-3">
                        <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-4 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    function openEditModal(id, name, description, votes) {
        document.getElementById('editForm').action = '/admin/candidates/' + id;
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editVotes').value = votes;
        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
