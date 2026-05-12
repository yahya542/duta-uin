@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="modal max-w-md w-full animate-fade-in">
        <div class="text-center mb-10">
            <div class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4">Voter Portal</div>
            <h1 class="text-4xl font-black letter-spacing-tight mb-2">Welcome Back</h1>
            <p class="text-slate-400 text-sm">Please login to cast your vote.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
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
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-4 text-sm uppercase tracking-widest">Login</button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-500">Don't have an account? <a href="{{ route('register') }}" class="text-primary font-bold">Register here</a></p>
        </div>
    </div>
</div>
@endsection
