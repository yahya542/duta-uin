@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container" style="max-width: 900px;">
        <div class="text-center mb-16">
            <h1 class="hero-title">Panduan <span>Voting</span></h1>
            <p class="hero-desc">Ikuti langkah-langkah di bawah ini untuk memberikan dukungan kepada kandidat favorit Anda.</p>
        </div>

        <div class="leaderboard-container" style="padding: 4rem 3rem;">
            <!-- Step 1 -->
            <div style="display: flex; gap: 2rem; margin-bottom: 4rem; align-items: flex-start;">
                <div style="flex-shrink: 0; width: 60px; height: 60px; background: var(--primary); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 900; color: white; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);">1</div>
                <div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.75rem;">Buat Akun / Masuk</h3>
                    <p style="color: var(--text-muted); line-height: 1.8;">Klik tombol <strong>Daftar</strong> jika Anda belum memiliki akun, atau <strong>Login</strong> jika sudah pernah mendaftar. Pastikan data diri Anda valid agar proses verifikasi berjalan lancar.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div style="display: flex; gap: 2rem; margin-bottom: 4rem; align-items: flex-start;">
                <div style="flex-shrink: 0; width: 60px; height: 60px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 900; color: var(--text-muted);">2</div>
                <div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.75rem;">Pilih Kandidat Favorit</h3>
                    <p style="color: var(--text-muted); line-height: 1.8;">Jelajahi halaman utama untuk melihat daftar kandidat <strong>Putra</strong> dan <strong>Putri</strong>. Anda bisa melihat profil dan perolehan suara sementara mereka di Leaderboard.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div style="display: flex; gap: 2rem; margin-bottom: 4rem; align-items: flex-start;">
                <div style="flex-shrink: 0; width: 60px; height: 60px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 900; color: var(--text-muted);">3</div>
                <div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.75rem;">Lakukan Top-Up Poin</h3>
                    <p style="color: var(--text-muted); line-height: 1.8;">Klik tombol <strong>Vote Sekarang</strong> pada kandidat pilihan. Anda akan diarahkan ke halaman pembayaran. Pilih paket poin yang diinginkan, lakukan pembayaran melalui <strong>QRIS</strong> atau <strong>Transfer Bank</strong>, lalu unggah bukti pembayaran.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div style="display: flex; gap: 2rem; align-items: flex-start;">
                <div style="flex-shrink: 0; width: 60px; height: 60px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 900; color: var(--text-muted);">4</div>
                <div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.75rem;">Tunggu Verifikasi Admin</h3>
                    <p style="color: var(--text-muted); line-height: 1.8;">Setelah mengunggah bukti, Admin akan memverifikasi transaksi Anda. Jika disetujui, poin voting Anda akan otomatis masuk ke kandidat tersebut dan leaderboard akan diperbarui secara real-time.</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('home') }}" class="btn btn-primary px-8 py-3">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
