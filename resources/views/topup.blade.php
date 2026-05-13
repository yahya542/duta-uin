@extends('layouts.app')

@section('content')
<section class="topup-pricing-section" style="padding-top: 72px;">
    <!-- Blue Header Area -->
    <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 6rem 0 12rem; text-align: center; color: white;">
        <div class="container">
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; letter-spacing: -0.04em; margin-bottom: 1.5rem;">Dukung Kandidat Favoritmu</h1>
            <p style="font-size: 1.25rem; opacity: 0.9; max-width: 700px; margin: 0 auto; line-height: 1.6;">Pilih paket poin voting di bawah ini untuk membantu kandidat jagoanmu memenangkan Duta Kampus UIN Madura 2026.</p>
        </div>
    </div>

    <div class="container" style="margin-top: -8rem;">
        <!-- Pricing Grid -->
        <div class="pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 6rem; align-items: stretch;">
            @php
                $packages = [
                    [
                        'name' => 'Starter',
                        'desc' => 'Dukungan awal untuk kandidat.',
                        'price' => 5000,
                        'points' => 1,
                        'features' => ['1x Poin Suara']
                    ],
                    [
                        'name' => 'Lite',
                        'desc' => 'Pilihan praktis untuk supporter.',
                        'price' => 10000,
                        'points' => 2,
                        'features' => ['2x Poin Suara']
                    ],
                    [
                        'name' => 'Popular',
                        'desc' => 'Dukungan yang signifikan.',
                        'price' => 25000,
                        'points' => 5,
                        'features' => ['5x Poin Suara']
                    ],
                    [
                        'name' => 'Pro',
                        'desc' => 'Dukungan kuat untuk menang.',
                        'price' => 50000,
                        'points' => 10,
                        'features' => ['10x Poin Suara']
                    ],
                    [
                        'name' => 'Ultra',
                        'desc' => 'Bawa kandidatmu ke puncak.',
                        'price' => 100000,
                        'points' => 20,
                        'features' => ['20x Poin Suara']
                    ],
                    [
                        'name' => 'Whale',
                        'desc' => 'Dukungan maksimal tanpa batas.',
                        'price' => 250000,
                        'points' => 50,
                        'features' => ['50x Poin Suara']
                    ]
                ];
            @endphp

            @foreach($packages as $pkg)
                <div class="pricing-card" 
                     style="background: white; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2.5rem 1.5rem; display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--text-main); margin-bottom: 0.5rem;">{{ $pkg['name'] }}</h3>
                        <p style="font-size: 0.8125rem; color: var(--text-muted); line-height: 1.4;">{{ $pkg['desc'] }}</p>
                    </div>

                    <div style="text-align: center; margin-bottom: 2.5rem;">
                        <div style="display: flex; align-items: baseline; justify-content: center; gap: 0.25rem;">
                            <span style="font-size: 1rem; font-weight: 700; color: var(--text-main);">Rp</span>
                            <span style="font-size: 2.75rem; font-weight: 900; color: var(--text-main); line-height: 1;">{{ number_format($pkg['price']/1000, 0) }}k</span>
                        </div>
                        <p style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-top: 0.5rem; letter-spacing: 1px;">{{ $pkg['points'] }} Voting Points</p>
                    </div>

                    <button type="button" class="btn btn-primary" 
                            style="width: 100%; padding: 1rem; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; border-radius: 0.85rem; margin-bottom: 2rem;"
                            onclick="scrollToForm({{ $pkg['points'] }}, {{ $pkg['price'] }}, '{{ $pkg['name'] }}')">
                        Pilih Paket
                    </button>

                    <div style="margin-top: auto;">
                        <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($pkg['features'] as $feature)
                                <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.75rem; color: var(--text-muted); font-weight: 500;">
                                    @if(str_contains($feature, 'Poin Suara'))
                                        <div style="width: 16px; height: 16px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; box-shadow: 0 2px 5px rgba(251, 191, 36, 0.3);">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        </div>
                                        <span style="color: var(--text-main); font-weight: 800;">{{ $feature }}</span>
                                    @else
                                        <svg style="width: 14px; height: 14px; color: #10b981; flex-shrink: 0; margin-top: 1px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $feature }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Payment Confirmation Section (Appears after selection) -->
        <div id="payment-section" style="scroll-margin-top: 100px; max-width: 1000px; margin: 0 auto 8rem;">
            <div style="background: white; border: 1.5px solid var(--border); border-radius: 2.5rem; padding: 4rem; box-shadow: 0 40px 100px rgba(0,0,0,0.06); position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: var(--primary);"></div>
                
                <form action="{{ route('topup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nominal" id="inputNominal">
                    <input type="hidden" name="vote_point" id="inputPoints">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
                        <!-- QRIS & Info -->
                        <div>
                            <h2 style="font-size: 1.75rem; font-weight: 900; margin-bottom: 1.5rem;">Konfirmasi <span>Pembayaran</span></h2>
                            <p style="color: var(--text-muted); margin-bottom: 3rem; line-height: 1.6;">Silakan scan kode QRIS di bawah ini atau transfer ke rekening yang tertera. Setelah transfer, upload bukti pembayaran Anda.</p>

                            <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 2rem;">
                                <div style="background: white; padding: 0.75rem; border-radius: 1rem; border: 1.5px solid var(--border); box-shadow: 0 10px 20px rgba(0,0,0,0.04);">
                                    <img src="{{ asset('qris/qris-dana.png') }}" style="width: 140px; height: 140px; border-radius: 0.5rem;">
                                </div>
                                <div>
                                    <span style="display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.5rem;">Scan & Bayar Via</span>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" style="height: 24px; margin-bottom: 1.5rem;">
                                    <div style="background: white; border: 1px solid var(--border); padding: 0.5rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; color: var(--text-main);">Rek: 6281932551947</div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Details -->
                        <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: 2rem; padding: 2.5rem;">
                            <div style="margin-bottom: 2.5rem; border-bottom: 2px dashed var(--border); padding-bottom: 2rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">Paket Dipilih</span>
                                    <span id="selectedPackageName" style="font-size: 1rem; font-weight: 900; color: var(--primary);">Pilih Paket Di Atas</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">Total Poin</span>
                                    <span id="displayPoints" style="font-size: 1rem; font-weight: 900; color: var(--text-main);">-</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 1.125rem; font-weight: 800; color: var(--text-main);">Total Bayar</span>
                                    <span id="displayTotal" style="font-size: 1.5rem; font-weight: 900; color: var(--text-main);">Rp 0</span>
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-size: 0.65rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem;">Nama Pengirim</label>
                                <input type="text" name="voter_name" required class="form-input" placeholder="Nama sesuai bukti transfer">
                            </div>

                            <div style="margin-bottom: 2rem;">
                                <label style="display: block; font-size: 0.65rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem;">Bukti Transfer</label>
                                <div style="position: relative;">
                                    <input type="file" name="proof_image" id="proofInput" required style="position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 10;" onchange="updateFileName(this)">
                                    <div id="fileDisplay" style="background: white; border: 1.5px solid var(--border); padding: 1rem; border-radius: 1rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; transition: all 0.2s;">
                                        <div id="uploadPlaceholder" style="display: flex; align-items: center; gap: 1rem; width: 100%;">
                                            <div style="width: 32px; height: 32px; background: rgba(37, 99, 235, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4" /></svg>
                                            </div>
                                            <span id="fileName" style="font-size: 0.8125rem; font-weight: 700; color: var(--text-muted);">Pilih file foto bukti transfer...</span>
                                        </div>
                                        <img id="imagePreview" style="display: none; width: 100%; max-height: 300px; object-fit: contain; border-radius: 0.75rem; border: 1px solid var(--border); margin-top: 0.5rem;">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.25rem; font-size: 0.9375rem; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; border-radius: 1.25rem;">Konfirmasi Top Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<style>
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.1) !important;
        border-color: var(--primary) !important;
    }
    .pricing-card.is-popular:hover {
        transform: translateY(-10px) scale(1.03) !important;
    }
    .pricing-tab.active {
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
    }
</style>
<script>
    function scrollToForm(points, price, name) {
        document.getElementById('inputNominal').value = price;
        document.getElementById('inputPoints').value = points;
        document.getElementById('displayPoints').innerText = points + ' PTS';
        document.getElementById('selectedPackageName').innerText = name;
        
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
        document.getElementById('displayTotal').innerText = formattedPrice;

        document.getElementById('payment-section').scrollIntoView({ behavior: 'smooth' });
        
        // Visual feedback on selected card
        document.querySelectorAll('.pricing-card').forEach(card => {
            card.style.borderColor = 'var(--border)';
        });
        const selectedCard = event.currentTarget.closest('.pricing-card');
        selectedCard.style.borderColor = 'var(--primary)';
    }

    function updateFileName(input) {
        const file = input.files[0];
        const fileName = document.getElementById('fileName');
        const preview = document.getElementById('imagePreview');
        const display = document.getElementById('fileDisplay');
        const placeholder = document.getElementById('uploadPlaceholder');

        if (file) {
            fileName.innerText = file.name;
            fileName.style.color = 'var(--text-main)';
            display.style.borderColor = 'var(--primary)';
            display.style.background = 'rgba(37, 99, 235, 0.03)';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.marginBottom = '0.5rem';
            }
            reader.readAsDataURL(file);
        } else {
            fileName.innerText = 'Pilih file foto bukti transfer...';
            preview.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
