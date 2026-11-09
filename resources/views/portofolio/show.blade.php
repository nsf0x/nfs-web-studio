@extends('layouts.app')

@section('title', $project->title)
@section('meta_description', Str::limit(strip_tags($project->description), 160))

@section('json_ld')
{
  "@context": "https://schema.org",
  "@type": "CreativeWork",
  "name": "{{ $project->title }}",
  "description": "{{ Str::limit(strip_tags($project->description), 200) }}",
  "url": "{{ url()->current() }}",
  "creator": {
    "@type": "Organization",
    "name": "{{ \App\Models\SiteSetting::get('brand_name', 'NFS Web Studio') }}"
  }
  @if($project->completed_at)
  ,"dateCreated": "{{ $project->completed_at->toIso8601String() }}"
  @endif
}
@endsection

@section('content')
@php
    $wa    = \App\Models\SiteSetting::get('whatsapp', '6288212743260');
    $waMsg = urlencode('Halo NFS Web Studio, saya tertarik membuat website seperti proyek ' . $project->title);
@endphp

{{-- Hero --}}
<section class="gradient-navy text-white py-16 -mt-16 md:-mt-20 pt-36 md:pt-44">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('portofolio') }}" class="hover:text-gold transition-colors">Portofolio</a>
            <span>/</span>
            <span class="text-gold">{{ Str::limit($project->title, 40) }}</span>
        </nav>

        <div class="flex flex-wrap items-center gap-3 mb-4">
            @if($project->service)
                <span class="badge bg-gold/20 text-gold border border-gold/30">{{ $project->service->name }}</span>
            @endif
            @if($project->is_featured)
                <span class="badge bg-white/10 text-white border border-white/20">⭐ Featured</span>
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold mb-3">{{ $project->title }}</h1>

        <div class="flex flex-wrap gap-4 text-sm text-gray-300">
            @if($project->client)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    {{ $project->client->name }}
                </span>
            @endif
            @if($project->completed_at)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $project->completed_at->format('d F Y') }}
                </span>
            @endif
            @if($project->project_url)
                <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-1.5 text-gold hover:text-gold-light transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website
                </a>
            @endif
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Thumbnail --}}
            <div class="lg:col-span-2">
                @if($project->thumbnail_url)
                    <img src="{{ str_starts_with($project->thumbnail_url, 'http') ? $project->thumbnail_url : Storage::url($project->thumbnail_url) }}"
                         alt="{{ $project->title }}"
                         class="w-full rounded-2xl shadow-hover">
                @else
                    <div class="aspect-video bg-gradient-to-br from-navy-700 to-accent rounded-2xl flex items-center justify-center">
                        <span class="text-white font-bold text-5xl">{{ Str::upper(substr($project->title, 0, 2)) }}</span>
                    </div>
                @endif

                @if($project->description)
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-navy-900 mb-4">Tentang Proyek</h2>
                    <div class="prose text-gray-600 max-w-none">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar info --}}
            <div class="space-y-6">
                <div class="card">
                    <h3 class="font-semibold text-navy-900 mb-4">Detail Proyek</h3>
                    <dl class="space-y-3 text-sm">
                        @if($project->client)
                        <div>
                            <dt class="text-gray-400 mb-0.5">Klien</dt>
                            <dd class="font-medium text-navy-900">{{ $project->client->name }}</dd>
                        </div>
                        @endif
                        @if($project->service)
                        <div>
                            <dt class="text-gray-400 mb-0.5">Jenis Layanan</dt>
                            <dd class="font-medium text-navy-900">{{ $project->service->name }}</dd>
                        </div>
                        @endif
                        @if($project->completed_at)
                        <div>
                            <dt class="text-gray-400 mb-0.5">Tanggal Selesai</dt>
                            <dd class="font-medium text-navy-900">{{ $project->completed_at->format('d F Y') }}</dd>
                        </div>
                        @endif
                        @if($project->tech_stack)
                        <div>
                            <dt class="text-gray-400 mb-0.5">Teknologi</dt>
                            <dd class="font-mono text-xs text-gray-600">{{ $project->tech_stack }}</dd>
                        </div>
                        @endif
                    </dl>

                    @if($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer"
                       class="mt-5 btn-primary w-full justify-center text-sm">
                        Kunjungi Website
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    @endif
                </div>

                <div class="card bg-navy-900 text-white">
                    <h3 class="font-semibold mb-3">Tertarik Proyek Serupa?</h3>
                    <p class="text-sm text-gray-300 mb-4">Hubungi kami dan wujudkan ide website Anda bersama tim profesional kami.</p>
                    <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer"
                       class="btn-wa w-full justify-center text-sm">
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Back --}}
        <div class="mt-10">
            <a href="{{ route('portofolio') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-accent transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Portofolio
            </a>
        </div>
    </div>
</section>

@endsection
