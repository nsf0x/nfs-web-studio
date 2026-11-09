<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
@php($baseUrl = rtrim(config('app.url'), '/'))
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Static pages --}}
    <url>
        <loc>{{ $baseUrl }}/</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ $baseUrl }}/kontak</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ $baseUrl }}/portofolio</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ $baseUrl }}/kebijakan-privasi</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ $baseUrl }}/syarat-ketentuan</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    {{-- Services --}}
    @foreach($services as $service)
    <url>
        <loc>{{ $baseUrl }}/layanan/{{ $service->slug }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
        <lastmod>{{ $service->updated_at ? $service->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
    </url>
    @endforeach

    {{-- Projects --}}
    @foreach($projects as $project)
    <url>
        <loc>{{ $baseUrl }}/portofolio/{{ $project->slug }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
        @if($project->completed_at)
        <lastmod>{{ $project->completed_at->toAtomString() }}</lastmod>
        @endif
    </url>
    @endforeach
</urlset>
