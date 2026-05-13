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
                            <strong style="color: var(--primary);">{{ number_format($candidate->total_votes) }}</strong>
                        </div>
                        <div style="height: 8px; background: rgba(15, 23, 42, 0.06); border-radius: 999px; overflow: hidden;">
                            <div style="width: {{ $percentage }}%; height: 100%; background: var(--primary); border-radius: 999px;"></div>
                        </div>
                        <span style="display: block; margin-top: 0.45rem; color: var(--text-muted); font-size: 0.75rem; font-weight: 800;">{{ number_format($percentage, 1) }}%</span>
                    </div>
                @empty
                    <div class="admin-empty">Belum ada kandidat.</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
@endsection
