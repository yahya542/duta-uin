@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container">
        <div class="mb-12">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-primary transition-colors text-sm font-bold flex items-center gap-2">
                <span>←</span> KEMBALI KE BERANDA
            </a>
        </div>

        <div style="display: grid; grid-template-cols: 1fr 2fr; gap: 4rem; align-items: start;">
            <!-- LEFT: Candidate Detail -->
            <div class="stat-card" style="padding: 0; overflow: hidden; text-align: left;">
                <div style="height: 340px; background: #1e293b;">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=1e293b&color=3b82f6' }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="padding: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem;">{{ $candidate->name }}</h2>
                    <p style="color: var(--text-muted); font-size: 0.875rem; line-height: 1.6; margin-bottom: 2rem;">{{ $candidate->description }}</p>
                    
                    <div style="padding-top: 1.5rem; border-top: 1px solid var(--border);">
                        <span style="font-size: 0.625rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Total Suara Terkumpul</span>
                        <span style="font-size: 2rem; font-weight: 900; color: var(--primary);">{{ number_format($candidate->total_votes) }}</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Voting Workflow -->
            <div style="display: flex; flex-direction: column; gap: 3rem;">
                
                <!-- STEP 1: Select Package -->
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                        <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">1</span>
                        Pilih Paket Vote
                    </h3>
                    
                    <div style="display: grid; grid-template-cols: repeat(4, 1fr); gap: 1rem;">
                        @php
                            $packages = [
                                ['points' => 10, 'price' => 10000, 'label' => 'Basic'],
                                ['points' => 50, 'price' => 50000, 'label' => 'Popular', 'popular' => true],
                                ['points' => 100, 'price' => 100000, 'label' => 'Premium'],
                                ['points' => 500, 'price' => 500000, 'label' => 'Ultimate'],
                            ];
                        @endphp

                        @foreach($packages as $pkg)
                            <div class="stat-card" style="cursor: pointer; transition: all 0.2s; position: relative; {{ isset($pkg['popular']) ? 'border-color: var(--primary);' : '' }}" 
                                 onclick="selectPackage({{ $pkg['points'] }}, {{ $pkg['price'] }}, this)"
                                 class="package-card">
                                @if(isset($pkg['popular']))
                                    <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px;">BEST VALUE</span>
                                @endif
                                <span style="display: block; font-size: 1.5rem; font-weight: 900; margin-bottom: 0.25rem;">{{ $pkg['points'] }}</span>
                                <span style="font-size: 0.625rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Points</span>
                                <div style="margin-top: 1rem; font-weight: 800; color: var(--primary); font-size: 0.875rem;">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 2: Payment Detail -->
                <form action="{{ route('votes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                    <input type="hidden" name="nominal" id="inputNominal">
                    <input type="hidden" name="vote_point" id="inputPoints">

                    <div style="display: flex; flex-direction: column; gap: 3rem;">
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                                <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">2</span>
                                Konfirmasi Pembayaran
                            </h3>
                            
                            <div class="stat-card" style="display: grid; grid-template-cols: 1fr 1fr; gap: 2rem; text-align: left; align-items: center;">
                                <div>
                                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem;">
                                        <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); margin-bottom: 4px;">TRANSFER KE BRI</div>
                                        <div style="font-size: 1.25rem; font-weight: 900; letter-spacing: 1px;">1234-5678-9012-345</div>
                                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">A.N. PANITIA DUTA KAMPUS</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                                            <span style="color: var(--text-muted);">Points</span>
                                            <span id="displayPoints" style="font-weight: 800;">-</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 900;">
                                            <span>Total</span>
                                            <span id="displayTotal" style="color: var(--primary);">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="background: white; padding: 0.75rem; border-radius: 1rem; display: inline-block; margin-bottom: 0.5rem;">
                                        <img src="{{ asset('qris/qris-dana.png') }}" style="width: 140px; height: 140px;">
                                    </div>
                                    <p style="font-size: 10px; font-weight: 800; color: var(--text-muted);">SCAN QRIS DANA</p>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: Upload Proof -->
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                                <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">3</span>
                                Kirim Bukti & Vote
                            </h3>
                            
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group">
                                    <label class="form-label">Nama Sesuai Rekening/Bukti</label>
                                    <input type="text" name="voter_name" required class="form-input" placeholder="Nama pengirim transfer">
                                </div>

                                <div style="border: 2px dashed var(--border); border-radius: 1.5rem; padding: 3rem; text-align: center; cursor: pointer; transition: background 0.2s;"
                                     onclick="document.getElementById('proofInput').click()"
                                     onmouseover="this.style.background='rgba(255,255,255,0.02)'"
                                     onmouseout="this.style.background='transparent'">
                                    <span style="font-size: 2rem; display: block; margin-bottom: 1rem;">📸</span>
                                    <p style="font-weight: 700; font-size: 0.875rem;">Klik untuk Upload Bukti Transfer</p>
                                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">JPG, PNG (Maks 2MB)</p>
                                    <input type="file" name="proof_image" id="proofInput" style="display: none;" required onchange="updateFileName(this)">
                                    <div id="fileName" style="margin-top: 1rem; color: var(--primary); font-weight: 800; font-size: 0.875rem;"></div>
                                </div>

                                <button type="submit" class="btn btn-primary" style="padding: 1.25rem; font-size: 1rem; letter-spacing: 1px;">KONFIRMASI VOTE</button>
                            </div>
                        </div>
                    </div>
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
        document.getElementById('displayPoints').innerText = points + ' Points';
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
        document.getElementById('displayTotal').innerText = formattedPrice;

        document.querySelectorAll('.package-card').forEach(card => card.style.borderColor = 'var(--border)');
        el.style.borderColor = 'var(--primary)';
    }

    function updateFileName(input) {
        const name = input.files[0] ? input.files[0].name : '';
        document.getElementById('fileName').innerText = 'Terpilih: ' + name;
    }
</script>
@endpush
@endsection
