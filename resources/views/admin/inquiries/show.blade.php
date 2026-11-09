@extends('layouts.admin')
@section('page_title', 'Detail Inquiry')
@section('title', 'Detail Inquiry')

@section('content')
@php
    $statusColors = ['new'=>'bg-blue-100 text-blue-700','contacted'=>'bg-yellow-100 text-yellow-700','negotiation'=>'bg-orange-100 text-orange-700','won'=>'bg-green-100 text-green-700','lost'=>'bg-red-100 text-red-700'];
    $statusLabels = ['new'=>'Baru','contacted'=>'Dihubungi','negotiation'=>'Negosiasi','won'=>'Berhasil','lost'=>'Gagal'];
@endphp

<div class="mb-5">
    <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Main info --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-white rounded-xl shadow-card p-6">
            <div class="flex items-start justify-between mb-5">
                <h2 class="text-xl font-bold text-navy-900">{{ $inquiry->name }}</h2>
                <span class="badge {{ $statusColors[$inquiry->status] ?? '' }}">{{ $statusLabels[$inquiry->status] ?? $inquiry->status }}</span>
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Email</dt>
                    <dd><a href="mailto:{{ $inquiry->email }}" class="text-accent">{{ $inquiry->email }}</a></dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Telepon / WA</dt>
                    <dd>
                        @if($inquiry->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="text-green-600">{{ $inquiry->phone }}</a>
                        @else -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Perusahaan</dt>
                    <dd>{{ $inquiry->company ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Layanan</dt>
                    <dd>{{ $inquiry->service?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Paket</dt>
                    <dd>{{ $inquiry->package?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Budget</dt>
                    <dd>{{ $inquiry->budget_range ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Waktu Masuk</dt>
                    <dd>{{ $inquiry->created_at?->format('d F Y, H:i') }} WIB</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-card p-6">
            <h3 class="font-semibold text-navy-900 mb-3">Pesan</h3>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-wrap">{{ $inquiry->message }}</p>
        </div>

        {{-- Quick actions --}}
        <div class="bg-white rounded-xl shadow-card p-6">
            <h3 class="font-semibold text-navy-900 mb-4">Tindak Lanjut</h3>
            <div class="flex flex-wrap gap-3">
                @if($inquiry->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}?text={{ urlencode('Halo ' . $inquiry->name . ', terima kasih telah menghubungi NFS Web Studio!') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-600 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Balas WhatsApp
                </a>
                @endif
                <a href="mailto:{{ $inquiry->email }}" class="inline-flex items-center gap-2 px-4 py-2 bg-accent text-white rounded-lg text-sm font-medium hover:bg-accent-hover transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Balas Email
                </a>
            </div>
        </div>
    </div>

    {{-- Status update --}}
    <div>
        <div class="bg-white rounded-xl shadow-card p-5">
            <h3 class="font-semibold text-navy-900 mb-4">Ubah Status</h3>
            <form method="POST" action="{{ route('admin.inquiries.status', $inquiry) }}">
                @csrf @method('PATCH')
                <div class="space-y-2 mb-4">
                    @foreach(['new'=>'Baru','contacted'=>'Dihubungi','negotiation'=>'Negosiasi','won'=>'Berhasil','lost'=>'Gagal'] as $val => $lbl)
                    <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-colors {{ $inquiry->status === $val ? 'border-accent bg-accent/5' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="status" value="{{ $val }}" {{ $inquiry->status === $val ? 'checked' : '' }} class="text-accent">
                        <span class="text-sm font-medium badge {{ $statusColors[$val] }}">{{ $lbl }}</span>
                    </label>
                    @endforeach
                </div>
                <button type="submit" class="w-full admin-btn bg-navy-900 text-white hover:bg-navy-700 py-2.5">
                    Simpan Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
