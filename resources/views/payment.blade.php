@extends('layouts.app')

@section('content')
<section class="section pt-32">
    <div class="mb-12">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition-colors">← Kembali ke Beranda</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Candidate info -->
        <div class="lg:col-span-4">
            <div class="stat-item p-0 overflow-hidden text-left">
                <div class="h-64 relative">
                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->name) . '&size=400&background=1e293b&color=3b82f6' }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-2">{{ $candidate->name }}</h2>
                    <p class="text-slate-400 text-sm italic mb-6">"{{ $candidate->description }}"</p>
                    
                    <div class="pt-6 border-t border-white/5">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest block mb-1">Total Suara</span>
                        <span class="text-3xl font-black text-primary">{{ number_format($candidate->total_votes) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Voting Steps -->
        <div class="lg:col-span-8">
            <div class="space-y-12">
                <!-- Step 1 -->
                <div>
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-4">
                        <span class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm">01</span>
                        Pilih Paket Vote
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php
                            $packages = [
                                ['points' => 10, 'price' => 10000, 'label' => 'Basic'],
                                ['points' => 50, 'price' => 50000, 'label' => 'Standard', 'popular' => true],
                                ['points' => 100, 'price' => 100000, 'label' => 'Premium'],
                                ['points' => 500, 'price' => 500000, 'label' => 'Ultimate'],
                            ];
                        @endphp

                        @foreach($packages as $pkg)
                            <div class="stat-item cursor-pointer hover:border-primary transition-all relative group {{ isset($pkg['popular']) ? 'border-primary' : '' }}" 
                                 onclick="selectPackage({{ $pkg['points'] }}, {{ $pkg['price'] }}, this)">
                                @if(isset($pkg['popular']))
                                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-[10px] font-bold px-2 py-1 rounded-full text-white">POPULAR</div>
                                @endif
                                <span class="text-3xl font-black block mb-1">{{ $pkg['points'] }}</span>
                                <span class="text-xs text-slate-400 font-bold uppercase">{{ $pkg['label'] }}</span>
                                <div class="mt-4 text-sm font-bold text-primary">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Step 2 -->
                <form action="{{ route('votes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                    <input type="hidden" name="nominal" id="inputNominal">
                    <input type="hidden" name="vote_point" id="inputPoints">

                    <div class="space-y-12">
                        <div>
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-4">
                                <span class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm">02</span>
                                Detail Pembayaran
                            </h3>
                            
                            <div class="stat-item flex flex-col md:flex-row gap-8 items-center text-left">
                                <div class="flex-1 space-y-6">
                                    <div class="p-6 rounded-2xl bg-white/5 border border-white/5">
                                        <div class="text-xs font-bold text-slate-500 mb-2 uppercase">Bank BRI</div>
                                        <div class="text-xl font-black mb-1">1234-5678-9012-345</div>
                                        <div class="text-sm text-slate-400">A.N. Panitia Duta Kampus</div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-slate-400">Paket Terpilih</span>
                                            <span id="displayPoints" class="font-bold">-</span>
                                        </div>
                                        <div class="flex justify-between text-lg">
                                            <span class="font-bold">Total Bayar</span>
                                            <span id="displayTotal" class="font-black text-primary">Rp 0</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full md:w-48 text-center space-y-4">
                                    <div class="bg-white p-2 rounded-2xl inline-block">
                                        <img src="{{ asset('qris/qris-dana.png') }}" alt="QRIS" class="w-40 h-40">
                                    </div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Scan QRIS Dana</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-4">
                                <span class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm">03</span>
                                Konfirmasi & Upload
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Pengirim</label>
                                    <input type="text" name="voter_name" required 
                                           class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white outline-none focus:border-primary transition-all" 
                                           placeholder="Sesuai bukti transfer">
                                </div>

                                <div class="p-12 border-2 border-dashed border-white/10 rounded-3xl text-center cursor-pointer hover:bg-white/5 transition-all"
                                     onclick="document.getElementById('proofInput').click()">
                                    <span class="text-3xl block mb-2">📁</span>
                                    <p class="text-sm font-bold text-slate-300">Upload Bukti Transfer</p>
                                    <p class="text-xs text-slate-500 mt-2">JPG, PNG, PDF (Maks 2MB)</p>
                                    <input type="file" name="proof_image" id="proofInput" class="hidden" required onchange="updateFileName(this)">
                                    <div id="fileName" class="mt-4 text-primary font-bold text-sm"></div>
                                </div>

                                <button type="submit" class="btn-primary w-full justify-center py-5 text-lg">Kirim Vote</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function selectPackage(points, price, el) {
        document.getElementById('inputNominal').value = price;
        document.getElementById('inputPoints').value = points;
        document.getElementById('displayPoints').innerText = points + ' Poin';
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
        document.getElementById('displayTotal').innerText = formattedPrice;

        document.querySelectorAll('.stat-item').forEach(card => card.classList.remove('border-primary'));
        el.classList.add('border-primary');
    }

    function updateFileName(input) {
        const name = input.files[0] ? input.files[0].name : '';
        document.getElementById('fileName').innerText = name;
    }
</script>
@endpush
@endsection
