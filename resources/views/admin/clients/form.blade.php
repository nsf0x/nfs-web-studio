@extends('layouts.admin')
@section('page_title', isset($client->id) ? 'Edit Klien' : 'Tambah Klien')
@section('title', isset($client->id) ? 'Edit Klien' : 'Tambah Klien')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Klien
    </a>

    <div class="bg-white rounded-xl shadow-card p-6">
        <form method="POST"
              action="{{ isset($client->id) ? route('admin.clients.update', $client) : route('admin.clients.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($client->id)) @method('PUT') @endif

            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="space-y-5">
                <div>
                    <label class="admin-label">Nama Klien <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $client->name) }}"
                           class="admin-input @error('name') border-red-400 @enderror" required>
                </div>

                <div>
                    <label class="admin-label">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $client->slug) }}"
                           class="admin-input @error('slug') border-red-400 @enderror" required>
                    <p class="text-xs text-gray-400 mt-1">Identifier unik, huruf kecil, tanpa spasi (mis: pt-maju-jaya)</p>
                </div>

                <div>
                    <label class="admin-label">Logo Klien</label>
                    @if(isset($client->id) && $client->logo_url)
                        <div class="mb-2">
                            <img src="{{ str_starts_with($client->logo_url, 'http://') || str_starts_with($client->logo_url, 'https://') ? $client->logo_url : Storage::url($client->logo_url) }}"
                                 alt="Logo saat ini" class="h-12 object-contain">
                            <p class="text-xs text-gray-400 mt-1">Logo saat ini. Ganti URL atau pilih file baru untuk menggantinya.</p>
                        </div>
                    @endif
                    <label class="admin-label" for="logo_url">URL Gambar Logo</label>
                    <input type="url" id="logo_url" name="logo_url" value="{{ old('logo_url', $client->logo_url && (str_starts_with($client->logo_url, 'http://') || str_starts_with($client->logo_url, 'https://')) ? $client->logo_url : '') }}"
                           class="admin-input @error('logo_url') border-red-400 @enderror"
                           placeholder="https://contoh.com/logo.png">
                    @error('logo_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1">Gunakan URL langsung ke file gambar publik (JPG, PNG, atau WebP).</p>

                    @if(env('VERCEL'))
                        <p class="mt-2 text-xs text-amber-700">Upload file belum tersimpan permanen di Vercel. Gunakan URL gambar publik di atas.</p>
                    @else
                        <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="admin-input @error('logo') border-red-400 @enderror">
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP. Maks 2MB. Jika mengisi URL dan upload sekaligus, file upload dipakai.</p>
                    @endif
                </div>

                <div>
                    <label class="admin-label">URL Website</label>
                    <input type="url" name="website_url" value="{{ old('website_url', $client->website_url) }}"
                           class="admin-input @error('website_url') border-red-400 @enderror"
                           placeholder="https://www.contoh.com">
                </div>

                <div>
                    <label class="admin-label">Industri</label>
                    <input type="text" name="industry" value="{{ old('industry', $client->industry) }}"
                           class="admin-input @error('industry') border-red-400 @enderror"
                           placeholder="mis: Kuliner, Fashion, Properti">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $client->sort_order ?? 0) }}"
                               class="admin-input" min="0">
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-accent rounded border-gray-300 focus:ring-accent">
                        <label for="is_active" class="text-sm text-gray-700">Aktif / Tampilkan</label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary text-sm py-2 px-5">
                    {{ isset($client->id) ? 'Simpan Perubahan' : 'Tambah Klien' }}
                </button>
                <a href="{{ route('admin.clients.index') }}" class="btn-secondary text-sm py-2 px-5">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
