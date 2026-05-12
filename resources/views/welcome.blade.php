@extends('layouts.app')

@section('content')
<div class="hero">
    <div class="hero-logos animate-bounce-subtle">
        <img src="https://ui-avatars.com/api/?name=UIN&size=200&background=0D1B2A&color=C9A84C" alt="Logo UIN">
        <div class="logo-sep"></div>
        <img src="https://ui-avatars.com/api/?name=DK&size=200&background=C9A84C&color=0D1B2A" class="duta-img" alt="Logo Duta">
    </div>

    <div class="hero-badge">
        <span class="dot"></span>
        VOTING SEDANG BERLANGSUNG
    </div>

    <h1 class="hero-title">PILIH <span>DUTA FAVORIT</span><br>ANDA SEKARANG</h1>
    <p class="hero-sub">Dukung kandidat terbaik untuk mewakili UIN Madura dalam kancah nasional dan internasional tahun 2026.</p>

    <div class="divider-ornament">
        <span class="diamond">◆</span>
    </div>
</div>

<div class="stats-bar">
    <div class="stat-item">
        <span class="stat-num">{{ $candidates->count() }}</span>
        <span class="stat-label">KANDIDAT</span>
    </div>
    <div class="stat-item">
        <span class="stat-num" id="total-votes-display">{{ number_format($totalVotes) }}</span>
        <span class="stat-label">TOTAL SUARA</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">2026</span>
        <span class="stat-label">TAHUN EVENT</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">30</span>
        <span class="stat-label">HARI LAGI</span>
    </div>
</div>

<section id="leaderboard" class="section">
    <h2 class="section-title">DAFTAR KANDIDAT</h2>
    <p class="section-desc">Pilih salah satu kandidat di bawah ini untuk memberikan dukungan suara Anda.</p>

    <div class="tab-bar">
        <button class="tab-btn active">SEMUA KANDIDAT</button>
        <button class="tab-btn">PUTRA</button>
        <button class="tab-btn">PUTRI</button>
    </div>

    <div class="candidates-grid">
        @foreach($candidates as $candidate)
            <div class="candidate-card" onclick="window.location='{{ route('votes.payment', $candidate->id) }}'">
                <div class="candidate-banner">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=1E3A55&color=C9A84C' }}" 
                         alt="{{ $candidate->name }}" 
                         class="w-full h-full object-cover opacity-80">
                    
                    <div class="candidate-num">#0{{ $loop->iteration }}</div>
                    
                    <div class="candidate-type-badge {{ $loop->even ? 'badge-putri' : 'badge-putra' }}">
                        {{ $loop->even ? 'PUTRI' : 'PUTRA' }}
                    </div>
                </div>

                <div class="candidate-body">
                    <h3 class="candidate-name">{{ $candidate->name }}</h3>
                    
                    <div class="vote-progress-bar">
                        <div id="candidate-bar-{{ $candidate->id }}" 
                             class="vote-progress-fill" 
                             style="width: {{ $candidate->percentage }}%"></div>
                    </div>
                    
                    <div class="vote-meta">
                        <span class="vote-pct"><span id="candidate-percentage-{{ $candidate->id }}">{{ number_format($candidate->percentage, 1) }}</span>%</span>
                        <span class="text-xs text-slate-400 font-medium"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span> Suara</span>
                    </div>

                    <button class="btn-vote">BERIKAN VOTE</button>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="tutorial" class="section">
    <h2 class="section-title">CARA MELAKUKAN VOTE</h2>
    <p class="section-desc">Ikuti langkah-langkah mudah di bawah ini untuk mendukung kandidat pilihan Anda.</p>

    <div class="tutorial-steps">
        <div class="step-card">
            <span class="step-num">STEP 01</span>
            <span class="step-icon">👤</span>
            <h3 class="step-title">Pilih Kandidat</h3>
            <p class="step-desc">Tentukan duta favorit Anda dari daftar kandidat yang tersedia.</p>
        </div>
        <div class="step-card">
            <span class="step-num">STEP 02</span>
            <span class="step-icon">💰</span>
            <h3 class="step-title">Pilih Paket</h3>
            <p class="step-desc">Pilih jumlah poin vote yang ingin Anda berikan (1 Poin = Rp 1.000).</p>
        </div>
        <div class="step-card">
            <span class="step-num">STEP 03</span>
            <span class="step-icon">📲</span>
            <h3 class="step-title">Pembayaran</h3>
            <p class="step-desc">Scan QRIS DANA atau transfer manual ke rekening yang tersedia.</p>
        </div>
        <div class="step-card">
            <span class="step-num">STEP 04</span>
            <span class="step-icon">📄</span>
            <h3 class="step-title">Konfirmasi</h3>
            <p class="step-desc">Upload bukti transfer. Admin akan memvalidasi suara Anda segera.</p>
        </div>
    </div>
</section>

@push('scripts')
<script type="module">
    window.addEventListener('load', () => {
        if (window.Echo) {
            window.Echo.channel('voting-channel')
                .listen('.vote.updated', (e) => {
                    console.log('Vote updated:', e);
                    
                    const totalVotesEl = document.getElementById('total-votes-display');
                    if (totalVotesEl) {
                        totalVotesEl.innerText = new Intl.NumberFormat('id-ID').format(e.totalVotes);
                    }

                    e.candidates.forEach(candidate => {
                        const percentEl = document.getElementById(`candidate-percentage-${candidate.id}`);
                        const barEl = document.getElementById(`candidate-bar-${candidate.id}`);
                        const votesEl = document.getElementById(`candidate-votes-${candidate.id}`);

                        if (percentEl) percentEl.innerText = candidate.percentage.toFixed(1);
                        if (barEl) barEl.style.width = `${candidate.percentage}%`;
                        if (votesEl) votesEl.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes);
                    });
                });
        }
    });
</script>
@endpush
@endsection
