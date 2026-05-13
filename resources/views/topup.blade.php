@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container">
        <div class="mb-12">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-primary transition-colors text-sm font-bold flex items-center gap-2">
                <span>←</span> KEMBALI KE BERANDA
            </a>
        </div>

        <div class="auth-container" style="max-width: 900px; margin: 0 auto;">
            <div class="auth-card" style="width: 100%;">
                <div class="auth-header">
                    <h1 class="auth-title">Top Up <span>Poin Voting</span></h1>
                    <p class="auth-subtitle">Isi saldo poin Anda untuk memberikan dukungan kepada kandidat favorit.</p>
                </div>

                <div class="payment-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; text-align: left;">
                    <!-- LEFT: Packages -->
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem; color: white;">1. Pilih Paket Poin</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            @php
                                $packages = [
                                    ['points' => 10, 'price' => 10000, 'label' => 'Basic'],
                                    ['points' => 50, 'price' => 50000, 'label' => 'Popular', 'popular' => true],
                                    ['points' => 100, 'price' => 100000, 'label' => 'Premium'],
                                    ['points' => 500, 'price' => 500000, 'label' => 'Ultimate'],
                                ];
                            @endphp

                            @foreach($packages as $pkg)
                                <div class="stat-card package-card" style="cursor: pointer; transition: all 0.2s; position: relative; border: 1px solid var(--border); background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: 1rem; text-align: center;" 
                                     onclick="selectPackage({{ $pkg['points'] }}, {{ $pkg['price'] }}, this)">
                                    @if(isset($pkg['popular']))
                                        <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; font-size: 8px; font-weight: 900; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">Terpopuler</span>
                                    @endif
                                    <span style="display: block; font-size: 1.5rem; font-weight: 900; margin-bottom: 0.25rem;">{{ $pkg['points'] }}</span>
                                    <span style="font-size: 0.625rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Points</span>
                                    <div style="margin-top: 1rem; font-weight: 800; color: var(--primary); font-size: 0.875rem;">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- RIGHT: Form -->
                    <form action="{{ route('topup.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nominal" id="inputNominal">
                        <input type="hidden" name="vote_point" id="inputPoints">

                        <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem; color: white;">2. Konfirmasi Transfer</h3>
                        
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                                <div>
                                    <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); margin-bottom: 4px;">TRANSFER KE BRI</div>
                                    <div style="font-size: 1.25rem; font-weight: 900; letter-spacing: 1px; color: white;">1234-5678-9012-345</div>
                                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">A.N. PANITIA DUTA KAMPUS</div>
                                </div>
                                <div style="background: white; padding: 0.5rem; border-radius: 0.75rem;">
                                    <img src="{{ asset('qris/qris-dana.png') }}" style="width: 80px; height: 80px;">
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                                <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                                    <span style="color: var(--text-muted);">Points yang dibeli</span>
                                    <span id="displayPoints" style="font-weight: 800; color: white;">-</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 900;">
                                    <span style="color: white;">Total Bayar</span>
                                    <span id="displayTotal" style="color: var(--primary);">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Pengirim (Sesuai Bukti)</label>
                            <input type="text" name="voter_name" required class="form-input" placeholder="Contoh: Ahmad Fauzi">
                        </div>

                        <div style="border: 2px dashed var(--border); border-radius: 1rem; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.2s; margin-bottom: 1.5rem;"
                             onclick="document.getElementById('proofInput').click()"
                             onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(59, 130, 246, 0.05)'"
                             onmouseout="this.style.borderColor='var(--border)'; this.style.background='transparent'">
                            <p style="font-weight: 700; font-size: 0.8125rem; color: var(--text-muted);">Klik untuk Upload Bukti Transfer</p>
                            <input type="file" name="proof_image" id="proofInput" style="display: none;" required onchange="updateFileName(this)">
                            <div id="fileName" style="margin-top: 0.5rem; color: var(--primary); font-weight: 800; font-size: 0.75rem;"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 0.875rem; letter-spacing: 1px;">KONFIRMASI TOP UP</button>
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
        });
        el.style.borderColor = 'var(--primary)';
        el.style.background = 'rgba(59, 130, 246, 0.05)';
    }

    function updateFileName(input) {
        const name = input.files[0] ? input.files[0].name : '';
        document.getElementById('fileName').innerText = '📁 ' + name;
    }
</script>
@endpush
@endsection
