@extends('admin.layout')

@section('admin-title', 'Kelola Kandidat')
@section('admin-kicker', 'Data peserta voting')

@section('admin-content')
<div class="admin-stat-grid">
    <div class="admin-card admin-stat"><span>Total Kandidat</span><strong>{{ $stats['total'] }}</strong></div>
    <div class="admin-card admin-stat"><span>Duta Putra</span><strong>{{ $stats['putra'] }}</strong></div>
    <div class="admin-card admin-stat"><span>Duta Putri</span><strong>{{ $stats['putri'] }}</strong></div>
    <div class="admin-card admin-stat"><span>Total Suara</span><strong>{{ number_format($stats['votes']) }}</strong></div>
</div>

<div class="admin-grid-2" style="grid-template-columns: 360px minmax(0, 1fr);">
    <div class="admin-card admin-card-pad">
        <h2 class="admin-section-title">Tambah Kandidat</h2>
        <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label class="form-label">Nama Kandidat</label>
                <input type="text" name="name" required class="form-input">
            </div>
            <div>
                <label class="form-label">Kategori</label>
                <select name="category" required class="form-input">
                    <option value="putra">Duta Putra</option>
                    <option value="putri">Duta Putri</option>
                </select>
            </div>
            <div>
                <label class="form-label">Foto</label>
                <input type="file" name="photo" class="form-input">
            </div>
            <div>
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="4" class="form-input"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Kandidat</button>
        </form>
    </div>

    <div class="admin-card admin-card-pad">
        <h2 class="admin-section-title">Daftar Kandidat</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
            @forelse($candidates as $candidate)
                <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: 1rem; overflow: hidden;">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=2563eb&color=ffffff' }}" alt="{{ $candidate->name }}" style="width: 100%; height: 160px; object-fit: cover;">
                    <div style="padding: 1rem;">
                        <div style="display: flex; justify-content: space-between; gap: 1rem; align-items: start;">
                            <div>
                                <h3 style="font-weight: 900; color: var(--text-main);">{{ $candidate->name }}</h3>
                                <span class="admin-badge info">{{ $candidate->category }}</span>
                            </div>
                            <strong style="color: var(--primary);">{{ number_format($candidate->total_votes) }}</strong>
                        </div>
                        <p style="margin: 0.8rem 0; color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">{{ $candidate->description ?: 'Belum ada deskripsi.' }}</p>

                        <details>
                            <summary style="cursor: pointer; color: var(--primary); font-weight: 900; font-size: 0.8rem;">Edit Data</summary>
                            <form action="{{ route('admin.candidates.update', $candidate->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem;">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $candidate->name }}" required class="form-input">
                                <select name="category" required class="form-input">
                                    <option value="putra" @selected($candidate->category === 'putra')>Duta Putra</option>
                                    <option value="putri" @selected($candidate->category === 'putri')>Duta Putri</option>
                                </select>
                                <input type="number" name="total_votes" value="{{ $candidate->total_votes }}" class="form-input">
                                <textarea name="description" rows="3" class="form-input">{{ $candidate->description }}</textarea>
                                <input type="file" name="photo" class="form-input">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </details>

                        <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Hapus kandidat ini?')" style="margin-top: 0.75rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="width: 100%; color: #dc2626;">Hapus Kandidat</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="admin-empty">Belum ada kandidat.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
