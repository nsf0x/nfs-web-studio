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
    $wa    = \App\Models\SiteSetting::get('whatsapp', '6288212743260');
    $waMsg = urlencode('Halo NFS Web Studio, saya tertarik dengan layanan ' . $layanan->name);
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
                <a href="{{ route('kontak') }}?layanan={{ $layanan->id }}" class="btn-primary">
                    Pesan Layanan Ini
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="btn-wa">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Tanya via WhatsApp
                </a>
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
        <a href="{{ route('kontak') }}?layanan={{ $layanan->id }}" class="btn-primary mt-8">Konsultasi untuk Penawaran Sesuai Kebutuhan</a>
    </div>
</section>
@endif

@endsection
