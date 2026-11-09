@extends('layouts.admin')
@section('page_title', $service->exists ? 'Edit Layanan' : 'Tambah Layanan')
@section('title', $service->exists ? 'Edit Layanan' : 'Tambah Layanan')

@section('content')
<div class="mb-5">
    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-card p-6">
        <h2 class="font-semibold text-navy-900 mb-6">{{ $service->exists ? 'Edit' : 'Tambah' }} Layanan</h2>

        <form method="POST"
              action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
            @csrf
            @if($service->exists) @method('PUT') @endif

            <div class="space-y-4">
                <div>
                    <label class="admin-label">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}"
                           class="admin-input @error('name') border-red-400 @enderror"
                           placeholder="Contoh: Website Company Profile" required
                           x-data x-on:input="document.getElementById('slug').value = $event.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $service->slug) }}"
                           class="admin-input font-mono @error('slug') border-red-400 @enderror"
                           placeholder="website-company-profile" required>
                    @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label">Icon (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $service->icon) }}"
                           class="admin-input" placeholder="🌐">
                    <p class="text-xs text-gray-400 mt-1">Gunakan emoji atau teks singkat sebagai ikon layanan</p>
                </div>

                <div>
                    <label class="admin-label">Deskripsi Singkat</label>
                    <textarea name="short_description" rows="2" class="admin-input resize-y"
                              placeholder="Deskripsi singkat yang tampil di kartu layanan">{{ old('short_description', $service->short_description) }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Deskripsi Lengkap</label>
                    <textarea name="description" rows="6" class="admin-input resize-y"
                              placeholder="Deskripsi lengkap layanan...">{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}"
                               class="admin-input" min="0">
                    </div>
                    <div>
                        <label class="admin-label">Status</label>
                        <label class="flex items-center gap-2 mt-2 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   class="w-4 h-4 rounded border-gray-300 text-accent"
                                   {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Aktif / Tampil di website</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="admin-btn bg-accent text-white hover:bg-accent-hover py-2.5 px-6 focus:ring-accent">
                    {{ $service->exists ? 'Simpan Perubahan' : 'Tambah Layanan' }}
                </button>
                <a href="{{ route('admin.services.index') }}" class="admin-btn bg-gray-100 text-gray-600 hover:bg-gray-200 py-2.5 px-6">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
