@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Login to your account to continue.</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email / Username</label>
                <input type="text" name="login" required class="form-input" placeholder="Email or username" value="{{ old('login') }}">
                @error('login')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-input" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Login to Account</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register here</a>
        </div>
    </div>
</div>
@endsection
