@extends('admin.layout')

@section('admin-title', 'Kelola User')
@section('admin-kicker', 'Data pemilih & admin')

@section('admin-content')
<div class="admin-stat-grid">
    <div class="admin-card admin-stat"><span>Total User</span><strong>{{ $stats['total_users'] }}</strong></div>
    <div class="admin-card admin-stat"><span>Voters</span><strong>{{ $stats['voters'] }}</strong></div>
    <div class="admin-card admin-stat"><span>Admins</span><strong>{{ $stats['admins'] }}</strong></div>
    <div class="admin-card admin-stat"><span>Total Poin</span><strong>{{ number_format($stats['total_points']) }}</strong></div>
</div>

<div class="admin-card admin-card-pad">
    <h2 class="admin-section-title">Daftar Pengguna</h2>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Role</th>
                    <th>Poin</th>
                    <th>Bergabung</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="js-searchable" data-search="{{ strtolower(($user->name ?? $user->first_name . ' ' . $user->last_name) . ' ' . $user->username . ' ' . $user->email) }}">
                        <td>
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? $user->username) . '&size=100&background=f1f5f9&color=64748b' }}" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border);">
                        </td>
                        <td><strong>{{ $user->name ?? trim($user->first_name . ' ' . $user->last_name) ?: '-' }}</strong></td>
                        <td>{{ $user->username ? '@' . $user->username : '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->whatsapp ?: '-' }}</td>
                        <td><span class="admin-badge {{ $user->role === 'admin' ? 'success' : 'info' }}">{{ $user->role }}</span></td>
                        <td><strong style="color: var(--primary);">{{ number_format($user->points) }}</strong></td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td style="text-align: right;">
                            <button type="button" 
                                    class="btn btn-outline js-open-user-modal" 
                                    data-user="{{ json_encode($user) }}"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="admin-empty">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL EDIT USER -->
<div id="userModal" class="vote-modal-backdrop" aria-hidden="true">
    <div class="vote-modal-card" style="max-width: 500px; width: 90%;">
        <div class="vote-modal-header">
            <div>
                <span class="vote-modal-kicker">Profil Pengguna</span>
                <h2 id="userModalTitle" class="vote-modal-title">Edit User</h2>
            </div>
            <button type="button" class="vote-modal-close js-close-modal">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form id="userForm" action="" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
            @csrf
            @method('PUT')
            
            <div style="display: flex; justify-content: center; margin-bottom: 0.5rem;">
                <img id="userPreview" src="" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            </div>

            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Nama Lengkap</label>
                <input type="text" id="userNameInput" name="name" required class="form-input" style="margin-top: 0.5rem;">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Username</label>
                    <input type="text" id="userUsernameInput" name="username" class="form-input" style="margin-top: 0.5rem;">
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">WhatsApp</label>
                    <input type="text" id="userWaInput" name="whatsapp" class="form-input" style="margin-top: 0.5rem;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Role</label>
                    <select id="userRoleInput" name="role" required class="form-input" style="margin-top: 0.5rem;">
                        <option value="voter">Voter</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Poin</label>
                    <input type="number" id="userPointsInput" name="points" class="form-input" style="margin-top: 0.5rem;">
                </div>
            </div>

            <div>
                <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Ganti Avatar (Opsional)</label>
                <input type="file" name="avatar" class="form-input" style="margin-top: 0.5rem;">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.8rem;">Update Profil</button>
                <button type="button" id="btnDeleteUser" class="btn btn-outline" style="color: #dc2626; border-color: rgba(220, 38, 38, 0.2);">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        </form>

        <form id="deleteUserForm" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');
        const deleteForm = document.getElementById('deleteUserForm');

        const openModal = (modalEl) => {
            modalEl.classList.add('is-open');
            modalEl.setAttribute('aria-hidden', 'false');
        };

        const closeModal = (modalEl) => {
            modalEl.classList.remove('is-open');
            modalEl.setAttribute('aria-hidden', 'true');
        };

        // Open Edit
        document.querySelectorAll('.js-open-user-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                const user = JSON.parse(btn.dataset.user);
                
                // Populate Form
                document.getElementById('userModalTitle').innerText = user.name || user.first_name || 'Edit User';
                document.getElementById('userNameInput').value = user.name || (user.first_name + ' ' + (user.last_name || ''));
                document.getElementById('userUsernameInput').value = user.username || '';
                document.getElementById('userWaInput').value = user.whatsapp || '';
                document.getElementById('userRoleInput').value = user.role;
                document.getElementById('userPointsInput').value = user.points;
                
                const preview = document.getElementById('userPreview');
                if (user.avatar) {
                    preview.src = `/storage/${user.avatar}`;
                } else {
                    preview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name ?? user.username)}&size=200&background=2563eb&color=ffffff`;
                }

                form.action = `/admin/users/${user.id}`;
                deleteForm.action = `/admin/users/${user.id}`;

                openModal(modal);
            });
        });

        // Close buttons
        document.querySelectorAll('.js-close-modal').forEach(btn => {
            btn.addEventListener('click', (e) => {
                closeModal(modal);
            });
        });

        // Delete button
        document.getElementById('btnDeleteUser').addEventListener('click', () => {
            if (confirm('Hapus user ini secara permanen?')) {
                deleteForm.submit();
            }
        });

        // Close on backdrop click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal(modal);
        });
    });
</script>
@endsection
