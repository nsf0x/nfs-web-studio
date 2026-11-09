@extends('layouts.admin')
@section('page_title', isset($faq->id) ? 'Edit FAQ' : 'Tambah FAQ')
@section('title', isset($faq->id) ? 'Edit FAQ' : 'Tambah FAQ')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-accent mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar FAQ
    </a>

    <div class="bg-white rounded-xl shadow-card p-6">
        <form method="POST"
              action="{{ isset($faq->id) ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
            @csrf
            @if(isset($faq->id)) @method('PUT') @endif

            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="space-y-5">
                <div>
                    <label class="admin-label">Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea name="question" rows="2"
                              class="admin-input @error('question') border-red-400 @enderror"
                              required>{{ old('question', $faq->question) }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Jawaban <span class="text-red-500">*</span></label>
                    <textarea name="answer" rows="5"
                              class="admin-input @error('answer') border-red-400 @enderror"
                              required>{{ old('answer', $faq->answer) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}"
                               class="admin-input" min="0">
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-accent rounded border-gray-300 focus:ring-accent">
                        <label for="is_active" class="text-sm text-gray-700">Aktif / Tampilkan</label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary text-sm py-2 px-5">
                    {{ isset($faq->id) ? 'Simpan Perubahan' : 'Tambah FAQ' }}
                </button>
                <a href="{{ route('admin.faqs.index') }}" class="btn-secondary text-sm py-2 px-5">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
