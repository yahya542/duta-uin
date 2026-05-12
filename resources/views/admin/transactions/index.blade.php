@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h1 class="hero-title text-4xl text-left ml-0">VERIFIKASI <span>TRANSAKSI</span></h1>
            <p class="section-desc text-left ml-0">Validasi bukti transfer dan aktivasi poin suara kandidat.</p>
        </div>

        <div class="modal p-0 overflow-hidden border-border">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>VOTER</th>
                        <th>KANDIDAT</th>
                        <th>NOMINAL</th>
                        <th>BUKTI</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr>
                            <td class="text-xs text-slate-500">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $tx->vote->voter_name }}</td>
                            <td>{{ $tx->candidate->name }}</td>
                            <td class="font-bold text-gold">Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $tx->proof_image) }}" target="_blank" class="text-xs text-teal-light hover:underline font-bold uppercase tracking-widest">LIHAT BUKTI</a>
                            </td>
                            <td>
                                <span class="status-badge 
                                    {{ $tx->status === 'approved' ? 'status-valid' : ($tx->status === 'pending' ? 'status-pending' : 'status-rejected') }}">
                                    {{ strtoupper($tx->status) }}
                                </span>
                            </td>
                            <td>
                                @if($tx->status === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.transactions.approve', $tx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs bg-teal text-navy font-black px-3 py-1 rounded-md hover:bg-teal-light transition-colors">APPROVE</button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject', $tx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs bg-red text-cream font-black px-3 py-1 rounded-md hover:bg-red-500 transition-colors">REJECT</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-600 italic">No Action</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
