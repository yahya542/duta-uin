@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container">
        <div class="mb-12">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-primary transition-colors text-sm font-bold flex items-center gap-2">
                <span>←</span> KEMBALI KE BERANDA
            </a>
        </div>

        <div class="auth-container" style="max-width: 1000px; margin: 0 auto;">
            <div class="auth-card" style="width: 100%; padding: 3rem;">
                <div class="auth-header" style="margin-bottom: 4rem;">
                    <h1 class="auth-title" style="font-size: 2.5rem;">Top Up <span>Poin Voting</span></h1>
                    <p class="auth-subtitle">Isi saldo poin Anda untuk memberikan dukungan kepada kandidat favorit.</p>
                </div>

                <div class="payment-grid" style="display: grid; grid-template-columns: 1.2fr 1.8fr; gap: 4rem; text-align: left; align-items: start;">
                    <!-- LEFT: Packages -->
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 800; margin-bottom: 2rem; color: white; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="width: 24px; height: 24px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem;">1</span>
                            PILIH PAKET POIN
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            @php
                                $packages = [
                                    ['points' => 10, 'price' => 10000, 'label' => 'Basic'],
                                    ['points' => 50, 'price' => 50000, 'label' => 'Popular', 'popular' => true],
                                    ['points' => 100, 'price' => 100000, 'label' => 'Premium'],
                                    ['points' => 500, 'price' => 500000, 'label' => 'Ultimate'],
                                ];
                            @endphp

                            @foreach($packages as $pkg)
                                <div class="stat-card package-card" style="cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; border: 1px solid var(--border); background: rgba(255,255,255,0.02); padding: 2rem 1.5rem; border-radius: 1.5rem; text-align: center; overflow: hidden;" 
                                     onclick="selectPackage({{ $pkg['points'] }}, {{ $pkg['price'] }}, this)">
                                    @if(isset($pkg['popular']))
                                        <div style="position: absolute; top: 0; left: 0; right: 0; background: var(--primary); color: white; font-size: 8px; font-weight: 900; padding: 4px 0; text-transform: uppercase; letter-spacing: 1px;">TERPOPULER</div>
                                    @endif
                                    <span style="display: block; font-size: 2rem; font-weight: 900; margin-bottom: 0.25rem; color: white;">{{ $pkg['points'] }}</span>
                                    <span style="font-size: 0.625rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px;">Points</span>
                                    <div style="margin-top: 1.5rem; font-weight: 800; color: var(--primary); font-size: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- RIGHT: Form -->
                    <form action="{{ route('topup.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nominal" id="inputNominal">
                        <input type="hidden" name="vote_point" id="inputPoints">

                        <h3 style="font-size: 1rem; font-weight: 800; margin-bottom: 2rem; color: white; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="width: 24px; height: 24px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem;">2</span>
                            KONFIRMASI PEMBAYARAN
                        </h3>
                        
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; margin-bottom: 2rem; position: relative; overflow: hidden;">
                            <div style="display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: center; margin-bottom: 2rem;">
                                <div>
                                    <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); margin-bottom: 8px; letter-spacing: 1px;">TRANSFER KE REKENING BRI</div>
                                    <div style="font-size: 1.5rem; font-weight: 900; letter-spacing: 2px; color: white; margin-bottom: 8px;">1234 5678 9012 345</div>
                                    <div style="font-size: 13px; color: white; font-weight: 600;">A.N. PANITIA DUTA KAMPUS</div>
                                </div>
                                <div style="background: white; padding: 0.75rem; border-radius: 1.25rem; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                                    <img src="{{ asset('qris/qris-dana.png') }}" style="width: 100px; height: 100px; display: block;">
                                    <p style="font-size: 8px; font-weight: 900; color: #1e293b; text-align: center; margin-top: 8px;">SCAN QRIS DANA</p>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.75rem; padding-top: 2rem; border-top: 1px dashed var(--border);">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">Paket Poin</span>
                                    <span id="displayPoints" style="font-weight: 800; color: white; font-size: 1rem;">-</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="color: var(--text-muted); font-size: 1rem; font-weight: 700;">Total Pembayaran</span>
                                    <span id="displayTotal" style="color: var(--primary); font-size: 1.5rem; font-weight: 900;">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label class="form-label" style="margin-bottom: 0.75rem;">Nama Pengirim Sesuai Bukti</label>
                            <input type="text" name="voter_name" required class="form-input" placeholder="Masukkan nama lengkap Anda" style="padding: 1rem 1.25rem; font-size: 0.875rem;">
                        </div>

                        <div style="border: 2px dashed var(--border); border-radius: 1.25rem; padding: 2.5rem; text-align: center; cursor: pointer; transition: all 0.3s; margin-bottom: 2rem; background: rgba(255,255,255,0.01);"
                             onclick="document.getElementById('proofInput').click()"
                             onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(59, 130, 246, 0.05)'"
                             onmouseout="this.style.borderColor='var(--border)'; this.style.background='rgba(255,255,255,0.01)'">
                            <div style="font-size: 2rem; margin-bottom: 1rem;">📄</div>
                            <p style="font-weight: 800; font-size: 0.875rem; color: white; margin-bottom: 4px;">Upload Bukti Transfer</p>
                            <p style="font-size: 0.75rem; color: var(--text-muted);">Format JPG, PNG (Maks 2MB)</p>
                            <input type="file" name="proof_image" id="proofInput" style="display: none;" required onchange="updateFileName(this)">
                            <div id="fileName" style="margin-top: 1rem; color: var(--primary); font-weight: 800; font-size: 0.8125rem; background: rgba(59, 130, 246, 0.1); display: inline-block; padding: 4px 12px; border-radius: 20px; display: none;"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.25rem; font-size: 0.9375rem; letter-spacing: 2px; font-weight: 900; text-transform: uppercase; border-radius: 1rem; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);">KONFIRMASI TOP UP SEKARANG</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function selectPackage(points, price, el) {
        document.getElementById('inputNominal').value = price;
        document.getElementById('inputPoints').value = points;
        document.getElementById('displayPoints').innerText = points + ' PTS';
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
        document.getElementById('displayTotal').innerText = formattedPrice;

        document.querySelectorAll('.package-card').forEach(card => {
            card.style.borderColor = 'var(--border)';
            card.style.background = 'rgba(255,255,255,0.02)';
            card.style.transform = 'scale(1)';
        });
        el.style.borderColor = 'var(--primary)';
        el.style.background = 'rgba(59, 130, 246, 0.05)';
        el.style.transform = 'scale(1.05)';
    }

    function updateFileName(input) {
        const name = input.files[0] ? input.files[0].name : '';
        const el = document.getElementById('fileName');
        if (name) {
            el.innerText = '📁 ' + name;
            el.style.display = 'inline-block';
        } else {
            el.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
