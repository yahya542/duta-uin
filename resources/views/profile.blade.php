@extends('layouts.app')

@section('title', 'Profil Saya — VOTE DUTA KAMPUS')

@section('content')
<div style="background-color: #f1f5f9; min-height: 100vh; padding-top: 8rem; padding-bottom: 5rem;">
    <div class="container">
        <div class="profile-layout" style="max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 300px 1fr; gap: 2.5rem; align-items: start;">
            
            <!-- Sidebar Profile -->
            <div class="profile-side">
                <div class="admin-card" style="background: #ffffff; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2.5rem 2rem; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.04); position: sticky; top: 110px;">
                    <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 1.5rem;">
                        <img id="profilePreview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200&background=2563eb&color=ffffff' }}" 
                             style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 10px 40px rgba(37, 99, 235, 0.15);">
                        <label for="avatarInput" style="position: absolute; bottom: 5px; right: 5px; width: 40px; height: 40px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 4px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </label>
                    </div>
                    <h2 style="font-size: 1.35rem; font-weight: 900; color: var(--text-main); margin-bottom: 0.25rem;">{{ $user->name }}</h2>
                    <p style="font-size: 0.75rem; color: var(--primary); font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; background: rgba(37, 99, 235, 0.08); display: inline-block; padding: 0.35rem 1rem; border-radius: 2rem;">{{ $user->role }}</p>
                    
                    <div style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1.5px solid #f1f5f9; text-align: left;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                            <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted);">ID USER</span>
                            <span style="font-size: 0.75rem; font-weight: 900; color: var(--text-main);">#{{ $user->id }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted);">SALDO POIN</span>
                            <span style="font-size: 0.85rem; font-weight: 900; color: var(--primary);">{{ number_format($user->points) }} PTS</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="profile-main">
                <div class="admin-card" style="background: #ffffff; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                    <h1 style="font-size: 1.75rem; font-weight: 900; color: var(--text-main); margin-bottom: 2.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="color: var(--primary);"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Pengaturan Akun
                    </h1>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <input type="file" id="avatarInput" name="avatar" hidden accept="image/*" onchange="previewImage(this)">

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                            <div>
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="form-input">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Nomor WhatsApp (Opsional)</label>
                                <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="Contoh: 08123456789" class="form-input">
                            </div>
                        </div>

                        <div style="margin-top: 3.5rem; border-top: 2px solid #f1f5f9; padding-top: 2.5rem; margin-bottom: 2rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="color: var(--text-muted);"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                <h3 style="font-size: 1.1rem; font-weight: 900; color: var(--text-main);">Ganti Kata Sandi</h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem; font-weight: 600;">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                            
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

                        <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 3rem;">
                            <a href="{{ route('home') }}" class="btn btn-outline" style="padding: 0.85rem 1.75rem; font-weight: 800;">Batal</a>
                            <button type="submit" class="btn btn-primary" style="padding: 0.85rem 2.5rem; font-weight: 800; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
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
        font-weight: 900;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.65rem;
    }
    .form-input {
        width: 100%;
        padding: 1rem 1.15rem;
        border-radius: 1rem;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        font-size: 0.95rem;
        color: var(--text-main);
        font-weight: 600;
        outline: none;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .form-input:focus {
        border-color: var(--primary);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        transform: translateY(-1px);
    }
    @media (max-width: 900px) {
        .profile-layout { grid-template-columns: 1fr; }
        .profile-side .admin-card { position: static; }
    }
</style>
@endsection
