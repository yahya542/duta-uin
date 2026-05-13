@extends('admin.layout')

@section('admin-title', 'Laporan Aktivitas')
@section('admin-kicker', 'Audit ekosistem')

@section('admin-content')
<div class="admin-grid-2" style="grid-template-columns: 1fr 1fr;">
    <div class="admin-card admin-card-pad">
        <h2 class="admin-section-title">Aktivitas Pembayaran</h2>
        <div class="admin-table-wrap">
            <table class="admin-table" style="min-width: 560px;">
                <thead>
                    <tr>
                        <th style="width: 100px;">Waktu</th>
                        <th style="width: 50px;"></th>
                        <th>User</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td>{{ $tx->created_at->format('d/m H:i') }}</td>
                            <td>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($tx->vote->voter_name ?? 'U') }}&size=100&background=f1f5f9&color=64748b" 
                                     style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                            </td>
                            <td>{{ $tx->vote->voter_name ?? '-' }}</td>
                            <td><strong>Rp {{ number_format($tx->nominal, 0, ',', '.') }}</strong></td>
                            <td><span class="admin-badge {{ $tx->status === 'success' ? 'success' : ($tx->status === 'pending' ? 'warning' : 'danger') }}">{{ $tx->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="admin-empty">Belum ada aktivitas pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card admin-card-pad">
        <h2 class="admin-section-title">Aktivitas Poin</h2>
        <div class="admin-table-wrap">
            <table class="admin-table" style="min-width: 560px;">
                <thead>
                    <tr>
                        <th style="width: 100px;">Waktu</th>
                        <th style="width: 50px;"></th>
                        <th>Nama</th>
                        <th>Poin</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($votes as $vote)
                        <tr>
                            <td>{{ $vote->created_at->format('d/m H:i') }}</td>
                            <td>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($vote->voter_name ?? 'U') }}&size=100&background=f1f5f9&color=64748b" 
                                     style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                            </td>
                            <td>{{ $vote->voter_name }}</td>
                            <td><strong>{{ number_format($vote->vote_point) }} PTS</strong></td>
                            <td><span class="admin-badge {{ $vote->status === 'success' ? 'success' : ($vote->status === 'pending' ? 'warning' : 'danger') }}">{{ $vote->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="admin-empty">Belum ada aktivitas poin.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="admin-card admin-card-pad" style="margin-top: 1rem;">
    <h2 class="admin-section-title">Log Leaderboard Terbaru</h2>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 140px;">Waktu</th>
                    <th style="width: 50px;"></th>
                    <th>Kandidat</th>
                    <th>Total Voting</th>
                    <th>Persentase</th>
                    <th>Ranking</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <img src="{{ $log->candidate->photo ? asset('storage/' . $log->candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($log->candidate->name ?? 'C') . '&size=100&background=f1f5f9&color=64748b' }}" 
                                 style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td><strong>{{ $log->candidate->name ?? '-' }}</strong></td>
                        <td style="color: var(--primary); font-weight: 800;">{{ number_format($log->total_votes) }}</td>
                        <td><span class="admin-badge info">{{ number_format($log->percentage, 1) }}%</span></td>
                        <td><strong>#{{ $log->ranking }}</strong></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="admin-empty">Belum ada log leaderboard.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
