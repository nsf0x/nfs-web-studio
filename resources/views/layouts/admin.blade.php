<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Dashboard') – Admin NFS Web Studio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-0 -translate-x-full lg:w-64 lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 flex flex-col bg-navy-900 text-white transition-all duration-300 overflow-hidden lg:relative lg:translate-x-0">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-navy-700">
            <div class="w-8 h-8 bg-gold rounded-lg flex items-center justify-center font-bold text-navy-900 text-sm">N</div>
            <span class="font-bold text-sm leading-tight">NFS Web Studio<br><span class="text-gray-400 font-normal text-xs">Admin Panel</span></span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'icon' => 'grid', 'label' => 'Dashboard'],
                    ['route' => 'admin.inquiries.index', 'icon' => 'mail', 'label' => 'Inquiry'],
                    ['route' => 'admin.services.index', 'icon' => 'briefcase', 'label' => 'Layanan'],
                    ['route' => 'admin.packages.index', 'icon' => 'package', 'label' => 'Paket'],
                    ['route' => 'admin.clients.index', 'icon' => 'users', 'label' => 'Klien'],
                    ['route' => 'admin.projects.index', 'icon' => 'folder', 'label' => 'Proyek'],
                    ['route' => 'admin.testimonials.index', 'icon' => 'star', 'label' => 'Testimoni'],
                    ['route' => 'admin.faqs.index', 'icon' => 'help-circle', 'label' => 'FAQ'],
                    ['route' => 'admin.settings.index', 'icon' => 'settings', 'label' => 'Pengaturan'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs($item['route'].'*') ? 'bg-accent text-white' : 'text-gray-300 hover:bg-navy-700 hover:text-white' }}">
                    @include('components.admin-icon', ['name' => $item['icon']])
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-navy-700">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-red-600 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak></div>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 flex items-center gap-4 px-4 lg:px-6 h-16 shrink-0">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="font-semibold text-navy-900 text-lg flex-1">@yield('page_title', 'Dashboard')</h1>
            <div class="text-sm text-gray-500">{{ auth('admin')->user()->name ?? 'Admin' }}</div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
