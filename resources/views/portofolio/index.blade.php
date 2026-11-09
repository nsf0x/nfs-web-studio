@extends('layouts.app')

@section('title', 'Portofolio')
@section('meta_description', 'Koleksi proyek website yang telah kami kerjakan. Lihat karya nyata kami dalam membangun website profesional untuk berbagai bisnis.')

@section('content')

{{-- Hero --}}
<section class="gradient-navy text-white py-20 -mt-16 md:-mt-20 pt-36 md:pt-44">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">Portofolio Kami</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Setiap proyek adalah bukti nyata komitmen kami terhadap kualitas dan kepuasan klien</p>
    </div>
</section>

{{-- Proyek Grid --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($projects->isEmpty())
        <div class="text-center py-20">
            <p class="text-gray-400 text-lg">Belum ada proyek yang dipublikasikan.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
            <a href="{{ route('portofolio.show', $project->slug) }}"
               class="card group overflow-hidden p-0 block"
               x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                {{-- Thumbnail --}}
                <div class="aspect-video bg-gray-100 overflow-hidden relative">
                    @if($project->thumbnail_url)
                        <img src="{{ str_starts_with($project->thumbnail_url, 'http') ? $project->thumbnail_url : Storage::url($project->thumbnail_url) }}"
                             alt="{{ $project->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-navy-700 to-accent flex items-center justify-center">
                            <span class="text-white font-bold text-3xl">{{ Str::upper(substr($project->title, 0, 2)) }}</span>
                        </div>
                    @endif
                    @if($project->is_featured)
                        <span class="absolute top-3 left-3 bg-gold text-navy-900 text-xs font-bold px-2 py-0.5 rounded-md">Featured</span>
                    @endif
                </div>
                {{-- Info --}}
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        @if($project->service)
                            <span class="badge bg-accent/10 text-accent">{{ $project->service->name }}</span>
                        @endif
                        @if($project->completed_at)
                            <span class="text-xs text-gray-400">{{ $project->completed_at->format('M Y') }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-navy-900 group-hover:text-accent transition-colors mb-1">{{ $project->title }}</h3>
                    @if($project->client)
                        <p class="text-xs text-gray-400">{{ $project->client->name }}</p>
                    @endif
                    @if($project->tech_stack)
                        <p class="text-xs text-gray-300 mt-2 font-mono">{{ $project->tech_stack }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold text-navy-900 mb-3">Ingin Menjadi Bagian dari Portofolio Kami?</h2>
        <p class="text-gray-500 mb-7">Hubungi kami sekarang dan diskusikan proyek website impian Anda.</p>
        <a href="{{ route('kontak') }}" class="btn-primary">
            Mulai Proyek Anda
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

@endsection
