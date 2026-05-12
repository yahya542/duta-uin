@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h1 class="hero-title text-4xl text-left ml-0">DASHBOARD <span>ADMIN</span></h1>
            <p class="section-desc text-left ml-0">Monitoring realtime voting, pendapatan, dan verifikasi transaksi.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-12">
            <div class="stat-item rounded-2xl border border-border">
                <span class="stat-num">{{ number_format($stats['total_votes']) }}</span>
                <span class="stat-label">TOTAL SUARA</span>
            </div>

            <div class="stat-item rounded-2xl border border-border">
                <span class="stat-num text-teal-light">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                <span class="stat-label">TOTAL PENDAPATAN</span>
            </div>

            <div class="stat-item rounded-2xl border border-border">
                <span class="stat-num text-red">{{ $stats['pending_transactions'] }}</span>
                <span class="stat-label">PENDING VERIFIKASI</span>
            </div>

            <div class="stat-item rounded-2xl border border-border">
                <span class="stat-num">{{ $stats['total_candidates'] }}</span>
                <span class="stat-label">TOTAL KANDIDAT</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Navigation Links -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="section-title text-left ml-0 mb-4 text-sm">NAVIGASI CEPAT</h2>
                
                <a href="{{ route('admin.candidates.index') }}" class="candidate-card p-6 flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-navy-3 rounded-xl group-hover:bg-gold transition-colors">
                            <svg class="w-6 h-6 text-gold group-hover:text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <span class="font-bold text-cream">Kelola Kandidat</span>
                    </div>
                    <span class="text-gold">→</span>
                </a>

                <a href="{{ route('admin.transactions.index') }}" class="candidate-card p-6 flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-navy-3 rounded-xl group-hover:bg-gold transition-colors">
                            <svg class="w-6 h-6 text-gold group-hover:text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <span class="font-bold text-cream">Verifikasi Transaksi</span>
                    </div>
                    <span class="text-gold">→</span>
                </a>
            </div>

            <!-- Recent Transactions -->
            <div class="lg:col-span-2">
                <h2 class="section-title text-left ml-0 mb-4 text-sm">TRANSAKSI TERBARU</h2>
                <div class="modal p-0 overflow-hidden border-border">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>VOTER</th>
                                <th>KANDIDAT</th>
                                <th>NOMINAL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $tx)
                                <tr>
                                    <td>{{ $tx->vote->voter_name }}</td>
                                    <td>{{ $tx->candidate->name }}</td>
                                    <td class="font-bold text-gold">Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="status-badge 
                                            {{ $tx->status === 'approved' ? 'status-valid' : ($tx->status === 'pending' ? 'status-pending' : 'status-rejected') }}">
                                            {{ strtoupper($tx->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
