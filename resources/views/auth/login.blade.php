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
            <div class="form-group">
                <label class="form-label">Email / Username</label>
                <input type="text" name="login" required class="form-input" placeholder="Masukkan email atau username" value="{{ old('login') }}">
                @error('login')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
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
