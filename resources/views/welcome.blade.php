@extends('layouts.app')

@section('content')
<section class="candidate-section" x-data="{ category: 'putra' }">
    <div class="container">
        <!-- Hero Content -->
        <div class="text-center mb-16">
            <h1 class="hero-title">Pilih <span>Duta Favorit</span> Anda Sekarang</h1>
            <p class="hero-desc" style="max-width: 600px; margin: 0 auto; color: var(--text-muted);">Gunakan poin Anda untuk mendukung kandidat terbaik mewakili UIN Madura tahun 2026.</p>
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
            <div id="leaderboard"></div>
            
            @php
                $totalPutra = $putra->sum('total_votes');
                $totalPutri = $putri->sum('total_votes');
            @endphp

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
                    @foreach([$p2, $p1, $p3] as $index => $p)
                        @if($p)
                            @php 
                                $isP1 = $p->id === ($p1->id ?? null);
                                $rank = $p->id === ($p1->id ?? null) ? 1 : ($p->id === ($p2->id ?? null) ? 2 : 3);
                                $pct = $totalPutra > 0 ? ($p->total_votes / $totalPutra) * 100 : 0;
                            @endphp
                            <div class="circular-item {{ $isP1 ? 'circular-rank-1' : '' }}">
                                <div class="avatar-wrapper">
                                    <span class="rank-tag">{{ $isP1 ? '👑 ' : '' }}Juara {{ $rank }}</span>
                                    <img class="avatar-img" src="{{ $p->photo ? asset('storage/' . $p->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p->name }}">
                                </div>
                                <h3 class="circular-name">{{ $p->name }}</h3>
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 0.15rem;">
                                    <p class="circular-score" style="font-size: 1.1rem; color: var(--primary); font-weight: 900; margin-bottom: 0;">
                                        <span id="candidate-votes-{{ $p->id }}">{{ number_format($p->total_votes) }}</span> Suara
                                    </p>
                                    <span id="candidate-pct-{{ $p->id }}" style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted);">({{ number_format($pct, 1) }}%)</span>
                                </div>
                                <button type="button" class="btn btn-primary py-1 px-4 text-[10px] mt-4 js-vote-trigger" data-candidate-id="{{ $p->id }}" data-candidate-name="{{ e($p->name) }}">Vote Sekarang</button>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="lb-table-wrapper">
                    <table class="lb-table">
                        <thead>
                            <tr>
                                <th class="col-rank">Peringkat</th>
                                <th class="col-name">Nama Kandidat</th>
                                <th class="col-votes">Total Voting</th>
                                <th class="col-pct">Persentase</th>
                                <th class="col-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remainingPutra as $candidate)
                            @php $pct = $totalPutra > 0 ? ($candidate->total_votes / $totalPutra) * 100 : 0; @endphp
                            <tr>
                                <td class="rank-num">{{ $loop->iteration + 3 }}</td>
                                <td>
                                    <div class="voter-info">
                                        <img class="voter-avatar" src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}">
                                        <span class="voter-name">{{ $candidate->name }}</span>
                                    </div>
                                </td>
                                <td class="col-votes">
                                    <div class="voter-score"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span></div>
                                </td>
                                <td class="col-pct">
                                    <span id="candidate-pct-{{ $candidate->id }}" style="font-size: 14px; font-weight: 900; color: var(--primary);">{{ number_format($pct, 1) }}%</span>
                                </td>
                                <td class="col-action">
                                    <button type="button" class="btn btn-primary py-1.5 px-4 text-[10px] tracking-wider uppercase font-black js-vote-trigger" data-candidate-id="{{ $candidate->id }}" data-candidate-name="{{ e($candidate->name) }}">Vote</button>
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
                    @foreach([$pi2, $pi1, $pi3] as $index => $p)
                        @if($p)
                            @php 
                                $isP1 = $p->id === ($pi1->id ?? null);
                                $rank = $p->id === ($pi1->id ?? null) ? 1 : ($p->id === ($pi2->id ?? null) ? 2 : 3);
                                $pct = $totalPutri > 0 ? ($p->total_votes / $totalPutri) * 100 : 0;
                            @endphp
                            <div class="circular-item {{ $isP1 ? 'circular-rank-1' : '' }}">
                                <div class="avatar-wrapper">
                                    <span class="rank-tag">{{ $isP1 ? '👑 ' : '' }}Juara {{ $rank }}</span>
                                    <img class="avatar-img" src="{{ $p->photo ? asset('storage/' . $p->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p->name) . '&size=400&background=1e293b&color=3b82f6' }}" alt="{{ $p->name }}">
                                </div>
                                <h3 class="circular-name">{{ $p->name }}</h3>
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 0.15rem;">
                                    <p class="circular-score" style="font-size: 1.1rem; color: var(--primary); font-weight: 900; margin-bottom: 0;">
                                        <span id="candidate-votes-{{ $p->id }}">{{ number_format($p->total_votes) }}</span> Suara
                                    </p>
                                    <span id="candidate-pct-{{ $p->id }}" style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted);">({{ number_format($pct, 1) }}%)</span>
                                </div>
                                <button type="button" class="btn btn-primary py-1 px-4 text-[10px] mt-4 js-vote-trigger" data-candidate-id="{{ $p->id }}" data-candidate-name="{{ e($p->name) }}">Vote Sekarang</button>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="lb-table-wrapper">
                    <table class="lb-table">
                        <thead>
                            <tr>
                                <th class="col-rank">Peringkat</th>
                                <th class="col-name">Nama Kandidat</th>
                                <th class="col-votes">Total Voting</th>
                                <th class="col-pct">Persentase</th>
                                <th class="col-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remainingPutri as $candidate)
                            @php $pct = $totalPutri > 0 ? ($candidate->total_votes / $totalPutri) * 100 : 0; @endphp
                            <tr>
                                <td class="rank-num">{{ $loop->iteration + 3 }}</td>
                                <td>
                                    <div class="voter-info">
                                        <img class="voter-avatar" src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=200&background=1e293b&color=3b82f6' }}">
                                        <span class="voter-name">{{ $candidate->name }}</span>
                                    </div>
                                </td>
                                <td class="col-votes">
                                    <div class="voter-score"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span></div>
                                </td>
                                <td class="col-pct">
                                    <span id="candidate-pct-{{ $candidate->id }}" style="font-size: 14px; font-weight: 900; color: var(--primary);">{{ number_format($pct, 1) }}%</span>
                                </td>
                                <td class="col-action">
                                    <button type="button" class="btn btn-primary py-1.5 px-4 text-[10px] tracking-wider uppercase font-black js-vote-trigger" data-candidate-id="{{ $candidate->id }}" data-candidate-name="{{ e($candidate->name) }}">Vote</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL VOTE -->
    <div id="voteModal" class="vote-modal-backdrop" aria-hidden="true">
        <div class="vote-modal-card">
            <div class="vote-modal-header">
                <div>
                    <span class="vote-modal-kicker">Konfirmasi Voting</span>
                    <h2 id="voteCandidateName" class="vote-modal-title"></h2>
                </div>
                <button type="button" class="vote-modal-close js-vote-close" aria-label="Tutup modal">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div id="voteTopUpState" hidden>
                <div class="vote-empty-state">
                    <strong>Poin Anda belum tersedia.</strong>
                    <span>Silakan lakukan top-up terlebih dahulu untuk memberikan dukungan kepada kandidat.</span>
                </div>
                <a href="{{ route('topup.index') }}" class="btn btn-primary vote-modal-submit">Top Up Sekarang</a>
            </div>

            <form id="voteForm" action="{{ route('votes.cast') }}" method="POST" hidden>
                @csrf
                <input id="voteCandidateId" type="hidden" name="candidate_id">

                <div class="vote-balance">
                    <span>Saldo Poin</span>
                    <strong><span id="voteUserPoints">{{ number_format(Auth::check() ? Auth::user()->points : 0) }}</span> PTS</strong>
                </div>

                <label for="votePointsInput" class="vote-input-label">Jumlah poin yang digunakan</label>
                <input id="votePointsInput"
                       class="form-input vote-points-input"
                       type="number"
                       name="points"
                       min="1"
                       max="{{ Auth::check() ? (int) Auth::user()->points : 0 }}"
                       value="1"
                       required>

                <div class="vote-point-options">
                    <button type="button" data-vote-points="1">1</button>
                    <button type="button" data-vote-points="5">5</button>
                    <button type="button" data-vote-points="10">10</button>
                    <button type="button" data-vote-points="max">Semua</button>
                </div>

                <p class="vote-modal-note">
                    Poin yang dipilih akan langsung dikurangi dari saldo Anda dan ditambahkan ke total voting kandidat.
                </p>

                <button type="submit" class="btn btn-primary vote-modal-submit" style="margin-bottom: 1.5rem;">
                    Gunakan <span id="voteSubmitPoints">1</span> Poin
                </button>
            </form>

            <!-- PUBLIC VOTERS LIST -->
            <div id="publicVotersSection" style="border-top: 1px solid var(--border); padding-top: 1.5rem; margin-top: 0.5rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                    Pendukung Terbaru
                </label>
                <div id="publicVotersList" style="display: flex; flex-direction: column; gap: 0.75rem; max-height: 200px; overflow-y: auto; padding-right: 0.5rem;">
                    <div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.8rem;">Memuat pendukung...</div>
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
        const userPoints = {{ Auth::check() ? (int) Auth::user()->points : 0 }};
        const modal = document.getElementById('voteModal');
        const form = document.getElementById('voteForm');
        const topUpState = document.getElementById('voteTopUpState');
        const candidateIdInput = document.getElementById('voteCandidateId');
        const candidateName = document.getElementById('voteCandidateName');
        const pointsInput = document.getElementById('votePointsInput');
        const submitPoints = document.getElementById('voteSubmitPoints');
        const optionButtons = document.querySelectorAll('[data-vote-points]');

        const clampPoints = (value) => {
            const parsed = parseInt(value, 10);
            if (Number.isNaN(parsed)) return 1;
            return Math.min(Math.max(parsed, 1), Math.max(userPoints, 1));
        };

        const syncPoints = (value) => {
            const points = clampPoints(value);
            pointsInput.value = points;
            submitPoints.innerText = points;

            optionButtons.forEach((button) => {
                const target = button.dataset.votePoints === 'max' ? userPoints : parseInt(button.dataset.votePoints, 10);
                button.disabled = target > userPoints;
                button.classList.toggle('active', points === target);
            });
        };

        const isGuest = {{ Auth::check() ? 'false' : 'true' }};

        const openModal = (id, name) => {
            if (isGuest) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            candidateIdInput.value = id;
            candidateName.innerText = name;

            if (userPoints <= 0) {
                form.hidden = true;
                topUpState.hidden = false;
            } else {
                topUpState.hidden = true;
                form.hidden = false;
                pointsInput.max = userPoints;
                syncPoints(1);
                setTimeout(() => pointsInput.focus(), 50);
            }

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');

            // Fetch Voters for this candidate
            const votersList = document.getElementById('publicVotersList');
            votersList.innerHTML = '<div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.8rem;">Memuat pendukung...</div>';

            fetch(`/api/candidates/${id}/voters`)
                .then(res => res.json())
                .then(voters => {
                    if (voters.length === 0) {
                        votersList.innerHTML = '<div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.8rem;">Belum ada pendukung untuk kandidat ini. Jadilah yang pertama!</div>';
                        return;
                    }

                    votersList.innerHTML = voters.map(v => `
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; padding: 0.65rem; background: #f8fafc; border-radius: 0.85rem; border: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <img src="${v.avatar}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="font-size: 0.8rem; color: var(--text-main);">${v.name}</strong>
                                    <span style="font-size: 10px; color: var(--text-muted);">${v.date}</span>
                                </div>
                            </div>
                            <strong style="font-size: 0.8rem; color: var(--primary);">${new Intl.NumberFormat('id-ID').format(v.points)} PTS</strong>
                        </div>
                    `).join('');
                })
                .catch(err => {
                    votersList.innerHTML = '<div style="padding: 1rem; text-align: center; color: #dc2626; font-size: 0.8rem;">Gagal memuat data pendukung.</div>';
                });
        };

        const closeModal = () => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        };

        document.querySelectorAll('.js-vote-trigger').forEach((button) => {
            button.addEventListener('click', () => {
                openModal(button.dataset.candidateId, button.dataset.candidateName);
            });
        });

        document.querySelectorAll('.js-vote-close').forEach((button) => {
            button.addEventListener('click', closeModal);
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeModal();
        });

        pointsInput.addEventListener('input', () => {
            syncPoints(pointsInput.value);
        });

        optionButtons.forEach((button) => {
            button.addEventListener('click', () => {
                syncPoints(button.dataset.votePoints === 'max' ? userPoints : button.dataset.votePoints);
            });
        });

        form.addEventListener('submit', () => {
            syncPoints(pointsInput.value);
        });

        if (window.Echo) {
            window.Echo.channel('voting-channel').listen('.vote.updated', (e) => {
                const totalVotesEl = document.getElementById('total-votes-display');
                if (totalVotesEl) totalVotesEl.innerText = new Intl.NumberFormat('id-ID').format(e.totalVotes);

                // Calculate Category Totals
                const putraTotal = e.candidates.filter(c => c.category === 'putra').reduce((sum, c) => sum + parseInt(c.total_votes), 0);
                const putriTotal = e.candidates.filter(c => c.category === 'putri').reduce((sum, c) => sum + parseInt(c.total_votes), 0);

                e.candidates.forEach(candidate => {
                    const id = candidate.id;
                    const catTotal = candidate.category === 'putra' ? putraTotal : putriTotal;
                    const pct = catTotal > 0 ? (candidate.total_votes / catTotal) * 100 : 0;

                    // Update Votes
                    const votesEls = document.querySelectorAll(`[id^="candidate-votes-${id}"]`);
                    votesEls.forEach(el => el.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes));

                    // Update Percentages
                    const pctEls = document.querySelectorAll(`[id^="candidate-pct-${id}"]`);
                    pctEls.forEach(el => {
                        if (el.closest('.circular-item')) {
                            el.innerText = `(${pct.toFixed(1)}%)`;
                        } else {
                            el.innerText = pct.toFixed(1) + '%';
                        }
                    });
                });
            });
        }
    });
</script>
@endpush
@endsection
