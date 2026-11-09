<article class="relative flex flex-col rounded-2xl border-2 p-6 transition-all duration-300
                {{ $package->is_featured ? 'border-accent bg-navy-900 text-white shadow-hover' : 'border-gray-200 bg-white hover:border-accent hover:shadow-hover' }}">
    @if($package->is_featured)
        <span class="absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-gold px-4 py-1 text-xs font-bold text-navy-900">Paling Diminati</span>
    @endif

    <div class="mb-5">
        <h3 class="mb-1 text-xl font-bold">{{ $package->name }}</h3>
        @if($package->price > 0 && $package->price_note)
            <p class="{{ $package->is_featured ? 'text-gray-300' : 'text-gray-500' }} text-sm">{{ $package->price_note }}</p>
        @endif
    </div>

    <div class="mb-5">
        @if($package->price > 0)
            <span class="text-3xl font-extrabold {{ $package->is_featured ? 'text-gold' : 'text-navy-900' }}">
                Rp{{ number_format((float) $package->price, 0, ',', '.') }}
            </span>
        @else
            <span class="text-lg font-bold {{ $package->is_featured ? 'text-gold' : 'text-navy-900' }}">Hubungi kami untuk penawaran</span>
        @endif
        <div class="mt-2 flex gap-4 text-sm {{ $package->is_featured ? 'text-gray-300' : 'text-gray-500' }}">
            @if($package->delivery_days)
                <span>{{ $package->delivery_days }} hari</span>
            @endif
            @if($package->revision_count !== null)
                <span>{{ $package->revision_count }}x revisi</span>
            @endif
        </div>
    </div>

    <ul class="mb-7 flex-1 space-y-2.5">
        @foreach($package->features as $feature)
            <li class="flex items-start gap-2 text-sm">
                <svg class="mt-0.5 h-4 w-4 shrink-0 {{ $package->is_featured ? 'text-gold' : 'text-green-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ $feature->feature }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('kontak') }}?layanan={{ $service->id }}&paket={{ $package->id }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-center font-semibold shadow-md transition-all duration-200 hover:shadow-hover
              {{ $package->is_featured ? 'bg-gold text-navy-900 hover:bg-gold-light' : 'btn-primary' }}">
        Pilih Paket Ini
    </a>
</article>
