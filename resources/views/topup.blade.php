@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container">
        <div class="mb-12">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-primary transition-colors text-sm font-bold flex items-center gap-2">
                <span>←</span> KEMBALI KE BERANDA
            </a>
        </div>

        <!-- Top Up Wrapper -->
        <div style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 2.5rem; padding: 4rem; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.5); overflow: hidden;">
            
            <div style="text-align: center; margin-bottom: 5rem;">
                <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 900; letter-spacing: -0.04em; margin-bottom: 1rem;">Top Up <span>Poin Voting</span></h1>
                <p style="font-size: 1.125rem; color: var(--text-muted); max-width: 600px; margin: 0 auto;">Isi saldo poin Anda untuk memberikan dukungan kepada kandidat favorit.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 5rem; align-items: start;">
                <!-- LEFT: Packages -->
                <div>
                    <h3 style="font-size: 0.875rem; font-weight: 800; margin-bottom: 2.5rem; color: white; display: flex; align-items: center; gap: 1rem; text-transform: uppercase; letter-spacing: 2px;">
                        <span style="width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">1</span>
                        Pilih Paket Poin
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        @php
                            $packages = [
                                ['points' => 10, 'price' => 10000, 'label' => 'Basic'],
                                ['points' => 50, 'price' => 50000, 'label' => 'Popular'],
                                ['points' => 100, 'price' => 100000, 'label' => 'Premium'],
                                ['points' => 500, 'price' => 500000, 'label' => 'Ultimate'],
                            ];
                        @endphp

                        @foreach($packages as $pkg)
                            <div class="package-card" style="cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; border: 1px solid var(--border); background: rgba(255,255,255,0.02); padding: 2.5rem 1.5rem; border-radius: 2rem; text-align: center; overflow: hidden;" 
                                 onclick="selectPackage({{ $pkg['points'] }}, {{ $pkg['price'] }}, this)">
                                <span style="display: block; font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem; color: white;">{{ $pkg['points'] }}</span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px;">Points</span>
                                <div style="margin-top: 2rem; font-weight: 800; color: var(--primary); font-size: 1.125rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- RIGHT: Form -->
                <form action="{{ route('topup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nominal" id="inputNominal">
                    <input type="hidden" name="vote_point" id="inputPoints">

                    <h3 style="font-size: 0.875rem; font-weight: 800; margin-bottom: 2.5rem; color: white; display: flex; align-items: center; gap: 1rem; text-transform: uppercase; letter-spacing: 2px;">
                        <span style="width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">2</span>
                        Konfirmasi Pembayaran
                    </h3>
                    
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 2rem; padding: 3rem; margin-bottom: 3rem; position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 3rem; margin-bottom: 3rem;">
                            <div style="flex-grow: 1;">
                                <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); margin-bottom: 1rem; letter-spacing: 2px; text-transform: uppercase;">Transfer Ke Rekening BRI</div>
                                <div style="font-size: 2rem; font-weight: 900; letter-spacing: 3px; color: white; margin-bottom: 1rem; white-space: nowrap;">1234 5678 9012 345</div>
                                <div style="font-size: 15px; color: white; font-weight: 700;">A.N. PANITIA DUTA KAMPUS</div>
                            </div>
                            <div style="flex-shrink: 0; background: white; padding: 1rem; border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.3); text-align: center;">
                                <img src="{{ asset('qris/qris-dana.png') }}" style="width: 120px; height: 120px; display: block;">
                                <p style="font-size: 9px; font-weight: 900; color: #1e293b; margin-top: 10px; letter-spacing: 1px;">SCAN QRIS DANA</p>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 1.25rem; padding-top: 3rem; border-top: 1px dashed rgba(255,255,255,0.1);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-muted); font-size: 1rem; font-weight: 600;">Paket Poin Dipilih</span>
                                <span id="displayPoints" style="font-weight: 900; color: white; font-size: 1.25rem;">-</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-muted); font-size: 1.125rem; font-weight: 700;">Total Bayar</span>
                                <span id="displayTotal" style="color: var(--primary); font-size: 2.25rem; font-weight: 900;">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 2.5rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 2px;">Nama Pengirim (Sesuai Bukti)</label>
                        <input type="text" name="voter_name" required 
                               style="width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 1.25rem; padding: 1.25rem 1.5rem; color: white; font-size: 1rem; font-weight: 600; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'"
                               onblur="this.style.borderColor='var(--border)'"
                               placeholder="Masukkan nama pengirim transfer">
                    </div>

                    <div style="border: 2px dashed var(--border); border-radius: 2rem; padding: 4rem 2rem; text-align: center; cursor: pointer; transition: all 0.3s; margin-bottom: 3rem; background: rgba(255,255,255,0.01);"
                         onclick="document.getElementById('proofInput').click()"
                         onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(59, 130, 246, 0.05)'"
                         onmouseout="this.style.borderColor='var(--border)'; this.style.background='rgba(255,255,255,0.01)'">
                        <div style="font-size: 3rem; margin-bottom: 1.5rem;">📸</div>
                        <p style="font-weight: 800; font-size: 1rem; color: white; margin-bottom: 8px;">Upload Bukti Transfer</p>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Klik untuk memilih file (Maks 2MB)</p>
                        <input type="file" name="proof_image" id="proofInput" style="display: none;" required onchange="updateFileName(this)">
                        <div id="fileName" style="margin-top: 1.5rem; color: var(--primary); font-weight: 800; font-size: 0.875rem; background: rgba(59, 130, 246, 0.1); display: inline-block; padding: 8px 20px; border-radius: 30px; display: none;"></div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.5rem; font-size: 1rem; letter-spacing: 3px; font-weight: 900; text-transform: uppercase; border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(59, 130, 246, 0.25);">Konfirmasi Top Up</button>
                </form>
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
