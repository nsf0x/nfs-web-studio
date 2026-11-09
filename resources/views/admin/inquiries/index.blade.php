@extends('layouts.admin')
@section('page_title', 'Daftar Inquiry')
@section('title', 'Inquiries')

@section('content')
{{-- Filter --}}
<form method="GET" action="{{ route('admin.inquiries.index') }}" class="bg-white rounded-xl shadow-card p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}"
           class="admin-input flex-1 min-w-[180px]" placeholder="Cari nama, email, perusahaan...">
    <select name="status" class="admin-input w-auto">
        <option value="">Semua Status</option>
        <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Baru</option>
        <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Dihubungi</option>
        <option value="negotiation" {{ request('status') === 'negotiation' ? 'selected' : '' }}>Negosiasi</option>
        <option value="won" {{ request('status') === 'won' ? 'selected' : '' }}>Berhasil</option>
        <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Gagal</option>
    </select>
    <select name="service_id" class="admin-input w-auto">
        <option value="">Semua Layanan</option>
        @foreach($services as $svc)
            <option value="{{ $svc->id }}" {{ request('service_id') == $svc->id ? 'selected' : '' }}>{{ $svc->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="admin-btn bg-accent text-white hover:bg-accent-hover px-4">Filter</button>
    <a href="{{ route('admin.inquiries.index') }}" class="admin-btn bg-gray-100 text-gray-600 hover:bg-gray-200 px-4">Reset</a>
</form>

<div class="bg-white rounded-xl shadow-card overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-navy-900">{{ $inquiries->total() }} Inquiry</h2>
    </div>

    @if($inquiries->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada inquiry.</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3">Pengirim</th>
                    <th class="text-left px-4 py-3">Layanan / Paket</th>
                    <th class="text-left px-4 py-3">Budget</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Waktu</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($inquiries as $inquiry)
                @php
                    $statusColors = ['new'=>'bg-blue-100 text-blue-700','contacted'=>'bg-yellow-100 text-yellow-700','negotiation'=>'bg-orange-100 text-orange-700','won'=>'bg-green-100 text-green-700','lost'=>'bg-red-100 text-red-700'];
                    $statusLabels = ['new'=>'Baru','contacted'=>'Dihubungi','negotiation'=>'Negosiasi','won'=>'Berhasil','lost'=>'Gagal'];
                @endphp
                <tr class="hover:bg-gray-50 transition-colors {{ $inquiry->status === 'new' ? 'font-medium' : '' }}">
                    <td class="px-4 py-3.5">
                        <div class="font-medium text-navy-900">{{ $inquiry->name }}</div>
                        <div class="text-xs text-gray-400">{{ $inquiry->email }}</div>
                        @if($inquiry->company)
                            <div class="text-xs text-gray-400">{{ $inquiry->company }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="text-gray-700">{{ $inquiry->service?->name ?? '-' }}</div>
                        @if($inquiry->package)
                            <div class="text-xs text-gray-400">{{ $inquiry->package->name }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-gray-600">{{ $inquiry->budget_range ?? '-' }}</td>
                    <td class="px-4 py-3.5">
                        <span class="badge {{ $statusColors[$inquiry->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-gray-400 text-xs">{{ $inquiry->created_at?->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3.5">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                           class="text-accent hover:text-accent-hover text-xs font-medium whitespace-nowrap">Lihat →</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $inquiries->links() }}
    </div>
    @endif
</div>
@endsection
