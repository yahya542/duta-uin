@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden bg-white pb-24 pt-16 sm:pb-32 sm:pt-24">
    <!-- Hero Section -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-6xl">Pilih Pemimpin <span class="text-indigo-600">Masa Depan</span></h1>
            <p class="mt-6 text-lg leading-8 text-slate-600">Sistem voting online aman, transparan, dan realtime. Suara Anda menentukan perubahan.</p>
        </div>

        <!-- Leaderboard Podium -->
        <div class="mt-20 flex flex-col items-end justify-center gap-4 sm:flex-row sm:items-end">
            @foreach($podium as $index => $candidate)
                @php
                    $heights = [1 => 'h-48', 0 => 'h-64', 2 => 'h-32'];
                    $orders = [1 => 'order-1', 0 => 'order-2', 2 => 'order-3'];
                    $icons = [0 => '🥇', 1 => '🥈', 2 => '🥉'];
                    $colors = [0 => 'bg-yellow-400', 1 => 'bg-slate-300', 2 => 'bg-amber-600'];
                @endphp
                <div class="flex flex-col items-center {{ $orders[$index] }} w-full sm:w-48 animate-bounce-subtle" style="animation-delay: {{ $index * 0.2 }}s">
                    <div class="relative mb-4">
                        <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&background=random' }}" 
                             alt="{{ $candidate->name }}" 
                             class="w-24 h-24 rounded-full border-4 border-white shadow-xl object-cover">
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 {{ $colors[$index] }} rounded-full flex items-center justify-center text-xl shadow-lg">
                            {{ $icons[$index] }}
                        </div>
                    </div>
                    <div class="w-full {{ $heights[$index] }} rounded-t-2xl {{ $colors[$index] }} bg-opacity-20 border-x border-t border-white flex flex-col items-center justify-start p-4 text-center">
                        <h3 class="font-bold text-slate-900">{{ $candidate->name }}</h3>
                        <p class="text-sm font-medium text-slate-600">{{ number_format($candidate->total_votes) }} Suara</p>
                        <div class="mt-2 px-3 py-1 bg-white rounded-full text-xs font-bold shadow-sm">
                            {{ number_format($candidate->percentage, 1) }}%
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Candidates List -->
        <div class="mt-24">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-slate-900">Kandidat Terdaftar</h2>
                <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold">
                    Total Suara: <span id="total-votes-display">{{ number_format($totalVotes) }}</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($candidates as $candidate)
                    <div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="aspect-h-4 aspect-w-3 bg-slate-200 sm:aspect-none group-hover:opacity-90 transition-opacity">
                            <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&background=random' }}" 
                                 alt="{{ $candidate->name }}" 
                                 class="h-64 w-full object-cover object-center sm:h-72">
                        </div>
                        <div class="flex flex-1 flex-col space-y-2 p-6">
                            <h3 class="text-xl font-bold text-slate-900">
                                {{ $candidate->name }}
                            </h3>
                            <p class="text-sm text-slate-500 line-clamp-2">
                                {{ $candidate->description }}
                            </p>
                            
                            <div class="mt-4">
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="font-medium text-slate-600">Perolehan Suara</span>
                                    <span class="font-bold text-indigo-600"><span id="candidate-percentage-{{ $candidate->id }}">{{ number_format($candidate->percentage, 1) }}</span>%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                    <div id="candidate-bar-{{ $candidate->id }}" class="bg-indigo-600 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $candidate->percentage }}%"></div>
                                </div>
                                <div class="mt-1 text-right">
                                    <span class="text-xs text-slate-400 font-medium"><span id="candidate-votes-{{ $candidate->id }}">{{ number_format($candidate->total_votes) }}</span> Suara</span>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <button onclick="openVoteModal({{ $candidate->id }}, '{{ $candidate->name }}')" 
                                        class="flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white shadow-sm hover:bg-slate-800 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Vote Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Vote Modal -->
<div id="voteModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeVoteModal()"></div>

        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

        <div class="inline-block transform overflow-hidden rounded-3xl bg-white text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-slate-900" id="modal-title">Pilih Nominal Voting</h3>
                    <button onclick="closeVoteModal()" class="text-slate-400 hover:text-slate-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form id="voteForm" action="{{ route('vote.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="candidate_id" id="modalCandidateId">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold text-slate-700 mb-1 block">Nama Voter</label>
                            <input type="text" name="voter_name" required placeholder="Masukkan nama lengkap" 
                                   class="w-full rounded-xl border-slate-200 border px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700 mb-2 block">Pilih Nominal</label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach([5000, 10000, 25000, 50000, 100000, 250000] as $nominal)
                                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 p-4 shadow-sm focus:outline-none hover:border-indigo-600 transition-all group has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                        <input type="radio" name="nominal" value="{{ $nominal }}" class="sr-only" required>
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-bold text-slate-900 group-has-[:checked]:text-indigo-700">Rp {{ number_format($nominal, 0, ',', '.') }}</span>
                                                <span class="mt-1 flex items-center text-xs text-slate-500 group-has-[:checked]:text-indigo-600">
                                                    {{ floor($nominal / 5000) }} Vote Point
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-4 text-lg font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                            Lanjut ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openVoteModal(id, name) {
        document.getElementById('modalCandidateId').value = id;
        document.getElementById('voteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeVoteModal() {
        document.getElementById('voteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

@push('scripts')
<script type="module">
    window.addEventListener('load', () => {
        if (window.Echo) {
            window.Echo.channel('voting-channel')
                .listen('.vote.updated', (e) => {
                    console.log('Vote updated:', e);
                    
                    // Update total votes
                    const totalVotesEl = document.getElementById('total-votes-display');
                    if (totalVotesEl) {
                        totalVotesEl.innerText = new Intl.NumberFormat('id-ID').format(e.totalVotes);
                    }

                    // Update candidates
                    e.candidates.forEach(candidate => {
                        const percentEl = document.getElementById(`candidate-percentage-${candidate.id}`);
                        const barEl = document.getElementById(`candidate-bar-${candidate.id}`);
                        const votesEl = document.getElementById(`candidate-votes-${candidate.id}`);

                        if (percentEl) percentEl.innerText = candidate.percentage.toFixed(1);
                        if (barEl) barEl.style.width = `${candidate.percentage}%`;
                        if (votesEl) votesEl.innerText = new Intl.NumberFormat('id-ID').format(candidate.total_votes);
                    });
                });
        }
    });
</script>
@endpush

<style>
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-subtle {
        animation: bounce-subtle 3s infinite ease-in-out;
    }
</style>
@endsection
