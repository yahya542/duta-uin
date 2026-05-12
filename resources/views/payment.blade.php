@extends('layouts.app')

@section('content')
<div class="bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl">
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-500">
                                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7a1 1 0 010 1.414l-7 7a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-5.293-5.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" /></svg>
                            <span class="ml-4 text-sm font-medium text-slate-500">Pembayaran Voting</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-xl">
                <div class="bg-slate-900 px-6 py-8 text-center text-white">
                    <h2 class="text-2xl font-bold">Instruksi Pembayaran</h2>
                    <p class="mt-2 text-slate-400">Scan QRIS di bawah untuk menyelesaikan voting</p>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div class="flex flex-col items-center">
                            <div class="p-4 bg-white border-4 border-slate-100 rounded-3xl shadow-inner">
                                <img src="{{ asset('qris/qris-dana.png') }}" 
                                     alt="QRIS DANA" 
                                     class="w-64 h-64 object-contain"
                                     onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=VotingSystem';">
                            </div>
                            <div class="mt-6 flex items-center gap-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA" class="h-6">
                                <span class="text-lg font-bold text-slate-900">QRIS DANA</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Detail Voting</h3>
                                <div class="mt-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Voter</span>
                                        <span class="font-bold text-slate-900">{{ $vote->voter_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Kandidat</span>
                                        <span class="font-bold text-indigo-600">{{ $vote->candidate->name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                                        <span class="text-slate-900 font-bold">Total Bayar</span>
                                        <span class="text-2xl font-black text-slate-900">Rp {{ number_format($vote->nominal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('payment.upload', $vote->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <label class="block">
                                        <span class="text-sm font-bold text-slate-700">Upload Bukti Transfer</span>
                                        <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-slate-300 px-6 pt-5 pb-6 hover:border-indigo-500 transition-colors cursor-pointer group">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-slate-600">
                                                    <span class="relative cursor-pointer rounded-md font-semibold text-indigo-600 hover:text-indigo-500">Pilih file</span>
                                                    <p class="pl-1">atau drag and drop</p>
                                                </div>
                                                <p class="text-xs text-slate-500">PNG, JPG, JPEG up to 2MB</p>
                                                <input id="file-upload" name="proof_image" type="file" class="sr-only" required onchange="updateFileName(this)">
                                            </div>
                                        </div>
                                        <p id="file-name" class="mt-2 text-sm text-indigo-600 font-medium"></p>
                                    </label>
                                    
                                    <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-4 text-lg font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                                        Konfirmasi Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById('file-name').textContent = fileName ? 'Selected: ' + fileName : '';
    }
</script>
@endsection
