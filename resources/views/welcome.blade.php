@extends('layouts.app')

@section('content')
<section class="candidate-section" x-data="{ category: 'putra' }">
    <div class="container">
        <!-- Hero Content -->
        <div class="text-center mb-16">
            <h1 class="hero-title">Pilih <span>Duta Favorit</span> Anda Sekarang</h1>
            <p class="hero-desc" style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">Dukung kandidat terbaik untuk mewakili UIN Madura dalam kancah nasional dan internasional tahun 2026.</p>
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

        <!-- LEADERBOARD CONTENT -->
        <div class="leaderboard-container">
            <!-- PUTRA SECTION -->
            <div x-show="category === 'putra'" x-transition>
                @php
                    $topPutra = $putra->take(3);
                    $remainingPutra = $putra->slice(3);
                    $p1 = $topPutra->get(0);
                    $p2 = $topPutra->get(1);
                    $p3 = $topPutra->get(2);
                @endphp
                
                <div class="podium-circular">
                    <!-- Rank 2 -->
                    @if($p2)
                    <div class="circular-item">
                        <div class="avatar-wrapper">
                            <span class="rank-tag">Juara 2</span>
                            <img class="avatar-img" src="{{ $p2->photo ? asset('storage/' . $p2->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p2->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p2->name }}">
                        </div>
                        <h3 class="circular-name">{{ $p2->name }}</h3>
                        <p class="circular-score"><span id="candidate-votes-{{ $p2->id }}">{{ number_format($p2->total_votes) }}</span></p>
                        <a href="{{ route('votes.payment', $p2->id) }}" class="btn btn-outline py-1 px-4 text-[10px] mt-4">VOTE SEKARANG</a>
                    </div>
                    @endif

                    <!-- Rank 1 -->
                    @if($p1)
                    <div class="circular-item circular-rank-1">
                        <div class="avatar-wrapper">
                            <span class="rank-tag">👑 Juara 1</span>
                            <img class="avatar-img" src="{{ $p1->photo ? asset('storage/' . $p1->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p1->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p1->name }}">
                        </div>
                        <h3 class="circular-name">{{ $p1->name }}</h3>
                        <p class="circular-score"><span id="candidate-votes-{{ $p1->id }}">{{ number_format($p1->total_votes) }}</span></p>
                        <a href="{{ route('votes.payment', $p1->id) }}" class="btn btn-primary py-1 px-4 text-[10px] mt-4">VOTE SEKARANG</a>
                    </div>
                    @endif

                    <!-- Rank 3 -->
                    @if($p3)
                    <div class="circular-item">
                        <div class="avatar-wrapper">
                            <span class="rank-tag">Juara 3</span>
                            <img class="avatar-img" src="{{ $p3->photo ? asset('storage/' . $p3->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p3->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p3->name }}">
                        </div>
                        <h3 class="circular-name">{{ $p3->name }}</h3>
                        <p class="circular-score"><span id="candidate-votes-{{ $p3->id }}">{{ number_format($p3->total_votes) }}</span></p>
                        <a href="{{ route('votes.payment', $p3->id) }}" class="btn btn-outline py-1 px-4 text-[10px] mt-4">VOTE SEKARANG</a>
                    </div>
                    @endif
                </div>

                <div class="lb-table-wrapper">
                    <table class="lb-table">
                        <thead>
                            <tr>
                                <th>Peringkat</th>
                                <th>Nama Kandidat</th>
                                <th style="text-align: right;">Total Voting</th>
                                <th style="text-align: right; width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remainingPutra as $candidate)
                            <tr>
                                <td class="rank-num">{{ $loop->iteration + 3 }}</td>
                                <td>
                                    <div class="voter-info">
                                        <img class="voter-avatar" src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}">
                                        <span class="voter-name">{{ $candidate->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="voter-score"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span></div>
                                </td>
                                <td>
                                    <div class="flex justify-end">
                                        <a href="{{ route('votes.payment', $candidate->id) }}" class="btn btn-primary py-1.5 px-4 text-[10px] tracking-wider uppercase font-black">VOTE</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

                <div class="podium-circular">
                    <!-- Rank 2 -->
                    @if($pi2)
                    <div class="circular-item">
                        <div class="avatar-wrapper">
                            <span class="rank-tag">Juara 2</span>
                            <img class="avatar-img" src="{{ $pi2->photo ? asset('storage/' . $pi2->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($pi2->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $pi2->name }}">
                        </div>
                        <h3 class="circular-name">{{ $pi2->name }}</h3>
                        <p class="circular-score"><span id="candidate-votes-{{ $pi2->id }}">{{ number_format($pi2->total_votes) }}</span></p>
                        <a href="{{ route('votes.payment', $pi2->id) }}" class="btn btn-outline py-1 px-4 text-[10px] mt-4">VOTE SEKARANG</a>
                    </div>
                    @endif

                    <!-- Rank 1 -->
                    @if($pi1)
                    <div class="circular-item circular-rank-1">
                        <div class="avatar-wrapper">
                            <span class="rank-tag">👑 Juara 1</span>
                            <img class="avatar-img" src="{{ $pi1->photo ? asset('storage/' . $pi1->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($pi1->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $pi1->name }}">
                        </div>
                        <h3 class="circular-name">{{ $pi1->name }}</h3>
                        <p class="circular-score"><span id="candidate-votes-{{ $pi1->id }}">{{ number_format($pi1->total_votes) }}</span></p>
                        <a href="{{ route('votes.payment', $pi1->id) }}" class="btn btn-primary py-1 px-4 text-[10px] mt-4">VOTE SEKARANG</a>
                    </div>
                    @endif

                    <!-- Rank 3 -->
                    @if($pi3)
                    <div class="circular-item">
                        <div class="avatar-wrapper">
                            <span class="rank-tag">Juara 3</span>
                            <img class="avatar-img" src="{{ $pi3->photo ? asset('storage/' . $pi3->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($pi3->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $pi3->name }}">
                        </div>
                        <h3 class="circular-name">{{ $pi3->name }}</h3>
                        <p class="circular-score"><span id="candidate-votes-{{ $pi3->id }}">{{ number_format($pi3->total_votes) }}</span></p>
                        <a href="{{ route('votes.payment', $pi3->id) }}" class="btn btn-outline py-1 px-4 text-[10px] mt-4">VOTE SEKARANG</a>
                    </div>
                    @endif
                </div>

                <div class="lb-table-wrapper">
                    <table class="lb-table">
                        <thead>
                            <tr>
                                <th>Peringkat</th>
                                <th>Nama Kandidat</th>
                                <th style="text-align: right;">Total Voting</th>
                                <th style="text-align: right; width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remainingPutri as $candidate)
                            <tr>
                                <td class="rank-num">{{ $loop->iteration + 3 }}</td>
                                <td>
                                    <div class="voter-info">
                                        <img class="voter-avatar" src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}">
                                        <span class="voter-name">{{ $candidate->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="voter-score"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span></div>
                                </td>
                                <td>
                                    <div class="flex justify-end">
                                        <a href="{{ route('votes.payment', $candidate->id) }}" class="btn btn-primary py-1.5 px-4 text-[10px] tracking-wider uppercase font-black">VOTE</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    const votesEls = document.querySelectorAll(`[id^="candidate-votes-${candidate.id}"]`);
                    votesEls.forEach(el => el.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes));
                });
            });
        }
    });
</script>
@endpush
@endsection
