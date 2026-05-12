@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
            <p class="mt-2 text-slate-500">Monitoring realtime voting dan transaksi</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-12">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Suara</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($stats['total_votes']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Pendapatan</p>
                        <p class="text-2xl font-black text-slate-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Menunggu Approval</p>
                        <p class="text-2xl font-black text-slate-900">{{ $stats['pending_transactions'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Kandidat</p>
                        <p class="text-2xl font-black text-slate-900">{{ $stats['total_candidates'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Navigation Links -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Quick Links</h2>
                <a href="{{ route('admin.candidates.index') }}" class="flex items-center justify-between p-6 bg-white rounded-3xl border border-slate-200 shadow-sm hover:border-indigo-600 transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-slate-50 rounded-2xl group-hover:bg-indigo-50 transition-colors">
                            <svg class="w-6 h-6 text-slate-600 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <span class="font-bold text-slate-900">Kelola Kandidat</span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>

                <a href="{{ route('admin.transactions.index') }}" class="flex items-center justify-between p-6 bg-white rounded-3xl border border-slate-200 shadow-sm hover:border-indigo-600 transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-slate-50 rounded-2xl group-hover:bg-indigo-50 transition-colors">
                            <svg class="w-6 h-6 text-slate-600 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <span class="font-bold text-slate-900">Verifikasi Transaksi</span>
                    </div>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>

            <!-- Recent Transactions -->
            <div class="lg:col-span-2">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Transaksi Terakhir</h2>
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Voter</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kandidat</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($recentTransactions as $tx)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $tx->vote->voter_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $tx->candidate->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            {{ $tx->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : ($tx->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                            {{ ucfirst($tx->status) }}
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
