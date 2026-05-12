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
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" required class="form-input" placeholder="Your full name">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" required class="form-input" placeholder="name@example.com">
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
