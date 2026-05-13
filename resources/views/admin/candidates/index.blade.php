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

<div class="admin-card admin-card-pad">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 class="admin-section-title" style="margin: 0;">Daftar Kandidat</h2>
        <button type="button" class="btn btn-primary js-open-add-modal" style="padding: 0.6rem 1.25rem; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kandidat
        </button>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Foto</th>
                    <th>Nama Lengkap</th>
                    <th>Kategori</th>
                    <th>Perolehan Suara</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidates as $candidate)
                    <tr class="js-searchable" data-search="{{ strtolower($candidate->name . ' ' . $candidate->category) }}">
                        <td>
                            <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=100&background=2563eb&color=ffffff' }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        </td>
                        <td>
                            <strong style="color: var(--text-main);">{{ $candidate->name }}</strong>
                        </td>
                        <td>
                            <span class="admin-badge info">{{ $candidate->category }}</span>
                        </td>
                        <td>
                            <strong style="color: var(--primary);">{{ number_format($candidate->total_votes) }}</strong>
                        </td>
                        <td style="text-align: right;">
                            <button type="button" 
                                    class="btn btn-outline js-open-edit-modal" 
                                    data-candidate="{{ json_encode($candidate) }}"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">Detail & Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">Belum ada kandidat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addCandidateModal" class="vote-modal-backdrop" aria-hidden="true">
    <div class="vote-modal-card" style="max-width: 500px; width: 90%;">
        <div class="vote-modal-header">
            <div>
                <span class="vote-modal-kicker">Input Peserta</span>
                <h2 class="vote-modal-title">Tambah Kandidat Baru</h2>
            </div>
            <button type="button" class="vote-modal-close js-close-modal">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
            @csrf
            
            <div style="display: flex; justify-content: center; margin-bottom: 0.5rem;">
                <img id="addCandidatePreview" src="https://ui-avatars.com/api/?name=C&size=200&background=f1f5f9&color=64748b" 
                     style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            </div>

            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Nama Lengkap</label>
                <input type="text" name="name" required class="form-input" style="margin-top: 0.5rem;">
            </div>
            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Kategori Duta</label>
                <select name="category" required class="form-input" style="margin-top: 0.5rem;">
                    <option value="putra">Duta Putra</option>
                    <option value="putri">Duta Putri</option>
                </select>
            </div>
            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Foto Kandidat</label>
                <input type="file" name="photo" class="form-input js-candidate-photo-input" data-target="addCandidatePreview" style="margin-top: 0.5rem;">
            </div>
            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Deskripsi / Visi Misi</label>
                <textarea name="description" rows="3" class="form-input" style="margin-top: 0.5rem;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem; margin-top: 0.5rem;">Simpan Kandidat</button>
        </form>
    </div>
</div>

<!-- MODAL EDIT/DETAIL -->
<div id="editCandidateModal" class="vote-modal-backdrop" aria-hidden="true">
    <div class="vote-modal-card" style="max-width: 500px; width: 90%;">
        <div class="vote-modal-header">
            <div>
                <span class="vote-modal-kicker">Detail & Edit</span>
                <h2 id="editCandidateTitle" class="vote-modal-title">Edit Kandidat</h2>
            </div>
            <button type="button" class="vote-modal-close js-close-modal">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form id="editCandidateForm" action="" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
            @csrf
            @method('PUT')
            
            <div style="display: flex; justify-content: center; margin-bottom: 0.5rem;">
                <img id="editCandidatePreview" src="" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            </div>

            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Nama Lengkap</label>
                <input type="text" id="editNameInput" name="name" required class="form-input" style="margin-top: 0.5rem;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Kategori</label>
                    <select id="editCategoryInput" name="category" required class="form-input" style="margin-top: 0.5rem;">
                        <option value="putra">Duta Putra</option>
                        <option value="putri">Duta Putri</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Total Suara</label>
                    <input type="number" id="editVotesInput" name="total_votes" class="form-input" style="margin-top: 0.5rem;">
                </div>
            </div>
            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Deskripsi</label>
                <textarea id="editDescInput" name="description" rows="3" class="form-input" style="margin-top: 0.5rem;"></textarea>
            </div>
            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Ganti Foto (Opsional)</label>
                <input type="file" name="photo" class="form-input js-candidate-photo-input" data-target="editCandidatePreview" style="margin-top: 0.5rem;">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.8rem;">Update Data</button>
                <button type="button" id="btnDeleteCandidate" class="btn btn-outline" style="color: #dc2626; border-color: rgba(220, 38, 38, 0.2);">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        </form>

        <form id="deleteCandidateForm" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addModal = document.getElementById('addCandidateModal');
        const editModal = document.getElementById('editCandidateModal');
        const editForm = document.getElementById('editCandidateForm');
        const deleteForm = document.getElementById('deleteCandidateForm');

        const openModal = (modal) => {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
        };

        const closeModal = (modal) => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        };

        // Open Add
        document.querySelector('.js-open-add-modal').addEventListener('click', () => {
            document.getElementById('addCandidatePreview').src = 'https://ui-avatars.com/api/?name=C&size=200&background=f1f5f9&color=64748b';
            openModal(addModal);
        });

        // Open Edit
        document.querySelectorAll('.js-open-edit-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                const data = JSON.parse(btn.dataset.candidate);
                
                // Populate Form
                document.getElementById('editCandidateTitle').innerText = data.name;
                document.getElementById('editNameInput').value = data.name;
                document.getElementById('editCategoryInput').value = data.category;
                document.getElementById('editVotesInput').value = data.total_votes;
                document.getElementById('editDescInput').value = data.description || '';
                
                const preview = document.getElementById('editCandidatePreview');
                if (data.photo) {
                    preview.src = `/storage/${data.photo}`;
                } else {
                    preview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}&size=200&background=2563eb&color=ffffff`;
                }

                editForm.action = `/admin/candidates/${data.id}`;
                deleteForm.action = `/admin/candidates/${data.id}`;

                openModal(editModal);
            });
        });

        // Instant Preview Logic
        document.querySelectorAll('.js-candidate-photo-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const targetId = input.dataset.target;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        document.getElementById(targetId).src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // Close buttons
        document.querySelectorAll('.js-close-modal').forEach(btn => {
            btn.addEventListener('click', (e) => {
                closeModal(e.target.closest('.vote-modal-backdrop'));
            });
        });

        // Delete button
        document.getElementById('btnDeleteCandidate').addEventListener('click', () => {
            if (confirm('Hapus kandidat ini secara permanen?')) {
                deleteForm.submit();
            }
        });

        // Close on backdrop click
        [addModal, editModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal(modal);
            });
        });
    });
</script>
@endsection
