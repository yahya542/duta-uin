@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="hero-title">Dashboard <span>Admin</span></h1>
            <p class="hero-desc" style="margin-left: 0;">Monitoring realtime voting, pendapatan, dan verifikasi transaksi.</p>
        </div>

        <!-- Stats Bar -->
        <div class="stats-grid mb-12">
            <div class="stat-card">
                <span class="stat-value">{{ number_format($stats['total_votes']) }}</span>
                <span class="stat-label">Total Suara</span>
            </div>
            <div class="stat-card">
                <span class="stat-value" style="color: #22c55e;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                <span class="stat-label">Total Pendapatan</span>
            </div>
            <div class="stat-card">
                <span class="stat-value" style="color: #ef4444;">{{ $stats['pending_transactions'] }}</span>
                <span class="stat-label">Pending Verifikasi</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $stats['total_candidates'] }}</span>
                <span class="stat-label">Total Kandidat</span>
            </div>
        </div>

        <div style="display: grid; grid-template-cols: 1fr 2fr; gap: 2rem; align-items: start;">
            <!-- Navigation Links -->
            <div>
                <h2 style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1.5rem;">Navigasi Cepat</h2>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <a href="{{ route('admin.candidates.index') }}" class="btn btn-outline" style="justify-content: space-between; padding: 1.5rem; border-radius: 1.25rem; background: rgba(255,255,255,0.02);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <span style="font-weight: 700; color: white;">Kelola Kandidat</span>
                        </div>
                        <span style="color: var(--primary);">→</span>
                    </a>

                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline" style="justify-content: space-between; padding: 1.5rem; border-radius: 1.25rem; background: rgba(255,255,255,0.02);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            </div>
                            <span style="font-weight: 700; color: white;">Verifikasi Transaksi</span>
                        </div>
                        <span style="color: var(--primary);">→</span>
                    </a>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div>
                <h2 style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1.5rem;">Transaksi Terbaru</h2>
                <div class="leaderboard-container" style="padding: 1rem; border-radius: 1.5rem;">
                    <table class="lb-table" style="table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="font-size: 0.65rem;">Voter</th>
                                <th style="font-size: 0.65rem;">Kandidat</th>
                                <th style="font-size: 0.65rem; text-align: right;">Nominal</th>
                                <th style="font-size: 0.65rem; text-align: right;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $tx)
                                <tr>
                                    <td style="font-size: 0.8125rem; font-weight: 600;">{{ $tx->vote->voter_name }}</td>
                                    <td style="font-size: 0.8125rem; font-weight: 600;">{{ $tx->candidate->name }}</td>
                                    <td style="text-align: right; font-weight: 800; color: white; font-size: 0.875rem;">Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                                    <td style="text-align: right;">
                                        @if($tx->status === 'approved')
                                            <span style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(34, 197, 94, 0.2);">Valid</span>
                                        @elseif($tx->status === 'pending')
                                            <span style="background: rgba(234, 179, 8, 0.1); color: #eab308; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(234, 179, 8, 0.2);">Pending</span>
                                        @else
                                            <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(239, 68, 68, 0.2);">Ditolak</span>
                                        @endif
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

<style>
@media (max-width: 1024px) {
    div[style*="grid-template-cols: 1fr 2fr"] { grid-template-cols: 1fr !important; }
}
</style>
@endsection
