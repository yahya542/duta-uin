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
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td>{{ $tx->created_at->format('d/m H:i') }}</td>
                            <td>{{ $tx->vote->voter_name ?? '-' }}</td>
                            <td>Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                            <td><span class="admin-badge {{ $tx->status === 'success' ? 'success' : ($tx->status === 'pending' ? 'warning' : 'danger') }}">{{ $tx->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="admin-empty">Belum ada aktivitas pembayaran.</td></tr>
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
                        <th>Waktu</th>
                        <th>Nama</th>
                        <th>Poin</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($votes as $vote)
                        <tr>
                            <td>{{ $vote->created_at->format('d/m H:i') }}</td>
                            <td>{{ $vote->voter_name }}</td>
                            <td>{{ number_format($vote->vote_point) }} PTS</td>
                            <td><span class="admin-badge {{ $vote->status === 'success' ? 'success' : ($vote->status === 'pending' ? 'warning' : 'danger') }}">{{ $vote->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="admin-empty">Belum ada aktivitas poin.</td></tr>
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
                    <th>Waktu</th>
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
                        <td>{{ $log->candidate->name ?? '-' }}</td>
                        <td>{{ number_format($log->total_votes) }}</td>
                        <td>{{ number_format($log->percentage, 1) }}%</td>
                        <td>{{ $log->ranking }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">Belum ada log leaderboard.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
