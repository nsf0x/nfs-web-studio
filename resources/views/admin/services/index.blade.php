@extends('layouts.admin')
@section('page_title', 'Daftar Layanan')
@section('title', 'Layanan')

@section('content')
<div class="flex items-center justify-between mb-5">
    <h2 class="font-semibold text-navy-900">{{ $services->count() }} Layanan</h2>
    <a href="{{ route('admin.services.create') }}" class="admin-btn bg-accent text-white hover:bg-accent-hover py-2 px-4 flex items-center gap-2 focus:ring-accent">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Layanan
    </a>
</div>

<div class="bg-white rounded-xl shadow-card overflow-hidden">
    @if($services->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada layanan. <a href="{{ route('admin.services.create') }}" class="text-accent">Tambah sekarang</a>.</div>
    @else
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3">Urutan</th>
                <th class="text-left px-5 py-3">Layanan</th>
                <th class="text-left px-5 py-3">Deskripsi Singkat</th>
                <th class="text-left px-5 py-3">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($services as $service)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3.5 text-gray-400">{{ $service->sort_order }}</td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">{{ $service->icon ?: '🌐' }}</span>
                        <div>
                            <div class="font-medium text-navy-900">{{ $service->name }}</div>
                            <div class="text-xs text-gray-400 font-mono">{{ $service->slug }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-gray-500 max-w-xs">{{ Str::limit($service->short_description, 60) }}</td>
                <td class="px-5 py-3.5">
                    <span class="badge {{ $service->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3 justify-end">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-accent text-xs font-medium hover:text-accent-hover">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-xs font-medium hover:text-red-700">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
