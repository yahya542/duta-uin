@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Verifikasi Transaksi</h1>
            <p class="mt-2 text-slate-500">Approve atau Reject bukti transfer dari voter</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Voter</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kandidat</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Bukti</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $tx->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $tx->vote->voter_name }}</div>
                                <div class="text-xs text-slate-500">ID: #{{ $tx->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $tx->candidate->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-slate-900">
                                Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="viewProof('{{ asset('storage/' . $tx->proof_image) }}')" 
                                        class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-colors">
                                    Lihat Bukti
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.transactions.reject', $tx->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Reject">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transactions.approve', $tx->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all">
                                            Approve
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                Tidak ada transaksi yang menunggu verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Proof Modal -->
<div id="proofModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeProofModal()"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block transform overflow-hidden rounded-3xl bg-white text-left align-middle shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl sm:align-middle">
            <div class="bg-white p-2">
                <img id="proofImage" src="" alt="Bukti Transfer" class="w-full rounded-2xl">
                <div class="p-4 flex justify-end">
                    <button onclick="closeProofModal()" class="px-6 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function viewProof(url) {
        document.getElementById('proofImage').src = url;
        document.getElementById('proofModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeProofModal() {
        document.getElementById('proofModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
