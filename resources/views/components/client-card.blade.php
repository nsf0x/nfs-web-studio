<div class="flex items-center justify-center opacity-75 transition-all duration-300 hover:opacity-100"
     title="{{ $client->name }}">
    @if($client->website_url)
        <a href="{{ $client->website_url }}" target="_blank" rel="noopener noreferrer"
           aria-label="Kunjungi website {{ $client->name }}">
    @endif
    @if($client->logo_url)
        <img src="{{ str_starts_with($client->logo_url, 'http://') || str_starts_with($client->logo_url, 'https://') ? $client->logo_url : Storage::url($client->logo_url) }}"
             alt="Logo {{ $client->name }}"
             loading="lazy"
             class="h-10 max-w-[160px] object-contain">
    @else
        <div class="flex h-12 min-w-12 items-center justify-center rounded-lg bg-white px-4 shadow-card" aria-label="{{ $client->name }}">
            <span class="text-sm font-bold text-navy-900">{{ $client->initials }}</span>
        </div>
    @endif
    @if($client->website_url)
        </a>
    @endif
</div>
