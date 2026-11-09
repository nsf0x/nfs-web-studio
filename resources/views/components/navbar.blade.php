@php
    $brand = \App\Models\SiteSetting::get('brand_name', 'NFS Web Studio');
    $wa    = \App\Models\SiteSetting::get('whatsapp', '6288212743260');
    $waMsg = \App\Models\SiteSetting::get('wa_message', 'Halo%20NFS%20Web%20Studio,%20saya%20tertarik%20membuat%20website');
    $services = \App\Models\Service::active()->get();
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    :class="open || scrolled ? 'bg-white/95 shadow-md backdrop-blur-sm' : 'bg-transparent'"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center" aria-label="{{ $brand }}">
                <img x-show="!scrolled && !open" src="{{ asset('logo-light.svg') }}" alt="{{ $brand }}" class="h-9 w-auto">
                <img x-show="scrolled || open" x-cloak src="{{ asset('logo.svg') }}" alt="{{ $brand }}" class="h-9 w-auto">
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   :class="scrolled || open ? 'text-navy-900' : 'text-white'"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-accent/5 hover:text-accent">
                    Beranda
                </a>

                {{-- Layanan dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            :class="scrolled || open ? 'text-navy-900' : 'text-white'"
                            class="flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-medium hover:text-accent hover:bg-accent/5 transition-colors">
                        Layanan
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-hover border border-gray-100 py-1 z-10">
                        @foreach($services as $svc)
                            <a href="{{ route('layanan.show', $svc->slug) }}"
                               class="block px-4 py-2.5 text-sm text-navy-700 hover:text-accent hover:bg-accent/5 transition-colors">
                                {{ $svc->name }}
                            </a>
                        @endforeach
                        @if($services->isEmpty())
                            <span class="block px-4 py-2.5 text-sm text-gray-400">Belum ada layanan</span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('home') }}#harga" :class="scrolled || open ? 'text-navy-900' : 'text-white'" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-accent/5 hover:text-accent">Paket</a>
                <a href="{{ route('portofolio') }}"
                   :class="scrolled || open ? 'text-navy-900' : 'text-white'"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-accent/5 hover:text-accent">
                    Portofolio
                </a>
                <a href="{{ route('home') }}#proses" :class="scrolled || open ? 'text-navy-900' : 'text-white'" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-accent/5 hover:text-accent">Proses</a>
                <a href="{{ route('home') }}#faq" :class="scrolled || open ? 'text-navy-900' : 'text-white'" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-accent/5 hover:text-accent">FAQ</a>
                <a href="{{ route('kontak') }}"
                   :class="scrolled || open ? 'text-navy-900' : 'text-white'"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-accent/5 hover:text-accent">
                    Kontak
                </a>
            </nav>

            {{-- CTA + Mobile burger --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#kontak-singkat"
                   class="hidden sm:inline-flex btn-primary text-sm py-2 px-4">
                    Konsultasi Gratis
                </a>

                {{-- Hamburger --}}
                <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-label="Menu">
                    <svg :class="open || scrolled ? 'text-navy-900' : 'text-white'" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition x-cloak class="md:hidden border-t border-gray-100 pb-4">
            <nav class="pt-3 space-y-1">
                <a href="{{ route('home') }}" @click="open=false" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy-900 hover:bg-accent/5 hover:text-accent transition-colors">Beranda</a>
                @foreach($services as $svc)
                    <a href="{{ route('layanan.show', $svc->slug) }}" @click="open=false" class="block px-6 py-2 rounded-lg text-sm text-navy-700 hover:bg-accent/5 hover:text-accent transition-colors">{{ $svc->name }}</a>
                @endforeach
                <a href="{{ route('home') }}#harga" @click="open=false" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy-900 hover:bg-accent/5 hover:text-accent transition-colors">Paket</a>
                <a href="{{ route('portofolio') }}" @click="open=false" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy-900 hover:bg-accent/5 hover:text-accent transition-colors">Portofolio</a>
                <a href="{{ route('home') }}#proses" @click="open=false" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy-900 hover:bg-accent/5 hover:text-accent transition-colors">Proses</a>
                <a href="{{ route('home') }}#faq" @click="open=false" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy-900 hover:bg-accent/5 hover:text-accent transition-colors">FAQ</a>
                <a href="{{ route('kontak') }}" @click="open=false" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy-900 hover:bg-accent/5 hover:text-accent transition-colors">Kontak</a>
                <div class="pt-2">
                    <a href="{{ route('home') }}#kontak-singkat" @click="open=false" class="btn-primary mb-2 w-full justify-center text-sm">
                        Konsultasi Gratis
                    </a>
                    <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer"
                       class="btn-wa w-full justify-center text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat WhatsApp
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>

{{-- Spacer untuk fixed header --}}
<div class="h-16 md:h-20"></div>
