@extends('layouts.admin')
@section('page_title', 'Daftar Paket')
@section('title', 'Paket Harga')

@section('content')
<div class="flex items-center justify-between mb-5">
    <h2 class="font-semibold text-navy-900">Paket Harga</h2>
    <a href="{{ route('admin.packages.create') }}" class="admin-btn bg-accent text-white hover:bg-accent-hover py-2 px-4 flex items-center gap-2 focus:ring-accent">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Paket
    </a>
</div>

@foreach($services as $service)
<div class="bg-white rounded-xl shadow-card mb-6 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
        <span class="text-xl">{{ $service->icon ?: '🌐' }}</span>
        <h3 class="font-semibold text-navy-900">{{ $service->name }}</h3>
        <span class="text-xs text-gray-400">({{ $service->packages->count() }} paket)</span>
    </div>

    @if($service->packages->isEmpty())
    <div class="p-6 text-center text-gray-400 text-sm">Belum ada paket untuk layanan ini.</div>
    @else
    <table class="w-full text-sm">
        <thead class="text-gray-500 text-xs uppercase tracking-wide">
            <tr>
                <th class="text-left px-5 py-3">Paket</th>
                <th class="text-left px-5 py-3">Harga</th>
                <th class="text-left px-5 py-3">Waktu / Revisi</th>
                <th class="text-left px-5 py-3">Fitur</th>
                <th class="text-left px-5 py-3">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($service->packages as $pkg)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        @if($pkg->is_featured)<span class="text-gold text-xs">⭐</span>@endif
                        <span class="font-medium text-navy-900">{{ $pkg->name }}</span>
                    </div>
                    <div class="text-xs text-gray-400 font-mono">{{ $pkg->slug }}</div>
                </td>
                <td class="px-5 py-3.5">
                    @if($pkg->price !== null && $pkg->price > 0)
                        <div class="font-semibold">Rp{{ number_format((float)$pkg->price, 0, ',', '.') }}</div>
                    @else
                        <div class="font-semibold">Hubungi Kami</div>
                    @endif
                    @if($pkg->price_note)<div class="text-xs text-gray-400">{{ $pkg->price_note }}</div>@endif
                    @if($pkg->billing_period === 'monthly')<div class="text-xs text-gray-400">per bulan</div>@endif
                    @if($pkg->billing_period === 'yearly')<div class="text-xs text-gray-400">per tahun</div>@endif
                </td>
                <td class="px-5 py-3.5 text-gray-500 text-xs">
                    @if($pkg->delivery_days){{ $pkg->delivery_days }} hari @endif
                    @if($pkg->revision_count !== null) / {{ $pkg->revision_count }}x revisi @endif
                </td>
                <td class="px-5 py-3.5 text-xs text-gray-500">{{ $pkg->features->count() }} fitur</td>
                <td class="px-5 py-3.5">
                    <span class="badge {{ $pkg->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $pkg->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3 justify-end">
                        <a href="{{ route('admin.packages.edit', $pkg) }}" class="text-accent text-xs font-medium hover:text-accent-hover">Edit</a>
                        <form method="POST" action="{{ route('admin.packages.destroy', $pkg) }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    @click="$dispatch('confirm-delete', { action: $el.form.action, name: $el.dataset.deleteName })"
                                    data-delete-name="{{ $pkg->name }}"
                                    class="text-red-500 text-xs font-medium hover:text-red-700">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endforeach

@if($services->isEmpty())
<div class="bg-white rounded-xl p-10 text-center text-gray-400">
    Belum ada layanan. <a href="{{ route('admin.services.create') }}" class="text-accent">Tambah layanan</a> terlebih dahulu.
</div>
@endif
@endsection
