@extends('layouts.app')

@section('content')
<section class="candidate-section pt-32">
    <div class="container">
        <!-- TOP: Leaderboard Podium -->
        <div class="section-header">
            <h2 class="section-title">Leaderboard Podium</h2>
            <p class="text-slate-400">Tiga kandidat dengan perolehan suara tertinggi saat ini.</p>
        </div>

        @php
            $top1 = $candidates->get(0);
            $top2 = $candidates->get(1);
            $top3 = $candidates->get(2);
            $remaining = $candidates->slice(3);
        @endphp

        <div class="podium-wrapper">
            <!-- Rank 2 -->
            @if($top2)
            <div class="podium-item podium-rank-2" onclick="window.location='{{ Auth::check() ? route('votes.payment', $top2->id) : route('login') }}'">
                <div class="podium-card">
                    <div class="podium-medal">🥈</div>
                    <div class="podium-img">
                        <img src="{{ $top2->photo ? asset('storage/' . $top2->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($top2->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $top2->name }}">
                    </div>
                    <div class="podium-info">
                        <h3 class="podium-name">{{ $top2->name }}</h3>
                        <p class="podium-votes"><span id="candidate-votes-{{ $top2->id }}">{{ number_format($top2->total_votes) }}</span> SUARA</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Rank 1 -->
            @if($top1)
            <div class="podium-item podium-rank-1" onclick="window.location='{{ Auth::check() ? route('votes.payment', $top1->id) : route('login') }}'">
                <div class="podium-card">
                    <div class="podium-medal">🥇</div>
                    <div class="podium-img">
                        <img src="{{ $top1->photo ? asset('storage/' . $top1->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($top1->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $top1->name }}">
                    </div>
                    <div class="podium-info">
                        <h3 class="podium-name">{{ $top1->name }}</h3>
                        <p class="podium-votes"><span id="candidate-votes-{{ $top1->id }}">{{ number_format($top1->total_votes) }}</span> SUARA</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Rank 3 -->
            @if($top3)
            <div class="podium-item podium-rank-3" onclick="window.location='{{ Auth::check() ? route('votes.payment', $top3->id) : route('login') }}'">
                <div class="podium-card">
                    <div class="podium-medal">🥉</div>
                    <div class="podium-img">
                        <img src="{{ $top3->photo ? asset('storage/' . $top3->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($top3->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $top3->name }}">
                    </div>
                    <div class="podium-info">
                        <h3 class="podium-name">{{ $top3->name }}</h3>
                        <p class="podium-votes"><span id="candidate-votes-{{ $top3->id }}">{{ number_format($top3->total_votes) }}</span> SUARA</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- MIDDLE: Stats Bar -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value">{{ $candidates->count() }}</span>
                <span class="stat-label">Kandidat</span>
            </div>
            <div class="stat-card">
                <span class="stat-value" id="total-votes-display">{{ number_format($totalVotes) }}</span>
                <span class="stat-label">Total Suara</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">2026</span>
                <span class="stat-label">Tahun</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">30</span>
                <span class="stat-label">Hari Lagi</span>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="text-center mb-24">
            <h1 class="hero-title">Pilih <span>Duta Favorit</span> Anda Sekarang</h1>
            <p class="hero-desc" style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">Dukung kandidat terbaik untuk mewakili UIN Madura dalam kancah nasional dan internasional tahun 2026.</p>
        </div>

        <!-- BOTTOM: Remaining Candidates -->
        @if($remaining->count() > 0)
        <div class="section-header">
            <h3 class="text-xl font-bold">Kandidat Lainnya</h3>
        </div>
        <div class="grid-candidates">
            @foreach($remaining as $candidate)
                <div class="card-candidate" onclick="window.location='{{ Auth::check() ? route('votes.payment', $candidate->id) : route('login') }}'">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}" alt="{{ $candidate->name }}">
                    <div class="flex-1">
                        <h4 class="candidate-name">{{ $candidate->name }}</h4>
                        <p class="candidate-meta"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span> Suara • #0{{ $loop->iteration + 3 }}</p>
                    </div>
                    <div class="text-primary font-black">
                        <span id="candidate-percentage-{{ $candidate->id }}">{{ number_format($candidate->percentage, 1) }}</span>%
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script type="module">
    window.addEventListener('load', () => {
        if (window.Echo) {
            window.Echo.channel('voting-channel').listen('.vote.updated', (e) => {
                const totalVotesEl = document.getElementById('total-votes-display');
                if (totalVotesEl) totalVotesEl.innerText = new Intl.NumberFormat('id-ID').format(e.totalVotes);

                e.candidates.forEach(candidate => {
                    const percentEls = document.querySelectorAll(`[id^="candidate-percentage-${candidate.id}"]`);
                    const votesEls = document.querySelectorAll(`[id^="candidate-votes-${candidate.id}"]`);

                    percentEls.forEach(el => el.innerText = candidate.percentage.toFixed(1));
                    votesEls.forEach(el => el.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes));
                });
            });
        }
    });
</script>
@endpush
@endsection
