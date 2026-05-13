@extends('layouts.app')

@section('content')
<section class="candidate-section">
    <div class="container">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="hero-title">Verifikasi <span>Transaksi</span></h1>
            <p class="hero-desc" style="margin-left: 0;">Validasi bukti transfer dan aktivasi poin suara kandidat secara akurat.</p>
        </div>

        <div class="leaderboard-container" style="padding: 1.5rem; border-radius: 1.5rem;">
            <table class="lb-table" style="table-layout: auto;">
                <thead>
                    <tr>
                        <th style="font-size: 0.65rem;">Tanggal</th>
                        <th style="font-size: 0.65rem;">Voter</th>
                        <th style="font-size: 0.65rem;">Kandidat</th>
                        <th style="font-size: 0.65rem;">Nominal</th>
                        <th style="font-size: 0.65rem; text-align: center;">Bukti</th>
                        <th style="font-size: 0.65rem; text-align: center;">Status</th>
                        <th style="font-size: 0.65rem; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr>
                            <td style="font-size: 0.75rem; color: var(--text-muted);">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                            <td style="font-size: 0.875rem; font-weight: 700;">{{ $tx->vote->voter_name }}</td>
                            <td style="font-size: 0.875rem; font-weight: 700;">{{ $tx->candidate->name ?? 'TOP UP' }}</td>
                            <td style="font-size: 1rem; font-weight: 900; color: white;">Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                            <td style="text-align: center;">
                                <a href="{{ asset('storage/' . $tx->proof_image) }}" target="_blank" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 9px; display: inline-flex; border-color: rgba(255,255,255,0.1);">LIHAT GAMBAR</a>
                            </td>
                            <td style="text-align: center;">
                                @if($tx->status === 'success')
                                    <span style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(34, 197, 94, 0.2);">Valid</span>
                                @elseif($tx->status === 'pending')
                                    <span style="background: rgba(234, 179, 8, 0.1); color: #eab308; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(234, 179, 8, 0.2);">Pending</span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(239, 68, 68, 0.2);">Ditolak</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if($tx->status === 'pending')
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <form action="{{ route('admin.transactions.approve', $tx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 10px; background: #22c55e; border-color: #22c55e;">TERIMA</button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject', $tx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 10px; background: #ef4444; border-color: #ef4444;">TOLAK</button>
                                        </form>
                                    </div>
                                @else
                                    <span style="font-size: 10px; color: var(--text-muted); font-style: italic;">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if($transactions->isEmpty())
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 4rem; color: var(--text-muted); font-style: italic;">Tidak ada transaksi pending saat ini.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    .lb-table th:nth-child(1), .lb-table td:nth-child(1),
    .lb-table th:nth-child(5), .lb-table td:nth-child(5) { display: none; }
}
</style>
@endsection
