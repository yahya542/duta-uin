@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="modal max-w-md w-full animate-fade-in">
        <div class="text-center mb-10">
            <div class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4">Join Us</div>
            <h1 class="text-4xl font-black letter-spacing-tight mb-2">Create Account</h1>
            <p class="text-slate-400 text-sm">Join the voting community today.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Full Name</label>
                <input type="text" name="name" required 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all" 
                       placeholder="Enter your name">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email Address</label>
                <input type="email" name="email" required 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all" 
                       placeholder="you@example.com">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Password</label>
                <input type="password" name="password" required 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all" 
                       placeholder="Min. 8 characters">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all" 
                       placeholder="Repeat password">
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-4 text-sm uppercase tracking-widest">Register</button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-500">Already have an account? <a href="{{ route('login') }}" class="text-primary font-bold">Login here</a></p>
        </div>
    </div>
</div>
@endsection
