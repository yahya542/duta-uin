@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Selamat Datang</h1>
            <p class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan voting.</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            @error('login')
                <div class="error-alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <div class="form-group">
                <label class="form-label">Email / Username</label>
                <input type="text" name="login" required class="form-input" placeholder="Masukkan email atau username" value="{{ old('login') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" required class="form-input" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Masuk ke Akun</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar di sini</a>
        </div>
    </div>
</div>
@endsection
