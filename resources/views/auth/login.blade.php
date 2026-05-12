@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="modal max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="hero-title text-3xl">ADMIN <span>PORTAL</span></h1>
            <p class="section-desc">Silakan login untuk mengelola sistem voting.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gold tracking-widest uppercase mb-2">EMAIL ADDRESS</label>
                <input type="email" name="email" required 
                       class="w-full bg-navy-3 border border-slate-700 rounded-xl p-4 text-cream focus:border-gold outline-none transition-all" 
                       placeholder="admin@example.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-gold tracking-widest uppercase mb-2">PASSWORD</label>
                <input type="password" name="password" required 
                       class="w-full bg-navy-3 border border-slate-700 rounded-xl p-4 text-cream focus:border-gold outline-none transition-all" 
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-400 cursor-pointer">
                    <input type="checkbox" class="accent-gold"> Ingat Saya
                </label>
                <a href="#" class="text-gold hover:text-gold-light">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-primary w-full py-4 text-lg">MASUK KE DASHBOARD</button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-800 text-center">
            <p class="text-xs text-slate-500 italic">© 2026 UIN Madura - Official Voting System</p>
        </div>
    </div>
</div>
@endsection
