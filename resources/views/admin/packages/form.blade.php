@extends('layouts.admin')
@section('page_title', $package->exists ? 'Edit Paket' : 'Tambah Paket')
@section('title', $package->exists ? 'Edit Paket' : 'Tambah Paket')

@section('content')
<div class="mb-5">
    <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-card p-6">
        <h2 class="font-semibold text-navy-900 mb-6">{{ $package->exists ? 'Edit' : 'Tambah' }} Paket</h2>

        <form method="POST"
              action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}">
            @csrf
            @if($package->exists) @method('PUT') @endif

            <div class="space-y-4">
                <div>
                    <label class="admin-label">Layanan <span class="text-red-500">*</span></label>
                    <select name="service_id" class="admin-input @error('service_id') border-red-400 @enderror" required>
                        <option value="">— Pilih Layanan —</option>
                        @foreach($services as $svc)
                        <option value="{{ $svc->id }}" {{ old('service_id', $package->service_id) == $svc->id ? 'selected' : '' }}>{{ $svc->name }}</option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Nama Paket <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $package->name) }}"
                               class="admin-input @error('name') border-red-400 @enderror"
                               placeholder="Paket Starter" required
                               x-data x-on:input="document.getElementById('pkg-slug').value = $event.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label">Slug <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" id="pkg-slug" value="{{ old('slug', $package->slug) }}"
                               class="admin-input font-mono @error('slug') border-red-400 @enderror"
                               placeholder="paket-starter" required>
                        @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $package->price) }}"
                               class="admin-input @error('price') border-red-400 @enderror"
                               placeholder="1500000" min="0" required>
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label">Catatan Harga</label>
                        <input type="text" name="price_note" value="{{ old('price_note', $package->price_note) }}"
                               class="admin-input" placeholder="Mulai dari / Per halaman">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Waktu Pengerjaan (hari)</label>
                        <input type="number" name="delivery_days" value="{{ old('delivery_days', $package->delivery_days) }}"
                               class="admin-input" placeholder="14" min="1">
                    </div>
                    <div>
                        <label class="admin-label">Jumlah Revisi</label>
                        <input type="number" name="revision_count" value="{{ old('revision_count', $package->revision_count) }}"
                               class="admin-input" placeholder="3" min="0">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order ?? 0) }}"
                               class="admin-input" min="0">
                    </div>
                    <div class="flex flex-col gap-2 mt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   class="w-4 h-4 rounded border-gray-300 text-accent"
                                   {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1"
                                   class="w-4 h-4 rounded border-gray-300 text-accent"
                                   {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Featured (highlight)</span>
                        </label>
                    </div>
                </div>

                {{-- Features --}}
                <div x-data="{ features: {{ json_encode(old('features', $package->exists ? $package->features->pluck('feature')->toArray() : [''])) }} }">
                    <label class="admin-label">Fitur-fitur Paket</label>
                    <div class="space-y-2">
                        <template x-for="(feature, idx) in features" :key="idx">
                            <div class="flex items-center gap-2">
                                <input type="text" :name="'features[' + idx + ']'" x-model="features[idx]"
                                       class="admin-input flex-1" placeholder="Contoh: Desain responsif mobile-friendly">
                                <button type="button" @click="features.splice(idx, 1)"
                                        class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" x-show="features.length > 1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="features.push('')"
                            class="mt-2 inline-flex items-center gap-1.5 text-sm text-accent hover:text-accent-hover font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Fitur
                    </button>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="admin-btn bg-accent text-white hover:bg-accent-hover py-2.5 px-6 focus:ring-accent">
                    {{ $package->exists ? 'Simpan Perubahan' : 'Tambah Paket' }}
                </button>
                <a href="{{ route('admin.packages.index') }}" class="admin-btn bg-gray-100 text-gray-600 hover:bg-gray-200 py-2.5 px-6">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
