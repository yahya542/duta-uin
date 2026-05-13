@extends('admin.layout')

@section('admin-title', 'Leaderboard Voting')
@section('admin-kicker', 'Performa kandidat')

@section('admin-content')
<div class="admin-stat-grid">
    <div class="admin-card admin-stat"><span>Total Voting</span><strong>{{ number_format($totalVotes) }}</strong></div>
    <div class="admin-card admin-stat"><span>Kandidat Putra</span><strong>{{ $putra->count() }}</strong></div>
    <div class="admin-card admin-stat"><span>Kandidat Putri</span><strong>{{ $putri->count() }}</strong></div>
    <div class="admin-card admin-stat"><span>Pemimpin Saat Ini</span><strong>{{ optional($putra->merge($putri)->sortByDesc('total_votes')->first())->name ?? '-' }}</strong></div>
</div>

<div class="admin-grid-2">
    @foreach(['Duta Putra' => $putra, 'Duta Putri' => $putri] as $title => $items)
        <div class="admin-card admin-card-pad">
            <h2 class="admin-section-title">{{ $title }}</h2>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @forelse($items as $candidate)
                    @php
                        $categoryTotal = $items->sum('total_votes');
                        $percentage = $categoryTotal > 0 ? ($candidate->total_votes / $categoryTotal) * 100 : 0;
                    @endphp
                    <div style="padding: 1rem; background: #f8fafc; border-radius: 1rem; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 0.7rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem; min-width: 0;">
                                <span style="width: 30px; height: 30px; border-radius: 999px; background: var(--primary); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 900;">{{ $loop->iteration }}</span>
                                <strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $candidate->name }}</strong>
                            </div>
                            <strong class="js-votes-{{ $candidate->id }}" style="color: var(--primary);">{{ number_format($candidate->total_votes) }}</strong>
                        </div>
                        <div style="height: 8px; background: rgba(15, 23, 42, 0.06); border-radius: 999px; overflow: hidden;">
                            <div class="js-bar-{{ $candidate->id }}" style="width: {{ $percentage }}%; height: 100%; background: var(--primary); border-radius: 999px; transition: width 0.5s;"></div>
                        </div>
                        <span class="js-pct-{{ $candidate->id }}" style="display: block; margin-top: 0.45rem; color: var(--text-muted); font-size: 0.75rem; font-weight: 800;">{{ number_format($percentage, 1) }}%</span>
                    </div>
                @empty
                    <div class="admin-empty">Belum ada kandidat.</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
@push('scripts')
<script type="module">
    window.addEventListener('load', () => {
        if (window.Echo) {
            window.Echo.channel('voting-channel').listen('.vote.updated', (e) => {
                // Update Global Stats
                const totalVotesStrong = document.querySelector('.admin-stat strong');
                if (totalVotesStrong) totalVotesStrong.innerText = new Intl.NumberFormat('id-ID').format(e.totalVotes);

                // Calculate Category Totals
                const putraTotal = e.candidates.filter(c => c.category === 'putra').reduce((sum, c) => sum + parseInt(c.total_votes), 0);
                const putriTotal = e.candidates.filter(c => c.category === 'putri').reduce((sum, c) => sum + parseInt(c.total_votes), 0);

                e.candidates.forEach(candidate => {
                    const id = candidate.id;
                    const catTotal = candidate.category === 'putra' ? putraTotal : putriTotal;
                    const pct = catTotal > 0 ? (candidate.total_votes / catTotal) * 100 : 0;

                    // Update UI Elements in this row/card
                    const voteDisplay = document.querySelector(`.js-votes-${id}`);
                    const barDisplay = document.querySelector(`.js-bar-${id}`);
                    const pctDisplay = document.querySelector(`.js-pct-${id}`);

                    if (voteDisplay) voteDisplay.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes);
                    if (barDisplay) barDisplay.style.width = pct.toFixed(1) + '%';
                    if (pctDisplay) pctDisplay.innerText = pct.toFixed(1) + '%';
                });
            });
        }
    });
</script>
@endpush
@endsection
