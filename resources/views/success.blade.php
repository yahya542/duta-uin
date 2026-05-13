@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card text-center" style="max-width: 600px;">
        <div class="mb-8 flex justify-center">
            <div style="width: 80px; height: 80px; background: rgba(34, 197, 94, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(34, 197, 94, 0.2);">
                <svg style="width: 40px; height: 40px; color: #22c55e;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        
        <h1 class="auth-title" style="font-size: 2.5rem; margin-bottom: 1rem;">Terima Kasih!</h1>
        <p class="auth-subtitle" style="margin-bottom: 3rem;">Bukti transfer Anda telah berhasil diunggah. Silakan selesaikan langkah terakhir untuk mempercepat verifikasi.</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 3rem;">
            <a href="{{ $waUrl }}" target="_blank" style="text-decoration: none; display: block;">
                <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; transition: all 0.3s; height: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.03);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.03)'">
                    <div style="width: 48px; height: 48px; background: #22c55e; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 15px rgba(34, 197, 94, 0.2);">
                        <svg style="width: 24px; height: 24px; color: white;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </div>
                    <h3 style="color: var(--text-main); font-weight: 900; font-size: 1.15rem; margin-bottom: 0.5rem;">Kirim ke WhatsApp</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 700;">Konfirmasi manual ke Admin</p>
                </div>
            </a>

            <a href="{{ $gformUrl }}" target="_blank" style="text-decoration: none; display: block;">
                <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; transition: all 0.3s; height: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.03);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.03)'">
                    <div style="width: 48px; height: 48px; background: var(--primary); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.2);">
                        <svg style="width: 24px; height: 24px; color: white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 style="color: var(--text-main); font-weight: 900; font-size: 1.15rem; margin-bottom: 0.5rem;">Isi Google Form</h3>
                    <p style="color: var(--text-muted); font-size: 0.75rem;">Lengkapi data tambahan</p>
                </div>
            </a>
        </div>

        <div style="margin-top: 2rem;">
            <a href="{{ route('home') }}#leaderboard" class="btn btn-primary" style="width: 100%; padding: 1.25rem; font-size: 1rem; margin-bottom: 1rem; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);">Selesai & Mulai Voting</a>
            <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; font-weight: 700;">Kembali ke Beranda</a>
        </div>
    </div>
</div>

<style>
@media (max-width: 640px) {
    .auth-card { padding: 2rem 1.5rem !important; }
    div[style*="grid-template-cols: 1fr 1fr"] { grid-template-cols: 1fr !important; }
}
</style>
@endsection
