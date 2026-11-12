@extends('layouts.admin')
@section('page_title', isset($project->id) ? 'Edit Proyek' : 'Tambah Proyek')
@section('title', isset($project->id) ? 'Edit Proyek' : 'Tambah Proyek')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Proyek
    </a>

    <div class="bg-white rounded-xl shadow-card p-6">
        <form method="POST"
              action="{{ isset($project->id) ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($project->id)) @method('PUT') @endif

            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="admin-label">Klien <span class="text-red-500">*</span></label>
                        <select name="client_id" class="admin-input @error('client_id') border-red-400 @enderror" required>
                            <option value="">— Pilih Klien —</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="admin-label">Layanan</label>
                        <select name="service_id" class="admin-input @error('service_id') border-red-400 @enderror">
                            <option value="">— Pilih Layanan —</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $project->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="admin-label">Judul Proyek <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}"
                           class="admin-input @error('title') border-red-400 @enderror" required>
                </div>

                <div>
                    <label class="admin-label">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $project->slug) }}"
                           class="admin-input @error('slug') border-red-400 @enderror" required>
                </div>

                <div>
                    <label class="admin-label">Deskripsi</label>
                    <textarea name="description" rows="5"
                              class="admin-input @error('description') border-red-400 @enderror">{{ old('description', $project->description) }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Thumbnail</label>
                    @if(isset($project->id) && $project->thumbnail_url)
                        <div class="mb-2">
                            <img src="{{ str_starts_with($project->thumbnail_url, 'http') ? $project->thumbnail_url : Storage::url($project->thumbnail_url) }}"
                                 alt="Thumbnail saat ini" class="h-24 w-auto rounded object-cover">
                            <p class="text-xs text-gray-400 mt-1">Thumbnail saat ini. Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp"
                           class="admin-input @error('thumbnail') border-red-400 @enderror">
                    @error('thumbnail')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, atau WebP. Maksimal 2 MB. File disimpan permanen di Supabase Storage. Rasio 16:9 ideal.</p>
                    @if(! config('services.supabase.url') || ! config('services.supabase.service_role_key'))
                        <p class="mt-2 text-xs text-amber-700">Upload belum siap. Atur kredensial Supabase Storage di Environment Variables Vercel.</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="admin-label">URL Website Proyek</label>
                        <input type="url" name="project_url" value="{{ old('project_url', $project->project_url) }}"
                               class="admin-input @error('project_url') border-red-400 @enderror"
                               placeholder="https://website-klien.com">
                    </div>
                    <div>
                        <label class="admin-label">Tech Stack</label>
                        <input type="text" name="tech_stack" value="{{ old('tech_stack', $project->tech_stack) }}"
                               class="admin-input @error('tech_stack') border-red-400 @enderror"
                               placeholder="Laravel, Tailwind, MySQL">
                    </div>
                    <div>
                        <label class="admin-label">Tanggal Selesai</label>
                        <input type="date" name="completed_at" value="{{ old('completed_at', $project->completed_at?->format('Y-m-d')) }}"
                               class="admin-input @error('completed_at') border-red-400 @enderror">
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1"
                               {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 text-accent rounded border-gray-300 focus:ring-accent">
                        <label for="is_featured" class="text-sm text-gray-700">Tampilkan sebagai Featured</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" id="is_published" name="is_published" value="1"
                               {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-accent rounded border-gray-300 focus:ring-accent">
                        <label for="is_published" class="text-sm text-gray-700">Publikasikan</label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary text-sm py-2 px-5">
                    {{ isset($project->id) ? 'Simpan Perubahan' : 'Tambah Proyek' }}
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn-secondary text-sm py-2 px-5">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
