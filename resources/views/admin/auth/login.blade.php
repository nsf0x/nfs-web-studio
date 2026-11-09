<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – NFS Web Studio</title>
    <meta name="robots" content="noindex,nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-sm">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-navy-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-gold font-black text-xl">NFS</span>
            </div>
            <h1 class="text-2xl font-bold text-navy-900">Admin Panel</h1>
            <p class="text-gray-500 text-sm mt-1">NFS Web Studio</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-card p-8">
            <h2 class="text-lg font-semibold text-navy-900 mb-6">Login ke Akun Admin</h2>

            @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="admin-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="admin-input @error('email') border-red-400 @enderror"
                           placeholder="admin@nfsweb.com" required autofocus autocomplete="email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="admin-label">Password</label>
                    <input type="password" id="password" name="password"
                           class="admin-input @error('password') border-red-400 @enderror"
                           placeholder="••••••••" required autocomplete="current-password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-accent">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-navy-900 text-white font-semibold rounded-xl hover:bg-navy-700 transition-colors focus:outline-none focus:ring-2 focus:ring-navy-900 focus:ring-offset-2">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            &copy; {{ date('Y') }} NFS Web Studio
        </p>
    </div>
</body>
</html>
