@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mb-8">
        <a href="{{ route('home') }}" class="btn-secondary">← KEMBALI</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Candidate Info -->
        <div class="lg:col-span-1">
            <div class="candidate-card selected">
                <div class="candidate-banner h-64">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=1E3A55&color=C9A84C' }}" 
                         alt="{{ $candidate->name }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="candidate-body">
                    <div class="hero-badge mb-2">TARGET VOTE</div>
                    <h3 class="candidate-name text-2xl">{{ $candidate->name }}</h3>
                    <p class="text-sm text-slate-400 italic mb-4">"{{ $candidate->description }}"</p>
                    
                    <div class="vote-meta border-t border-slate-700 pt-4">
                        <span class="text-slate-400">Total Suara Saat Ini</span>
                        <span class="vote-pct">{{ number_format($candidate->total_votes) }}</span>
                    </div>
                </div>
            </div>

            <div class="note-box mt-6">
                <h4>PENTING!</h4>
                <ul>
                    <li>Pastikan nominal transfer sesuai dengan paket yang dipilih.</li>
                    <li>Sertakan nama lengkap Anda pada kolom pengirim.</li>
                    <li>Admin akan melakukan verifikasi maksimal 1x24 jam.</li>
                </ul>
            </div>
        </div>

        <!-- Voting Flow -->
        <div class="lg:col-span-2">
            <h2 class="section-title text-left ml-0 mb-4">LANGKAH 01: PILIH PAKET VOTE</h2>
            
            <div class="packages-grid mb-12">
                @php
                    $packages = [
                        ['points' => 10, 'price' => 10000, 'label' => 'STARTER'],
                        ['points' => 50, 'price' => 50000, 'label' => 'POPULAR', 'popular' => true],
                        ['points' => 100, 'price' => 100000, 'label' => 'PRO'],
                        ['points' => 500, 'price' => 500000, 'label' => 'ELITE'],
                    ];
                @endphp

                @foreach($packages as $pkg)
                    <div class="pkg-card {{ isset($pkg['popular']) ? 'popular' : '' }}" 
                         onclick="selectPackage({{ $pkg['points'] }}, {{ $pkg['price'] }}, this)">
                        @if(isset($pkg['popular']))
                            <div class="pkg-popular-badge">PALING POPULER</div>
                        @endif
                        <span class="pkg-points">{{ $pkg['points'] }}</span>
                        <span class="pkg-label">{{ $pkg['label'] }}</span>
                        <div class="pkg-price">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</div>
                        <span class="pkg-note">Poin Vote</span>
                    </div>
                @endforeach
            </div>

            <form action="{{ route('votes.store') }}" method="POST" enctype="multipart/form-data" id="voteForm">
                @csrf
                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                <input type="hidden" name="nominal" id="inputNominal">
                <input type="hidden" name="vote_point" id="inputPoints">

                <div x-data="{ step: 1 }">
                    <div class="mb-8">
                        <h2 class="section-title text-left ml-0 mb-4">LANGKAH 02: DETAIL PEMBAYARAN</h2>
                        
                        <div class="payment-box">
                            <div class="payment-info">
                                <h3>TRANSFER MANUAL / QRIS</h3>
                                
                                <div class="bank-row">
                                    <div class="bank-logo bank-bri">BRI</div>
                                    <div class="bank-detail">
                                        <div class="bank-name">BANK BRI</div>
                                        <div class="bank-number">1234-5678-9012-345</div>
                                        <div class="bank-holder">A.N. PANITIA DUTA KAMPUS</div>
                                    </div>
                                    <button type="button" class="copy-btn">SALIN</button>
                                </div>

                                <div class="calc-box">
                                    <h4>RINCIAN PEMBAYARAN</h4>
                                    <div class="calc-row">
                                        <span class="calc-label">Paket Dipilih</span>
                                        <span class="calc-val" id="displayPoints">0 Poin</span>
                                    </div>
                                    <div class="calc-row">
                                        <span class="calc-label">Subtotal</span>
                                        <span class="calc-val" id="displayPrice">Rp 0</span>
                                    </div>
                                    <div class="calc-row calc-total-row">
                                        <span class="calc-label">TOTAL TRANSFER</span>
                                        <span class="calc-val" id="displayTotal">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="qr-section">
                                <span class="qr-label">SCAN QRIS DANA</span>
                                <div class="qr-frame">
                                    <img src="{{ asset('qris/qris-dana.png') }}" alt="QRIS DANA">
                                </div>
                                <p class="qr-sub">Scan melalui aplikasi DANA,<br>OVO, GoPay, atau LinkAja</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="section-title text-left ml-0 mb-4">LANGKAH 03: KONFIRMASI TRANSFER</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-400 mb-2">NAMA LENGKAP PENGIRIM</label>
                            <input type="text" name="voter_name" required 
                                   class="w-full bg-navy-2 border border-slate-700 rounded-lg p-3 text-cream focus:border-gold outline-none" 
                                   placeholder="Masukkan nama sesuai bukti transfer">
                        </div>

                        <div class="upload-area" onclick="document.getElementById('proofInput').click()">
                            <span class="upload-icon">📁</span>
                            <div class="upload-text">Klik untuk <strong>Upload Bukti Transfer</strong></div>
                            <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                            <input type="file" name="proof_image" id="proofInput" class="hidden" required onchange="updateFileName(this)">
                            <div id="fileName" class="mt-2 text-gold font-medium"></div>
                        </div>

                        <div class="flex flex-col gap-4 mt-8">
                            <button type="submit" class="btn-primary w-full justify-center text-lg py-4">KIRIM VOTE SEKARANG</button>
                            <p class="text-center text-xs text-slate-500">Dengan menekan tombol di atas, Anda setuju dengan syarat dan ketentuan voting.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function selectPackage(points, price, el) {
        // Update inputs
        document.getElementById('inputNominal').value = price;
        document.getElementById('inputPoints').value = points;

        // Update display
        document.getElementById('displayPoints').innerText = points + ' Poin';
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
        document.getElementById('displayPrice').innerText = formattedPrice;
        document.getElementById('displayTotal').innerText = formattedPrice;

        // Visual feedback
        document.querySelectorAll('.pkg-card').forEach(card => card.classList.remove('popular'));
        el.classList.add('popular');
        
        // Scroll to details
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function updateFileName(input) {
        const name = input.files[0] ? input.files[0].name : '';
        document.getElementById('fileName').innerText = name;
    }
</script>
@endpush
@endsection
