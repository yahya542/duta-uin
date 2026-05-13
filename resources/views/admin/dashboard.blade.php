@extends('admin.layout')

@section('admin-title', 'Ringkasan Ekosistem')
@section('admin-kicker', 'Monitoring utama')

@section('admin-content')
<div class="admin-stat-grid">
    <div class="admin-card admin-stat">
        <span>Total Suara</span>
        <strong>{{ number_format($stats['total_votes']) }}</strong>
    </div>
    <div class="admin-card admin-stat">
        <span>Pendapatan</span>
        <strong style="color: #15803d;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</strong>
    </div>
    <div class="admin-card admin-stat">
        <span>Pending Verifikasi</span>
        <strong style="color: #b91c1c;">{{ $stats['pending_transactions'] }}</strong>
    </div>
    <div class="admin-card admin-stat">
        <span>User Voter</span>
        <strong>{{ number_format($stats['total_users']) }}</strong>
    </div>
</div>

<div class="admin-grid-2">
    <div class="admin-card admin-card-pad">
        <h2 class="admin-section-title">Kandidat Teratas</h2>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($topCandidates as $candidate)
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.9rem; background: #f8fafc; border-radius: 0.9rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; min-width: 0;">
                        <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=80&background=2563eb&color=ffffff' }}" alt="{{ $candidate->name }}" style="width: 42px; height: 42px; border-radius: 999px; object-fit: cover;">
                        <div style="min-width: 0;">
                            <strong style="display: block; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $candidate->name }}</strong>
                            <span class="admin-badge info">{{ $candidate->category }}</span>
                        </div>
                    </div>
                    <strong style="color: var(--primary);">{{ number_format($candidate->total_votes) }}</strong>
                </div>
            @empty
                <div class="admin-empty">Belum ada kandidat.</div>
            @endforelse
        </div>
    </div>

    <div class="admin-card admin-card-pad">
        <h2 class="admin-section-title">Transaksi Terbaru</h2>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Voter</th>
                        <th>Tujuan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $tx)
                        <tr>
                            <td>{{ $tx->vote->voter_name ?? '-' }}</td>
                            <td>{{ $tx->candidate->name ?? 'Top Up Poin' }}</td>
                            <td><strong>Rp {{ number_format($tx->nominal, 0, ',', '.') }}</strong></td>
                            <td>
                                <span class="admin-badge {{ $tx->status === 'success' ? 'success' : ($tx->status === 'pending' ? 'warning' : 'danger') }}">{{ $tx->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="admin-empty">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
