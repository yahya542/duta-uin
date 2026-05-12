@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join the voting community today.</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-cols: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Nama Depan</label>
                    <input type="text" name="first_name" required class="form-input" placeholder="Depan" value="{{ old('first_name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" required class="form-input" placeholder="Belakang" value="{{ old('last_name') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" required class="form-input" placeholder="Pilih username" value="{{ old('username') }}">
                @error('username') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" required class="form-input" placeholder="name@example.com" value="{{ old('email') }}">
                @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nomor WhatsApp</label>
                <input type="text" name="whatsapp" required class="form-input" placeholder="08xxxxxxxxx" value="{{ old('whatsapp') }}">
                @error('whatsapp') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-input" placeholder="Min. 8 characters">
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="form-input" placeholder="Repeat password">
            </div>

            <button type="submit" class="btn-submit">Register Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}" class="auth-link">Login here</a>
        </div>
    </div>
</div>
@endsection
