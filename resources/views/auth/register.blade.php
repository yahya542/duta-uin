@extends('layouts.app')

@section('content')
<div class="auth-container" x-data="{ 
    step: 1, 
    firstName: '{{ old('first_name') }}', 
    lastName: '{{ old('last_name') }}', 
    username: '{{ old('username') }}',
    email: '{{ old('email') }}',
    whatsapp: '{{ old('whatsapp') }}',
    password: '',
    confirmPassword: '',
    errorMsg: '',
    validateStep1() {
        this.errorMsg = '';
        if (!this.firstName || !this.lastName || !this.username) {
            this.errorMsg = 'Harap isi semua kolom data pribadi.';
            return;
        }
        this.step = 2;
    },
    validateStep2() {
        this.errorMsg = '';
        if (!this.email || !this.whatsapp || !this.password || !this.confirmPassword) {
            this.errorMsg = 'Harap isi semua kolom kontak dan keamanan.';
            return;
        }
        if (this.password.length < 8) {
            this.errorMsg = 'Password minimal 8 karakter.';
            return;
        }
        if (this.password !== this.confirmPassword) {
            this.errorMsg = 'Konfirmasi password tidak cocok.';
            return;
        }
        this.step = 3;
    }
}">
    <div class="auth-card" style="max-width: 500px;">
        <!-- Stepper -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 3rem; position: relative;">
            <div style="position: absolute; top: 12px; left: 0; right: 0; height: 2px; background: var(--border); z-index: 1;"></div>
            <div :style="'position: absolute; top: 12px; left: 0; height: 2px; background: var(--primary); z-index: 2; transition: width 0.3s; width: ' + ((step-1)*50) + '%'"></div>
            
            <template x-for="i in [1, 2, 3]">
                <div style="position: relative; z-index: 3; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                    <div class="step-circle"
                         :style="step >= i ? 'background: var(--primary); border-color: var(--primary); color: white;' : 'background: var(--bg-card); border-color: rgba(255,255,255,0.2); color: var(--text-muted);'">
                        <span x-show="step <= i" x-text="i"></span>
                        <span x-show="step > i">✓</span>
                    </div>
                    <span style="font-size: 9px; font-weight: 700; text-transform: uppercase; color: var(--text-muted);" 
                          x-text="i == 1 ? 'Pribadi' : (i == 2 ? 'Akun' : 'Review')"></span>
                </div>
            </template>
        </div>

        <div class="auth-header">
            <h1 class="auth-title" x-show="step == 1">Data Pribadi</h1>
            <h1 class="auth-title" x-show="step == 2">Kontak & Keamanan</h1>
            <h1 class="auth-title" x-show="step == 3">Ringkasan Data</h1>
            <p class="auth-subtitle">Silakan isi formulir pendaftaran bertahap.</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <!-- STEP 1: PRIBADI -->
            <div x-show="step == 1" x-transition>
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label class="form-label">Nama Depan</label>
                        <input type="text" name="first_name" x-model="firstName" required class="form-input" placeholder="Depan">
                    </div>
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label class="form-label">Nama Belakang</label>
                        <input type="text" name="last_name" x-model="lastName" required class="form-input" placeholder="Belakang">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" x-model="username" required class="form-input" placeholder="Pilih username">
                    @error('username') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <template x-if="errorMsg && step == 1">
                    <div class="error-alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span x-text="errorMsg"></span>
                    </div>
                </template>

                <button type="button" @click="validateStep1()" class="btn-submit">Lanjutkan <span>→</span></button>
            </div>

            <!-- STEP 2: KONTAK & AKUN -->
            <div x-show="step == 2" x-transition x-cloak>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" x-model="email" required class="form-input" placeholder="name@example.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" x-model="whatsapp" required class="form-input" placeholder="08xxxxxxxxx">
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" x-model="password" required class="form-input" placeholder="Min. 8 karakter">
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" x-model="confirmPassword" required class="form-input" placeholder="Ulangi password">
                </div>

                <template x-if="errorMsg && step == 2">
                    <div class="error-alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span x-text="errorMsg"></span>
                    </div>
                </template>

                <div style="display: grid; grid-template-cols: 1fr 2fr; gap: 1rem;">
                    <button type="button" @click="step = 1; errorMsg = ''" class="btn-submit" style="background: rgba(255,255,255,0.05); color: white;">Kembali</button>
                    <button type="button" @click="validateStep2()" class="btn-submit">Lanjutkan <span>→</span></button>
                </div>
            </div>

            <!-- STEP 3: REVIEW -->
            <div x-show="step == 3" x-transition x-cloak>
                <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                        <span style="color: var(--text-muted);">Nama Lengkap</span>
                        <span style="font-weight: 700;" x-text="firstName + ' ' + lastName"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                        <span style="color: var(--text-muted);">Username</span>
                        <span style="font-weight: 700;" x-text="'@' + username"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                        <span style="color: var(--text-muted);">Email</span>
                        <span style="font-weight: 700;" x-text="email"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                        <span style="color: var(--text-muted);">WhatsApp</span>
                        <span style="font-weight: 700;" x-text="whatsapp"></span>
                    </div>
                </div>

                <p style="font-size: 11px; color: var(--text-muted); text-align: center; margin-bottom: 1.5rem;">Dengan mendaftar, Anda menyetujui syarat dan ketentuan voting Duta Kampus 2026.</p>

                <div style="display: grid; grid-template-cols: 1fr 2fr; gap: 1rem;">
                    <button type="button" @click="step = 2; errorMsg = ''" class="btn-submit" style="background: rgba(255,255,255,0.05); color: white;">Kembali</button>
                    <button type="submit" class="btn-submit">Daftar Sekarang</button>
                </div>
            </div>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
.step-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border-width: 2px;
    border-style: solid;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 900;
    transition: all 0.3s;
    z-index: 10;
}
</style>
@endsection
