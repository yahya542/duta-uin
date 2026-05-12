@extends('layouts.app')

@section('content')
<div class="bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
        <div class="mx-auto max-w-2xl">
            <div class="mb-8 flex justify-center">
                <div class="rounded-full bg-green-100 p-6 animate-pulse">
                    <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">Terima Kasih!</h1>
            <p class="mt-4 text-lg leading-8 text-slate-600">Bukti transfer Anda telah berhasil diunggah. Silakan selesaikan langkah terakhir untuk mempercepat verifikasi.</p>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <a href="{{ $waUrl }}" target="_blank" class="flex flex-col items-center justify-center gap-4 rounded-3xl border border-slate-200 bg-white p-8 hover:border-green-500 hover:bg-green-50 transition-all group">
                    <div class="rounded-2xl bg-green-500 p-4 shadow-lg shadow-green-100 group-hover:scale-110 transition-transform">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-slate-900">Kirim ke WhatsApp</h3>
                        <p class="mt-1 text-sm text-slate-500">Kirim konfirmasi ke Admin</p>
                    </div>
                </a>

                <a href="{{ $gformUrl }}" target="_blank" class="flex flex-col items-center justify-center gap-4 rounded-3xl border border-slate-200 bg-white p-8 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="rounded-2xl bg-indigo-600 p-4 shadow-lg shadow-indigo-100 group-hover:scale-110 transition-transform">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-slate-900">Google Form</h3>
                        <p class="mt-1 text-sm text-slate-500">Lengkapi data tambahan</p>
                    </div>
                </a>
            </div>

            <div class="mt-16">
                <a href="{{ route('home') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-500 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
