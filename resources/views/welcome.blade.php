@extends('layouts.app')

@section('content')
<div class="hero">
    <div class="hero-badge animate-fade-in">
        LIVE VOTING SYSTEM 2026
    </div>

    <h1 class="hero-title animate-fade-in">Pilih <span>Duta Favorit</span><br>Anda Sekarang</h1>
    <p class="hero-sub animate-fade-in">Dukung kandidat terbaik untuk mewakili UIN Madura dalam kancah nasional dan internasional tahun 2026.</p>

    <div class="flex gap-4 animate-fade-in">
        <a href="#leaderboard" class="btn-primary">Mulai Vote</a>
        <a href="#tutorial" class="btn-secondary">Cara Vote</a>
    </div>
</div>

<div class="stats-bar section px-4">
    <div class="stat-item">
        <span class="stat-num">{{ $candidates->count() }}</span>
        <span class="stat-label">Kandidat</span>
    </div>
    <div class="stat-item">
        <span class="stat-num" id="total-votes-display">{{ number_format($totalVotes) }}</span>
        <span class="stat-label">Total Suara</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">2026</span>
        <span class="stat-label">Tahun</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">30</span>
        <span class="stat-label">Hari Lagi</span>
    </div>
</div>

<section id="leaderboard" class="section">
    <h2 class="section-title">Kandidat Duta</h2>
    <p class="section-desc">Pilih salah satu kandidat di bawah ini untuk memberikan dukungan suara Anda.</p>

    <div class="candidates-grid">
        @foreach($candidates as $candidate)
            <div class="candidate-card" 
                 onclick="window.location='{{ Auth::check() ? route('votes.payment', $candidate->id) : route('login') }}'">
                <div class="candidate-banner">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=1e293b&color=3b82f6' }}" 
                         alt="{{ $candidate->name }}">
                    
                    <div class="candidate-num">#0{{ $loop->iteration }}</div>
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

                    <button class="btn-primary w-full justify-center mt-6">Berikan Vote</button>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="tutorial" class="section bg-slate-900/20">
    <h2 class="section-title">Cara Melakukan Vote</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-12">
        <div class="stat-item">
            <span class="text-2xl mb-2 block">👤</span>
            <h3 class="font-bold mb-2">Pilih</h3>
            <p class="text-xs text-slate-400">Pilih kandidat favorit Anda dari daftar.</p>
        </div>
        <div class="stat-item">
            <span class="text-2xl mb-2 block">💰</span>
            <h3 class="font-bold mb-2">Paket</h3>
            <p class="text-xs text-slate-400">Pilih jumlah poin vote yang diinginkan.</p>
        </div>
        <div class="stat-item">
            <span class="text-2xl mb-2 block">📲</span>
            <h3 class="font-bold mb-2">Bayar</h3>
            <p class="text-xs text-slate-400">Transfer atau Scan QRIS yang tersedia.</p>
        </div>
        <div class="stat-item">
            <span class="text-2xl mb-2 block">📄</span>
            <h3 class="font-bold mb-2">Kirim</h3>
            <p class="text-xs text-slate-400">Upload bukti. Suara akan divalidasi admin.</p>
        </div>
    </div>
</section>

<footer class="py-12 border-t border-white/5 text-center">
    <p class="text-slate-500 text-sm">© 2026 UIN Madura. Built with Precision.</p>
</footer>

@push('scripts')
<script type="module">
    window.addEventListener('load', () => {
        if (window.Echo) {
            window.Echo.channel('voting-channel')
                .listen('.vote.updated', (e) => {
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
