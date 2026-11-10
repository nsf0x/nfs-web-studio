@extends('layouts.app')

@section('title', $layanan->name)
@section('meta_description', $layanan->short_description)

@section('json_ld')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $layanan->name,
        'description' => $layanan->short_description,
        'provider' => [
            '@type' => 'Organization',
            'name' => \App\Models\SiteSetting::get('brand_name', 'NFS Web Studio'),
            'url' => config('app.url'),
        ],
        'url' => rtrim(config('app.url'), '/') . request()->getPathInfo(),
    ];
@endphp
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
@endsection

@section('content')
@php
    $wa = preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('whatsapp', '6288212743260'));
    $waMsg = urlencode('Halo NFS Web Studio, saya tertarik dengan layanan ' . $layanan->name . '. Mohon informasi lebih lanjut.');
@endphp

{{-- Breadcrumb + Hero --}}
<section class="gradient-navy text-white py-20 -mt-16 md:-mt-20 pt-36 md:pt-44">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-gold">{{ $layanan->name }}</span>
        </nav>

        <div class="max-w-3xl">
            <div class="text-4xl mb-5">{{ $layanan->icon ?: '🌐' }}</div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-5">{{ $layanan->name }}</h1>
            <p class="text-gray-300 text-lg leading-relaxed mb-8">{{ $layanan->short_description }}</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="btn-primary">
                    Chat & Transaksi via WhatsApp
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('kontak') }}" class="btn-wa">Informasi Kontak</a>
            </div>
        </div>
    </div>
</section>

{{-- Deskripsi --}}
@if($layanan->description)
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-gray-600">
            {!! nl2br(e($layanan->description)) !!}
        </div>
    </div>
</section>
@endif

{{-- Paket --}}
@if($layanan->packages->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title">Pilih Paket {{ $layanan->name }}</h2>
            <p class="section-subtitle">Pilih paket yang paling sesuai dengan kebutuhan dan anggaran Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($layanan->packages as $package)
                @include('components.package-card', ['package' => $package, 'service' => $layanan])
            @endforeach
        </div>
    </div>
</section>
@else
<section class="bg-gray-50 py-16">
    <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
        <h2 class="section-title">Butuh solusi khusus?</h2>
        <p class="section-subtitle">Konsultasikan kebutuhan Anda untuk mendapatkan penawaran yang sesuai.</p>
        <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-8">Konsultasikan via WhatsApp</a>
    </div>
</section>
@endif

@endsection
