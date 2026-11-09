<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 – Halaman Tidak Ditemukan | NFS Web Studio</title>
    <meta name="robots" content="noindex">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center px-4 py-20">
        <div class="text-8xl font-black text-navy-900/10 mb-4">404</div>
        <h1 class="text-3xl font-bold text-navy-900 mb-3">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-500 max-w-sm mx-auto mb-8">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Kembali ke Beranda
            </a>
            <a href="{{ url('/kontak') }}" class="btn-secondary">
                Hubungi Kami
            </a>
        </div>
    </div>
</body>
</html>
