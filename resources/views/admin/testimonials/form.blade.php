@extends('layouts.admin')
@section('page_title', isset($testimonial->id) ? 'Edit Testimoni' : 'Tambah Testimoni')
@section('title', isset($testimonial->id) ? 'Edit Testimoni' : 'Tambah Testimoni')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Testimoni
    </a>

    <div class="bg-white rounded-xl shadow-card p-6">
        <form method="POST"
              action="{{ isset($testimonial->id) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">
            @csrf
            @if(isset($testimonial->id)) @method('PUT') @endif

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
                        <label class="admin-label">Nama Orang <span class="text-red-500">*</span></label>
                        <input type="text" name="person_name" value="{{ old('person_name', $testimonial->person_name) }}"
                               class="admin-input @error('person_name') border-red-400 @enderror" required>
                    </div>
                    <div>
                        <label class="admin-label">Posisi / Jabatan</label>
                        <input type="text" name="person_position" value="{{ old('person_position', $testimonial->person_position) }}"
                               class="admin-input @error('person_position') border-red-400 @enderror"
                               placeholder="mis: CEO, Pemilik Usaha">
                    </div>
                </div>

                <div>
                    <label class="admin-label">Klien (opsional)</label>
                    <select name="client_id" class="admin-input @error('client_id') border-red-400 @enderror">
                        <option value="">— Pilih Klien —</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $testimonial->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="admin-label">Isi Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="5"
                              class="admin-input @error('content') border-red-400 @enderror"
                              required placeholder="Kutipan testimoni asli dari klien...">{{ old('content', $testimonial->content) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Rating (1–5) <span class="text-red-500">*</span></label>
                        <select name="rating" class="admin-input @error('rating') border-red-400 @enderror" required>
                            @for($r = 5; $r >= 1; $r--)
                                <option value="{{ $r }}" {{ old('rating', $testimonial->rating ?? 5) == $r ? 'selected' : '' }}>
                                    {{ $r }} Bintang
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" id="is_published" name="is_published" value="1"
                               {{ old('is_published', $testimonial->is_published ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-accent rounded border-gray-300 focus:ring-accent">
                        <label for="is_published" class="text-sm text-gray-700">Publikasikan</label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary text-sm py-2 px-5">
                    {{ isset($testimonial->id) ? 'Simpan Perubahan' : 'Tambah Testimoni' }}
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary text-sm py-2 px-5">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
