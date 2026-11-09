@extends('layouts.admin')
@section('page_title', 'Dashboard')
@section('title', 'Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow-card p-5 border-l-4 border-accent">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Inquiry Baru</p>
                <p class="text-3xl font-bold text-navy-900 mt-1">{{ $stats['inquiries_new'] }}</p>
            </div>
            <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-card p-5 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Inquiry</p>
                <p class="text-3xl font-bold text-navy-900 mt-1">{{ $stats['inquiries_total'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-card p-5 border-l-4 border-gold">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Layanan Aktif</p>
                <p class="text-3xl font-bold text-navy-900 mt-1">{{ $stats['services'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gold/10 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- Recent Inquiries --}}
<div class="bg-white rounded-xl shadow-card overflow-hidden">
    <div class="flex items-center justify-between p-5 border-b border-gray-100">
        <h2 class="font-semibold text-navy-900">Inquiry Terbaru</h2>
        <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-accent hover:text-accent-hover font-medium">Lihat Semua →</a>
    </div>

    @if($recentInquiries->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada inquiry masuk.</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-5 py-3">Nama</th>
                    <th class="text-left px-5 py-3">Layanan</th>
                    <th class="text-left px-5 py-3">Budget</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Waktu</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($recentInquiries as $inquiry)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="font-medium text-navy-900">{{ $inquiry->name }}</div>
                        <div class="text-xs text-gray-400">{{ $inquiry->email }}</div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $inquiry->service?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $inquiry->budget_range ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        @php
                            $statusColors = [
                                'new'         => 'bg-blue-100 text-blue-700',
                                'contacted'   => 'bg-yellow-100 text-yellow-700',
                                'negotiation' => 'bg-orange-100 text-orange-700',
                                'won'         => 'bg-green-100 text-green-700',
                                'lost'        => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'new' => 'Baru', 'contacted' => 'Dihubungi',
                                'negotiation' => 'Negosiasi', 'won' => 'Berhasil', 'lost' => 'Gagal',
                            ];
                        @endphp
                        <span class="badge {{ $statusColors[$inquiry->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $inquiry->created_at?->diffForHumans() }}</td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-accent hover:text-accent-hover text-xs font-medium">Detail →</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Quick Links --}}
<div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach([
        ['route' => 'admin.services.create', 'label' => 'Tambah Layanan', 'color' => 'bg-blue-50 text-blue-700 hover:bg-blue-100'],
        ['route' => 'admin.packages.create', 'label' => 'Tambah Paket', 'color' => 'bg-purple-50 text-purple-700 hover:bg-purple-100'],
        ['route' => 'admin.projects.create', 'label' => 'Tambah Proyek', 'color' => 'bg-green-50 text-green-700 hover:bg-green-100'],
        ['route' => 'admin.clients.create', 'label' => 'Tambah Klien', 'color' => 'bg-orange-50 text-orange-700 hover:bg-orange-100'],
    ] as $link)
    <a href="{{ route($link['route']) }}"
       class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-medium transition-colors {{ $link['color'] }}">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        {{ $link['label'] }}
    </a>
    @endforeach
</div>
@endsection
