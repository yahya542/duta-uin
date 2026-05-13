@extends('admin.layout')

@section('admin-title', 'Verifikasi Pembayaran')
@section('admin-kicker', 'Kelola top up poin')

@section('admin-content')
<div class="admin-stat-grid">
    <div class="admin-card admin-stat">
        <span>Menunggu</span>
        <strong style="color: #a16207;">{{ $stats['pending'] }}</strong>
    </div>
    <div class="admin-card admin-stat">
        <span>Disetujui</span>
        <strong style="color: #15803d;">{{ $stats['success'] }}</strong>
    </div>
    <div class="admin-card admin-stat">
        <span>Ditolak</span>
        <strong style="color: #b91c1c;">{{ $stats['rejected'] }}</strong>
    </div>
    <div class="admin-card admin-stat">
        <span>Total Masuk</span>
        <strong>Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</strong>
    </div>
</div>

<div class="admin-card admin-card-pad">
    <h2 class="admin-section-title">Daftar Pembayaran</h2>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 100px;">Tanggal</th>
                    <th style="width: 50px;"></th>
                    <th>Pengirim</th>
                    <th style="width: 50px;"></th>
                    <th>Kandidat</th>
                    <th>Poin</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                    <tr class="js-searchable" data-search="{{ strtolower(($tx->vote->voter_name ?? '') . ' ' . ($tx->candidate->name ?? '') . ' ' . $tx->status) }}">
                        <td>{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($tx->vote->voter_name ?? 'U') }}&size=100&background=f1f5f9&color=64748b" 
                                 style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td><strong>{{ $tx->vote->voter_name ?? '-' }}</strong></td>
                        <td>
                            <img src="{{ $tx->candidate && $tx->candidate->photo ? asset('storage/' . $tx->candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($tx->candidate->name ?? 'C') . '&size=100&background=f1f5f9&color=64748b' }}" 
                                 style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td><strong>{{ $tx->candidate->name ?? 'Top Up Saja' }}</strong></td>
                        <td>{{ number_format($tx->vote->vote_point ?? 0) }} PTS</td>
                        <td><strong>Rp {{ number_format($tx->nominal, 0, ',', '.') }}</strong></td>
                        <td>
                            <a href="{{ asset('storage/' . $tx->proof_image) }}" target="_blank" class="btn btn-outline" style="padding: 0.45rem 0.7rem; font-size: 0.7rem;">Lihat Bukti</a>
                        </td>
                        <td>
                            <span class="admin-badge {{ $tx->status === 'success' ? 'success' : ($tx->status === 'pending' ? 'warning' : 'danger') }}">{{ $tx->status }}</span>
                        </td>
                        <td style="text-align: right;">
                            @if($tx->status === 'pending')
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <form action="{{ route('admin.transactions.approve', $tx->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 0.8rem; font-size: 0.72rem; background: #16a34a;">Terima</button>
                                    </form>
                                    <form action="{{ route('admin.transactions.reject', $tx->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 0.8rem; font-size: 0.72rem; background: #dc2626;">Tolak</button>
                                    </form>
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.8rem;">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="admin-empty">Belum ada data pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
