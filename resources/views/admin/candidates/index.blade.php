@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
            <div>
                <h1 class="hero-title text-4xl text-left ml-0">KELOLA <span>KANDIDAT</span></h1>
                <p class="section-desc text-left ml-0">Tambah, edit, atau hapus data kandidat duta kampus.</p>
            </div>
            <button class="btn-primary" onclick="toggleModal('createModal')">TAMBAH KANDIDAT</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($candidates as $candidate)
                <div class="candidate-card">
                    <div class="candidate-banner h-48">
                        <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=1E3A55&color=C9A84C' }}" 
                             alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="candidate-body">
                        <h3 class="candidate-name text-xl mb-2">{{ $candidate->name }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $candidate->description }}</p>
                        
                        <div class="flex items-center justify-between border-t border-slate-800 pt-4 mt-auto">
                            <span class="text-gold font-bold">{{ number_format($candidate->total_votes) }} Poin</span>
                            <div class="flex gap-2">
                                <button class="btn-secondary py-2 px-4" onclick="editCandidate({{ $candidate->id }}, '{{ $candidate->name }}', '{{ $candidate->description }}')">EDIT</button>
                                <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Hapus kandidat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-bold ml-2">HAPUS</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Simple Create Modal -->
<div id="createModal" class="modal-overlay">
    <div class="modal max-w-lg">
        <button class="modal-close" onclick="toggleModal('createModal')">×</button>
        <h2>TAMBAH KANDIDAT BARU</h2>
        <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gold uppercase mb-1">NAMA LENGKAP</label>
                <input type="text" name="name" required class="w-full bg-navy-3 border border-slate-700 rounded-lg p-3 text-cream">
            </div>
            <div>
                <label class="block text-xs font-bold text-gold uppercase mb-1">FOTO KANDIDAT</label>
                <input type="file" name="photo" class="w-full text-slate-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gold uppercase mb-1">DESKRIPSI / VISI MISI</label>
                <textarea name="description" rows="4" class="w-full bg-navy-3 border border-slate-700 rounded-lg p-3 text-cream"></textarea>
            </div>
            <button type="submit" class="btn-primary w-full">SIMPAN KANDIDAT</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('open');
    }
</script>
@endpush
@endsection
