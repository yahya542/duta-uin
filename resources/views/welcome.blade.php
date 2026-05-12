@extends('layouts.app')

@section('content')
<section class="candidate-section" x-data="{ category: 'putra' }">
    <div class="container">
        <!-- Hero Content -->
        <div class="text-center mb-16">
            <h1 class="hero-title">Pilih <span>Duta Favorit</span> Anda Sekarang</h1>
            <p class="hero-desc" style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">Dukung kandidat terbaik untuk mewakili UIN Madura dalam kancah nasional dan internasional tahun 2026.</p>
        </div>

        <!-- Category Tabs -->
        <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 4rem;">
            <button @click="category = 'putra'" 
                    :class="category === 'putra' ? 'btn-primary' : 'btn-outline'"
                    class="btn px-8 py-3 text-sm tracking-widest font-black uppercase">
                Duta Putra
            </button>
            <button @click="category = 'putri'" 
                    :class="category === 'putri' ? 'btn-primary' : 'btn-outline'"
                    class="btn px-8 py-3 text-sm tracking-widest font-black uppercase">
                Duta Putri
            </button>
        </div>

        <!-- Stats Bar -->
        <div class="stats-grid mb-12">
            <div class="stat-card">
                <span class="stat-value">{{ $putra->count() + $putri->count() }}</span>
                <span class="stat-label">Total Kandidat</span>
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

        <!-- PUTRA SECTION -->
        <div x-show="category === 'putra'" x-transition>
            @php
                $topPutra = $putra->take(3);
                $remainingPutra = $putra->slice(3);
                $p1 = $topPutra->get(0);
                $p2 = $topPutra->get(1);
                $p3 = $topPutra->get(2);
            @endphp
            
            <div class="section-header">
                <h2 class="section-title">Leaderboard Putra</h2>
                <p class="text-slate-400">Kandidat putra dengan perolehan suara tertinggi.</p>
            </div>

            <div class="podium-wrapper">
                @if($p2)
                <div class="podium-item podium-rank-2">
                    <div class="podium-card">
                        <div class="podium-medal">🥈</div>
                        <div class="podium-img">
                            <img src="{{ $p2->photo ? asset('storage/' . $p2->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p2->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p2->name }}">
                        </div>
                        <div class="podium-info">
                            <h3 class="podium-name">{{ $p2->name }}</h3>
                            <p class="podium-votes"><span id="candidate-votes-{{ $p2->id }}">{{ number_format($p2->total_votes) }}</span> SUARA</p>
                            <div class="progress-box">
                                <div id="candidate-bar-{{ $p2->id }}" class="progress-fill" style="width: {{ $p2->percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="podium-percent"><span id="candidate-percentage-{{ $p2->id }}">{{ number_format($p2->percentage, 1) }}</span>%</p>
                                <a href="{{ route('votes.payment', $p2->id) }}" class="btn btn-primary py-2 px-4 text-xs">VOTE NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($p1)
                <div class="podium-item podium-rank-1">
                    <div class="podium-card">
                        <div class="podium-medal">🥇</div>
                        <div class="podium-img">
                            <img src="{{ $p1->photo ? asset('storage/' . $p1->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p1->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p1->name }}">
                        </div>
                        <div class="podium-info">
                            <h3 class="podium-name">{{ $p1->name }}</h3>
                            <p class="podium-votes"><span id="candidate-votes-{{ $p1->id }}">{{ number_format($p1->total_votes) }}</span> SUARA</p>
                            <div class="progress-box">
                                <div id="candidate-bar-{{ $p1->id }}" class="progress-fill" style="width: {{ $p1->percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="podium-percent"><span id="candidate-percentage-{{ $p1->id }}">{{ number_format($p1->percentage, 1) }}</span>%</p>
                                <a href="{{ route('votes.payment', $p1->id) }}" class="btn btn-primary py-2 px-6 text-xs">VOTE NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($p3)
                <div class="podium-item podium-rank-3">
                    <div class="podium-card">
                        <div class="podium-medal">🥉</div>
                        <div class="podium-img">
                            <img src="{{ $p3->photo ? asset('storage/' . $p3->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p3->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p3->name }}">
                        </div>
                        <div class="podium-info">
                            <h3 class="podium-name">{{ $p3->name }}</h3>
                            <p class="podium-votes"><span id="candidate-votes-{{ $p3->id }}">{{ number_format($p3->total_votes) }}</span> SUARA</p>
                            <div class="progress-box">
                                <div id="candidate-bar-{{ $p3->id }}" class="progress-fill" style="width: {{ $p3->percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="podium-percent"><span id="candidate-percentage-{{ $p3->id }}">{{ number_format($p3->percentage, 1) }}</span>%</p>
                                <a href="{{ route('votes.payment', $p3->id) }}" class="btn btn-primary py-2 px-4 text-xs">VOTE NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="grid-candidates">
                @foreach($remainingPutra as $candidate)
                    <div class="card-candidate">
                        <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}" alt="{{ $candidate->name }}">
                        <div class="flex-1">
                            <h4 class="candidate-name">{{ $candidate->name }}</h4>
                            <div class="progress-box" style="margin: 0.25rem 0;">
                                <div id="candidate-bar-{{ $candidate->id }}" class="progress-fill" style="width: {{ $candidate->percentage }}%"></div>
                            </div>
                            <p class="candidate-meta"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span> Suara</p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <div class="text-primary font-black"><span id="candidate-percentage-{{ $candidate->id }}">{{ number_format($candidate->percentage, 1) }}</span>%</div>
                            <a href="{{ route('votes.payment', $candidate->id) }}" class="btn btn-primary py-1 px-3 text-[10px]">VOTE</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- PUTRI SECTION -->
        <div x-show="category === 'putri'" x-transition x-cloak>
            @php
                $topPutri = $putri->take(3);
                $remainingPutri = $putri->slice(3);
                $pi1 = $topPutri->get(0);
                $pi2 = $topPutri->get(1);
                $pi3 = $topPutri->get(2);
            @endphp

            <div class="section-header">
                <h2 class="section-title">Leaderboard Putri</h2>
                <p class="text-slate-400">Kandidat putri dengan perolehan suara tertinggi.</p>
            </div>

            <div class="podium-wrapper">
                @if($pi2)
                <div class="podium-item podium-rank-2">
                    <div class="podium-card">
                        <div class="podium-medal">🥈</div>
                        <div class="podium-img">
                            <img src="{{ $pi2->photo ? asset('storage/' . $pi2->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($pi2->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $pi2->name }}">
                        </div>
                        <div class="podium-info">
                            <h3 class="podium-name">{{ $pi2->name }}</h3>
                            <p class="podium-votes"><span id="candidate-votes-{{ $pi2->id }}">{{ number_format($pi2->total_votes) }}</span> SUARA</p>
                            <div class="progress-box">
                                <div id="candidate-bar-{{ $pi2->id }}" class="progress-fill" style="width: {{ $pi2->percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="podium-percent"><span id="candidate-percentage-{{ $pi2->id }}">{{ number_format($pi2->percentage, 1) }}</span>%</p>
                                <a href="{{ route('votes.payment', $pi2->id) }}" class="btn btn-primary py-2 px-4 text-xs">VOTE NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($pi1)
                <div class="podium-item podium-rank-1">
                    <div class="podium-card">
                        <div class="podium-medal">🥇</div>
                        <div class="podium-img">
                            <img src="{{ $pi1->photo ? asset('storage/' . $pi1->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($pi1->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $pi1->name }}">
                        </div>
                        <div class="podium-info">
                            <h3 class="podium-name">{{ $pi1->name }}</h3>
                            <p class="podium-votes"><span id="candidate-votes-{{ $pi1->id }}">{{ number_format($pi1->total_votes) }}</span> SUARA</p>
                            <div class="progress-box">
                                <div id="candidate-bar-{{ $pi1->id }}" class="progress-fill" style="width: {{ $pi1->percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="podium-percent"><span id="candidate-percentage-{{ $pi1->id }}">{{ number_format($pi1->percentage, 1) }}</span>%</p>
                                <a href="{{ route('votes.payment', $pi1->id) }}" class="btn btn-primary py-2 px-6 text-xs">VOTE NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($pi3)
                <div class="podium-item podium-rank-3">
                    <div class="podium-card">
                        <div class="podium-medal">🥉</div>
                        <div class="podium-img">
                            <img src="{{ $pi3->photo ? asset('storage/' . $pi3->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($pi3->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $pi3->name }}">
                        </div>
                        <div class="podium-info">
                            <h3 class="podium-name">{{ $pi3->name }}</h3>
                            <p class="podium-votes"><span id="candidate-votes-{{ $pi3->id }}">{{ number_format($pi3->total_votes) }}</span> SUARA</p>
                            <div class="progress-box">
                                <div id="candidate-bar-{{ $pi3->id }}" class="progress-fill" style="width: {{ $pi3->percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="podium-percent"><span id="candidate-percentage-{{ $pi3->id }}">{{ number_format($pi3->percentage, 1) }}</span>%</p>
                                <a href="{{ route('votes.payment', $pi3->id) }}" class="btn btn-primary py-2 px-4 text-xs">VOTE NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="grid-candidates">
                @foreach($remainingPutri as $candidate)
                    <div class="card-candidate">
                        <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}" alt="{{ $candidate->name }}">
                        <div class="flex-1">
                            <h4 class="candidate-name">{{ $candidate->name }}</h4>
                            <div class="progress-box" style="margin: 0.25rem 0;">
                                <div id="candidate-bar-{{ $candidate->id }}" class="progress-fill" style="width: {{ $candidate->percentage }}%"></div>
                            </div>
                            <p class="candidate-meta"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span> Suara</p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <div class="text-primary font-black"><span id="candidate-percentage-{{ $candidate->id }}">{{ number_format($candidate->percentage, 1) }}</span>%</div>
                            <a href="{{ route('votes.payment', $candidate->id) }}" class="btn btn-primary py-1 px-3 text-[10px]">VOTE</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<style>
[x-cloak] { display: none !important; }
</style>
<script type="module">
    window.addEventListener('load', () => {
        if (window.Echo) {
            window.Echo.channel('voting-channel').listen('.vote.updated', (e) => {
                const totalVotesEl = document.getElementById('total-votes-display');
                if (totalVotesEl) totalVotesEl.innerText = new Intl.NumberFormat('id-ID').format(e.totalVotes);

                e.candidates.forEach(candidate => {
                    const percentEls = document.querySelectorAll(`[id^="candidate-percentage-${candidate.id}"]`);
                    const votesEls = document.querySelectorAll(`[id^="candidate-votes-${candidate.id}"]`);
                    const barEls = document.querySelectorAll(`[id^="candidate-bar-${candidate.id}"]`);

                    percentEls.forEach(el => el.innerText = candidate.percentage.toFixed(1));
                    votesEls.forEach(el => el.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes));
                    barEls.forEach(el => el.style.width = `${candidate.percentage}%`);
                });
            });
        }
    });
</script>
@endpush
@endsection
