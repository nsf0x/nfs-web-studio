@extends('layouts.app')

@section('title', 'NFS Web Studio - Jasa Pembuatan Website Profesional untuk Bisnis')
@section('meta_description', 'Jasa pembuatan website profesional untuk bisnis Anda. Website company profile, toko online, landing page, dan sistem web custom yang modern dan berperforma tinggi.')

@section('json_ld')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => \App\Models\SiteSetting::get('brand_name', 'NFS Web Studio'),
        'url' => config('app.url'),
        'telephone' => \App\Models\SiteSetting::get('phone'),
        'email' => \App\Models\SiteSetting::get('email'),
        'description' => \App\Models\SiteSetting::get('tagline', 'Website Profesional untuk Bisnis Anda'),
    ];
@endphp
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
@endsection

@section('content')
@php
    $wa    = \App\Models\SiteSetting::get('whatsapp', '6288212743260');
    $waMsg = \App\Models\SiteSetting::get('wa_message', 'Halo%20NFS%20Web%20Studio,%20saya%20tertarik%20membuat%20website');
@endphp

{{-- ====================================================
     HERO SECTION
     ==================================================== --}}
<section class="relative overflow-hidden gradient-navy text-white py-20 md:py-32 -mt-16 md:-mt-20 pt-36 md:pt-52">
    {{-- Decorative shapes --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-gold/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-72 h-72 bg-accent/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <span class="inline-block px-4 py-1.5 bg-gold/20 text-gold-light text-sm font-semibold rounded-full mb-6 border border-gold/30">
                🚀 Jasa Website Profesional
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-balance">
                Website yang <span class="text-gold">Membangun</span><br class="hidden sm:block">
                Kepercayaan Bisnis Anda
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                {{ $siteTagline }}. Kami membantu bisnis Anda hadir secara profesional dan mudah ditemukan secara online.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="btn-primary text-base px-8 py-4">
                    Konsultasi via WhatsApp
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#harga" class="btn-secondary text-base px-8 py-4">
                    Lihat Paket Harga
                </a>
            </div>
        </div>

        <div class="mt-16 grid grid-cols-2 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            @foreach([
                ['label' => 'Klien', 'value' => $clients->count()],
                ['label' => 'Proyek', 'value' => $projects->flatten()->count()],
                ['label' => 'Layanan', 'value' => $services->count()],
            ] as $stat)
            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/10">
                <div class="text-3xl font-extrabold text-gold">{{ $stat['value'] }}</div>
                <div class="text-sm text-gray-300 mt-1">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        <div aria-hidden="true" class="mx-auto mt-14 max-w-4xl rounded-2xl border border-white/20 bg-white/10 p-3 shadow-2xl backdrop-blur-sm">
            <div class="overflow-hidden rounded-xl bg-white text-left shadow-card">
                <div class="flex items-center gap-2 border-b border-gray-100 px-4 py-3">
                    <span class="h-2.5 w-2.5 rounded-full bg-red-300"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-yellow-300"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-green-300"></span>
                    <div class="ml-3 h-5 flex-1 rounded bg-gray-100"></div>
                </div>
                <div class="grid min-h-48 grid-cols-5 sm:min-h-64">
                    <div class="col-span-1 space-y-3 bg-navy-900 p-4">
                        <div class="h-3 w-3/4 rounded bg-white/70"></div>
                        <div class="h-2 w-full rounded bg-white/20"></div>
                        <div class="h-2 w-4/5 rounded bg-white/20"></div>
                        <div class="h-2 w-2/3 rounded bg-white/20"></div>
                    </div>
                    <div class="col-span-4 p-5 sm:p-8">
                        <div class="mb-5 h-5 w-2/3 rounded bg-navy-900/10 sm:w-1/2"></div>
                        <div class="mb-7 h-3 w-full rounded bg-gray-100 sm:w-3/4"></div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="h-16 rounded-lg bg-accent/10 sm:h-24"></div>
                            <div class="h-16 rounded-lg bg-gold/20 sm:h-24"></div>
                            <div class="h-16 rounded-lg bg-navy-900/10 sm:h-24"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Klien --}}
@if($clients->isNotEmpty())
<section class="overflow-hidden bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-gray-500">Dipercaya Oleh</p>
            <h2 class="text-2xl font-bold text-navy-900">Klien Kami</h2>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-8">
            @foreach($clients as $client)
                @include('components.client-card', ['client' => $client])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     LAYANAN SECTION
     ==================================================== --}}
<section id="layanan" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14"
             x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Solusi digital lengkap untuk memajukan bisnis Anda di era online</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $index => $service)
                @include('components.service-card', ['service' => $service, 'index' => $index])
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-14 text-center">
            <h2 class="section-title">Mengapa Memilih NFS Web Studio?</h2>
            <p class="section-subtitle">Proses jelas dan solusi yang disesuaikan dengan kebutuhan bisnis Anda.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['title' => 'Desain Profesional', 'description' => 'Tampilan dirancang untuk membantu bisnis Anda tampil terpercaya.'],
                ['title' => 'Responsif di Semua Perangkat', 'description' => 'Website disiapkan agar nyaman digunakan di ponsel, tablet, dan desktop.'],
                ['title' => 'SEO-Friendly', 'description' => 'Struktur dasar website mendukung mesin pencari dan pengalaman pengguna.'],
                ['title' => 'Harga Transparan', 'description' => 'Ruang lingkup dan biaya dibahas dalam penawaran sebelum pekerjaan dimulai.'],
                ['title' => 'Revisi Sesuai Paket', 'description' => 'Jumlah revisi dan cakupan pekerjaan disampaikan dengan jelas.'],
                ['title' => 'Dukungan Setelah Launching', 'description' => 'Dukungan teknis awal dibahas sesuai paket dan kesepakatan proyek.'],
            ] as $benefit)
                <article class="card">
                    <h3 class="mb-2 font-bold text-navy-900">{{ $benefit['title'] }}</h3>
                    <p class="text-sm leading-relaxed text-gray-500">{{ $benefit['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ====================================================
     PAKET HARGA SECTION
     ==================================================== --}}
@if($servicesWithPackages->isNotEmpty())
<section id="harga" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14"
             x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="section-title">Paket Harga</h2>
            <p class="section-subtitle">Harga transparan dan terjangkau—sesuaikan dengan kebutuhan dan anggaran bisnis Anda</p>
        </div>

        {{-- Tab navigation --}}
        <div x-data="{ activeTab: '{{ $servicesWithPackages->first()->id }}' }">
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                @foreach($servicesWithPackages as $svc)
                <button @click="activeTab = '{{ $svc->id }}'"
                        :class="activeTab === '{{ $svc->id }}' ? 'bg-accent text-white shadow-md' : 'bg-gray-100 text-navy-700 hover:bg-gray-200'"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
                    {{ $svc->name }}
                </button>
                @endforeach
            </div>

            @foreach($servicesWithPackages as $svc)
            <div x-show="activeTab === '{{ $svc->id }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($svc->packages as $package)
                        @include('components.package-card', ['package' => $package, 'service' => $svc])
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     PORTOFOLIO SECTION
     ==================================================== --}}
<section id="portofolio" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14"
             x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="section-title">Portofolio</h2>
            <p class="section-subtitle">Proyek yang telah dipublikasikan untuk menunjukkan pengalaman dan hasil kerja kami.</p>
        </div>

        @if($projects->isNotEmpty())
        @foreach($projects->flatten()->take(6)->groupBy('client_id') as $clientProjects)
        <div class="mb-10 last:mb-0">
            @if($clientProjects->first()->client)
                <h3 class="mb-4 text-lg font-bold text-navy-900">{{ $clientProjects->first()->client->name }}</h3>
            @endif
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($clientProjects as $project)
            <a href="{{ route('portofolio.show', $project->slug) }}"
               class="card group overflow-hidden p-0 block"
               x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                {{-- Thumbnail --}}
                <div class="aspect-video bg-gray-100 overflow-hidden relative">
                    @if($project->thumbnail_url)
                        <img src="{{ str_starts_with($project->thumbnail_url, 'http') ? $project->thumbnail_url : Storage::url($project->thumbnail_url) }}"
                             alt="{{ $project->title }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-navy-700 to-accent flex items-center justify-center">
                            <span class="text-white font-bold text-xl">{{ Str::limit($project->title, 2, '') }}</span>
                        </div>
                    @endif
                    @if($project->is_featured)
                        <span class="absolute top-3 left-3 bg-gold text-navy-900 text-xs font-bold px-2 py-0.5 rounded-md">Featured</span>
                    @endif
                </div>
                {{-- Info --}}
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        @if($project->service)
                            <span class="badge bg-accent/10 text-accent">{{ $project->service->name }}</span>
                        @endif
                        @if($project->completed_at)
                            <span class="text-xs text-gray-400">{{ $project->completed_at->format('M Y') }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-navy-900 group-hover:text-accent transition-colors">{{ $project->title }}</h3>
                </div>
            </a>
            @endforeach
            </div>
        </div>
        @endforeach

        <div class="text-center mt-10">
            <a href="{{ route('portofolio') }}" class="btn-secondary">
                Lihat Semua Proyek
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-gray-500">
                Portofolio sedang disiapkan. Silakan hubungi kami untuk membahas kebutuhan proyek Anda.
            </div>
        @endif
    </div>
</section>

<section id="proses" class="bg-gray-50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-14 text-center">
            <h2 class="section-title">Proses Kerja</h2>
            <p class="section-subtitle">Tahapan kerja disepakati bersama agar kebutuhan dan ekspektasi tetap jelas.</p>
        </div>
        <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
            @foreach([
                ['title' => 'Konsultasi', 'description' => 'Ceritakan kebutuhan dan tujuan website Anda.'],
                ['title' => 'Penawaran', 'description' => 'Kami susun ruang lingkup, estimasi, dan biaya.'],
                ['title' => 'Desain', 'description' => 'Tampilan dirancang berdasarkan identitas bisnis Anda.'],
                ['title' => 'Pengembangan & Revisi', 'description' => 'Website dibangun dan ditinjau sesuai paket.'],
                ['title' => 'Peluncuran & Support', 'description' => 'Website diluncurkan dan dukungan dibahas sesuai kesepakatan.'],
            ] as $step)
                <li class="card">
                    <h3 class="mb-2 font-bold text-navy-900">{{ $loop->iteration }}. {{ $step['title'] }}</h3>
                    <p class="text-sm leading-relaxed text-gray-500">{{ $step['description'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- ====================================================
     TESTIMONI SECTION
     ==================================================== --}}
@if($testimonials->isNotEmpty())
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14"
             x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="section-title">Apa Kata Klien Kami</h2>
            <p class="section-subtitle">Kepuasan klien adalah prioritas utama dan kebanggaan kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="card flex flex-col"
                 x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                {{-- Stars --}}
                <div class="flex gap-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-gold' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                {{-- Quote --}}
                <blockquote class="text-gray-600 text-sm leading-relaxed flex-1 mb-5">
                    "{{ $testimonial->content }}"
                </blockquote>
                {{-- Person --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <div class="w-10 h-10 bg-navy-900 rounded-full flex items-center justify-center shrink-0">
                        <span class="text-white text-xs font-bold">{{ strtoupper(substr($testimonial->person_name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-navy-900">{{ $testimonial->person_name }}</div>
                        <div class="text-xs text-gray-400">
                            {{ $testimonial->person_position }}
                            @if($testimonial->client)
                                @if($testimonial->person_position) – @endif
                                {{ $testimonial->client->name }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     FAQ SECTION
     ==================================================== --}}
@if($faqs->isNotEmpty())
<section id="faq" class="py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14"
             x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="section-title">Pertanyaan Umum</h2>
            <p class="section-subtitle">Jawaban atas pertanyaan yang paling sering ditanyakan</p>
        </div>

        <div class="space-y-3" x-data="{ open: null }">
            @foreach($faqs as $index => $faq)
                @include('components.faq-item', ['faq' => $faq, 'index' => $index])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     CTA SECTION
     ==================================================== --}}
<section class="py-20 gradient-navy text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center"
         x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
        <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Siap Memulai Proyek Anda?</h2>
        <p class="text-gray-300 text-lg mb-10 max-w-2xl mx-auto">
            Konsultasikan kebutuhan website Anda bersama kami. Gratis konsultasi, tanpa biaya tersembunyi.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="btn-primary text-base px-8 py-4 bg-gold text-navy-900 hover:bg-gold-light border-0">
                Chat & Transaksi via WhatsApp
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection
