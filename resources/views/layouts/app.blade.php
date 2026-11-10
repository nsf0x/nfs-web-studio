<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ packageDetails: null }"
      x-on:show-package-details.window="packageDetails = $event.detail"
      x-on:keydown.escape.window="packageDetails = null">
<head>
    @php
        $pageTitle = trim($__env->yieldContent('title'));
        $siteName = \App\Models\SiteSetting::get('brand_name', 'NFS Web Studio');
        $baseUrl = rtrim(config('app.url'), '/');
        $canonicalUrl = $baseUrl . '/' . ltrim(request()->path(), '/');
        $shouldNoIndex = ! app()->environment('production')
            || str_contains($baseUrl, 'localhost')
            || str_contains($baseUrl, '127.0.0.1');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- SEO: title --}}
    <title>{{ $pageTitle ? (str_contains($pageTitle, $siteName) ? $pageTitle : $pageTitle . ' | ' . $siteName) : 'NFS Web Studio - Jasa Pembuatan Website Profesional untuk Bisnis' }}</title>

    {{-- SEO: meta --}}
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('tagline', 'Website Profesional untuk Bisnis Anda'))">
    <meta name="robots" content="@yield('robots', $shouldNoIndex ? 'noindex,nofollow' : 'index,follow')">
    <link rel="canonical" href="@yield('canonical', $canonicalUrl)">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ \App\Models\SiteSetting::get('brand_name', 'NFS Web Studio') }}">
    <meta property="og:title" content="@yield('og_title', $pageTitle ?: $siteName)">
    <meta property="og:description" content="@yield('meta_description', \App\Models\SiteSetting::get('tagline', 'Website Profesional untuk Bisnis Anda'))">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="@yield('og_image', $baseUrl . '/logo.svg')">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle ?: $siteName }}">
    <meta name="twitter:description" content="@yield('meta_description', \App\Models\SiteSetting::get('tagline', 'Website Profesional untuk Bisnis Anda'))">

    {{-- JSON-LD --}}
    @hasSection('json_ld')
    <script type="application/ld+json">@yield('json_ld')</script>
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="font-sans antialiased bg-white text-navy-900">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Page content --}}
    <main>
        @yield('content')
    </main>

    @include('components.package-detail-modal')

    @include('components.package-detail-modal')

    {{-- Footer --}}
    @include('components.footer')

    {{-- WhatsApp floating button --}}
    @include('components.whatsapp-button')

    @stack('scripts')
</body>
</html>
