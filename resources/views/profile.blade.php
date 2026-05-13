@extends('layouts.app')

@section('title', 'Profil Saya — VOTE DUTA KAMPUS')

@section('content')
<div class="container" style="padding-top: 8rem; padding-bottom: 5rem;">
    <div class="profile-layout" style="max-width: 800px; margin: 0 auto; display: grid; grid-template-columns: 280px 1fr; gap: 2rem; align-items: start;">
        
        <!-- Sidebar Profile -->
        <div class="profile-side">
            <div class="admin-card admin-card-pad text-center" style="position: sticky; top: 100px;">
                <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 1.5rem;">
                    <img id="profilePreview" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200&background=2563eb&color=ffffff' }}" 
                         style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <label for="avatarInput" style="position: absolute; bottom: 0; right: 0; width: 36px; height: 36px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </label>
                </div>
                <h2 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
                <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">{{ $user->role }}</p>
                
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); text-align: left;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                        <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted);">ID USER</span>
                        <span style="font-size: 0.75rem; font-weight: 900;">#{{ $user->id }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted);">SALDO POIN</span>
                        <span style="font-size: 0.75rem; font-weight: 900; color: var(--primary);">{{ number_format($user->points) }} PTS</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="profile-main">
            <div class="admin-card admin-card-pad">
                <h1 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 2rem;">Pengaturan Akun</h1>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="voter-form">
                    @csrf
                    @method('PUT')
                    
                    <input type="file" id="avatarInput" name="avatar" hidden accept="image/*" onchange="previewImage(this)">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="form-input">
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label">Nomor WhatsApp (Opsional)</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="Contoh: 08123456789" class="form-input">
                    </div>

                    <div style="margin-top: 3rem; border-top: 1px solid var(--border); padding-top: 2rem; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1rem; font-weight: 900; margin-bottom: 1rem;">Ganti Kata Sandi</h3>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.5rem;">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label class="form-label">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" class="form-input">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <a href="{{ route('home') }}" class="btn btn-outline" style="padding: 0.75rem 1.5rem;">Batal</a>
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        padding: 0.85rem 1rem;
        border-radius: 0.85rem;
        border: 1px solid var(--border);
        background: #f8fafc;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
    }
    .form-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.04);
    }
    @media (max-width: 800px) {
        .profile-layout { grid-template-columns: 1fr; }
        .profile-side .admin-card { position: static; }
    }
</style>
@endsection
