<article class="card group border border-transparent transition-all duration-300 hover:border-accent"
         x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
         style="animation-delay: {{ $index * 100 }}ms">
    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/10 transition-all duration-300 group-hover:bg-accent group-hover:text-white">
        <span class="text-2xl" role="img" aria-label="{{ $service->name }}">{{ $service->icon ?: '🌐' }}</span>
    </div>
    <h3 class="mb-2 text-lg font-bold text-navy-900">{{ $service->name }}</h3>
    <p class="mb-5 text-sm leading-relaxed text-gray-500">{{ $service->short_description }}</p>
    <a href="{{ route('layanan.show', $service->slug) }}"
       class="inline-flex items-center gap-1.5 text-sm font-semibold text-accent transition-all duration-200 hover:gap-3">
        Lihat Detail
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
</article>
