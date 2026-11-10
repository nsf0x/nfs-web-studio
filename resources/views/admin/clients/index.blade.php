@extends('layouts.admin')
@section('page_title', 'Manajemen Klien')
@section('title', 'Klien')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-sm text-gray-500">Total: {{ $clients->total() }} klien</p>
    </div>
    <a href="{{ route('admin.clients.create') }}" class="btn-primary text-sm py-2 px-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Klien
    </a>
</div>

<div class="bg-white rounded-xl shadow-card overflow-hidden">
    @if($clients->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada klien. <a href="{{ route('admin.clients.create') }}" class="text-accent">Tambah sekarang →</a></div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-5 py-3">Klien</th>
                    <th class="text-left px-5 py-3">Industri</th>
                    <th class="text-left px-5 py-3">Website</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Urutan</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($clients as $client)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            @if($client->logo_url)
                                <img src="{{ str_starts_with($client->logo_url, 'http://') || str_starts_with($client->logo_url, 'https://') ? $client->logo_url : Storage::url($client->logo_url) }}"
                                     alt="{{ $client->name }}" class="h-8 w-auto max-w-[60px] object-contain">
                            @else
                                <div class="w-8 h-8 bg-navy-100 rounded-lg flex items-center justify-center">
                                    <span class="text-navy-700 text-xs font-bold">{{ strtoupper(substr($client->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <span class="font-medium text-navy-900">{{ $client->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $client->industry ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        @if($client->website_url)
                            <a href="{{ $client->website_url }}" target="_blank" rel="noopener" class="text-accent hover:underline text-xs">{{ parse_url($client->website_url, PHP_URL_HOST) }}</a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="badge {{ $client->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $client->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $client->sort_order }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="text-accent hover:text-accent-hover text-xs font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}"
                                  onsubmit="return confirm('Hapus klien {{ $client->name }}?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $clients->links() }}
    </div>
    @endif
</div>
@endsection
