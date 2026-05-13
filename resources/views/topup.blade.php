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
        <div class="pricing-grid">
            @php
                $packages = [
                    ['name' => 'Starter', 'desc' => 'Dukungan awal untuk kandidat.', 'price' => 5000, 'points' => 1, 'features' => ['1x Poin Suara']],
                    ['name' => 'Lite', 'desc' => 'Pilihan praktis untuk supporter.', 'price' => 10000, 'points' => 2, 'features' => ['2x Poin Suara']],
                    ['name' => 'Popular', 'desc' => 'Dukungan yang signifikan.', 'price' => 25000, 'points' => 5, 'features' => ['5x Poin Suara']],
                    ['name' => 'Pro', 'desc' => 'Dukungan kuat untuk menang.', 'price' => 50000, 'points' => 10, 'features' => ['10x Poin Suara']],
                    ['name' => 'Ultra', 'desc' => 'Bawa kandidatmu ke puncak.', 'price' => 100000, 'points' => 20, 'features' => ['20x Poin Suara']],
                    ['name' => 'Whale', 'desc' => 'Dukungan maksimal tanpa batas.', 'price' => 250000, 'points' => 50, 'features' => ['50x Poin Suara']]
                ];
            @endphp

            @foreach($packages as $pkg)
                <div class="pricing-card" style="background: white; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2.5rem 1.5rem; display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
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
                    <button type="button" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; border-radius: 0.85rem; margin-bottom: 2rem;" onclick="scrollToForm({{ $pkg['points'] }}, {{ $pkg['price'] }}, '{{ $pkg['name'] }}')">Pilih Paket</button>
                    <div style="margin-top: auto;">
                        <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($pkg['features'] as $feature)
                                <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.75rem; color: var(--text-muted); font-weight: 500;">
                                    <div style="width: 16px; height: 16px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; box-shadow: 0 2px 5px rgba(251, 191, 36, 0.3);">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    </div>
                                    <span style="color: var(--text-main); font-weight: 800;">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Payment Confirmation Section -->
        <div id="payment-section" class="payment-section-wrapper">
            <div class="payment-card-inner">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: var(--primary);"></div>
                
                <form action="{{ route('topup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nominal" id="inputNominal">
                    <input type="hidden" name="vote_point" id="inputPoints">

                    <div class="payment-grid-layout">
                        <!-- QRIS & Info -->
                        <div class="payment-info-side">
                            <h2 class="payment-title">Konfirmasi <span>Pembayaran</span></h2>
                            <p class="payment-desc">Silakan scan kode QRIS di bawah ini atau transfer ke rekening yang tertera. Setelah transfer, upload bukti pembayaran Anda.</p>

                            <div class="qris-box">
                                <div class="qris-img-wrapper">
                                    <img src="{{ asset('qris/qris-dana.png') }}" class="qris-img">
                                </div>
                                <div class="qris-details">
                                    <span class="qris-label">Scan & Bayar Via</span>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" style="height: 20px; margin-bottom: 1rem;">
                                    <div class="rek-pill">Rek: 6281932551947</div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Details -->
                        <div class="payment-form-side">
                            <div class="summary-box">
                                <div class="summary-row">
                                    <span class="summary-label">Paket Dipilih</span>
                                    <span id="selectedPackageName" class="summary-value-primary">Pilih Paket Di Atas</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Total Poin</span>
                                    <span id="displayPoints" class="summary-value">-</span>
                                </div>
                                <div class="summary-row-total">
                                    <span class="total-label">Total Bayar</span>
                                    <span id="displayTotal" class="total-value">Rp 0</span>
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label class="field-label">Nama Pengirim</label>
                                <input type="text" name="voter_name" required class="form-input-custom" placeholder="Nama sesuai bukti transfer">
                            </div>

                            <div class="form-group-custom">
                                <label class="field-label">Bukti Transfer</label>
                                <div style="position: relative;">
                                    <input type="file" name="proof_image" id="proofInput" required style="position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 10;" onchange="updateFileName(this)">
                                    <div id="fileDisplay" class="file-dropzone">
                                        <div id="uploadPlaceholder" class="placeholder-content">
                                            <div class="upload-icon-circle">
                                                <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4" /></svg>
                                            </div>
                                            <span id="fileName" class="placeholder-text">Pilih file foto bukti transfer...</span>
                                        </div>
                                        <img id="imagePreview" class="preview-img">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary submit-topup-btn">Konfirmasi Top Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<style>
    /* Responsive Grid */
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 6rem;
        align-items: stretch;
    }

    /* Payment Section Responsive */
    .payment-section-wrapper {
        scroll-margin-top: 100px;
        max-width: 1000px;
        margin: 0 auto 8rem;
    }
    .payment-card-inner {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 2.5rem;
        padding: 4rem;
        box-shadow: 0 40px 100px rgba(0,0,0,0.06);
        position: relative;
        overflow: hidden;
    }
    .payment-grid-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
    }

    .payment-title { font-size: 1.75rem; font-weight: 900; margin-bottom: 1.5rem; }
    .payment-title span { color: var(--primary); }
    .payment-desc { color: var(--text-muted); margin-bottom: 3rem; line-height: 1.6; }

    .qris-box { background: #f8fafc; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; display: flex; align-items: center; gap: 2rem; }
    .qris-img-wrapper { background: white; padding: 0.75rem; border-radius: 1rem; border: 1.5px solid var(--border); box-shadow: 0 10px 20px rgba(0,0,0,0.04); flex-shrink: 0; }
    .qris-img { width: 140px; height: 140px; border-radius: 0.5rem; display: block; }
    .qris-details { flex-grow: 1; }
    .qris-label { display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.5rem; }
    .rek-pill { background: white; border: 1px solid var(--border); padding: 0.5rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; color: var(--text-main); display: inline-block; }

    .payment-form-side { background: #f8fafc; border: 1px solid var(--border); border-radius: 2rem; padding: 2.5rem; }
    .summary-box { margin-bottom: 2rem; border-bottom: 2px dashed var(--border); padding-bottom: 1.5rem; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
    .summary-label { font-size: 0.875rem; font-weight: 700; color: var(--text-muted); }
    .summary-value-primary { font-size: 0.875rem; font-weight: 900; color: var(--primary); }
    .summary-value { font-size: 0.875rem; font-weight: 900; color: var(--text-main); }
    .summary-row-total { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .total-label { font-size: 1.125rem; font-weight: 800; color: var(--text-main); }
    .total-value { font-size: 1.5rem; font-weight: 900; color: var(--text-main); }

    .form-group-custom { margin-bottom: 1.5rem; }
    .field-label { display: block; font-size: 0.65rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem; }
    .form-input-custom { width: 100%; background: white; border: 1px solid var(--border); border-radius: 1rem; padding: 1rem; color: var(--text-main); font-size: 0.875rem; font-weight: 600; outline: none; }
    .form-input-custom:focus { border-color: var(--primary); }

    .file-dropzone { background: white; border: 1.5px solid var(--border); padding: 1rem; border-radius: 1rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; transition: all 0.2s; }
    .placeholder-content { display: flex; align-items: center; gap: 1rem; width: 100%; }
    .upload-icon-circle { width: 32px; height: 32px; background: rgba(37, 99, 235, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .placeholder-text { font-size: 0.8125rem; font-weight: 700; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .preview-img { display: none; width: 100%; max-height: 200px; object-fit: contain; border-radius: 0.75rem; border: 1px solid var(--border); margin-top: 0.5rem; }

    .submit-topup-btn { width: 100%; padding: 0.875rem; font-size: 0.8125rem; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; border-radius: 1rem; }

    /* MOBILE ADJUSTMENTS */
    @media (max-width: 768px) {
        .pricing-grid { grid-template-columns: 1fr; }
        .payment-card-inner { padding: 2rem 1.25rem; border-radius: 1.5rem; }
        .payment-grid-layout { grid-template-columns: 1fr; gap: 2rem; }
        .payment-info-side { text-align: center; }
        .payment-title { font-size: 1.35rem; }
        .payment-desc { font-size: 0.8125rem; margin-bottom: 1.5rem; }
        
        .qris-box { flex-direction: column; padding: 1.25rem; gap: 1.25rem; }
        .qris-img { width: 100%; height: auto; max-width: 160px; margin: 0 auto; }
        .qris-details { text-align: center; width: 100%; }
        
        .payment-form-side { padding: 1.25rem; border-radius: 1.25rem; }
        .total-value { font-size: 1.25rem; }
        
        .placeholder-text { font-size: 0.75rem; }
        .submit-topup-btn { padding: 0.75rem; font-size: 0.75rem; }
    }

    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.1) !important;
        border-color: var(--primary) !important;
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
