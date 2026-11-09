@extends('layouts.admin')
@section('page_title', 'Manajemen FAQ')
@section('title', 'FAQ')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Total: {{ $faqs->total() }} pertanyaan</p>
    <a href="{{ route('admin.faqs.create') }}" class="btn-primary text-sm py-2 px-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah FAQ
    </a>
</div>

<div class="bg-white rounded-xl shadow-card overflow-hidden">
    @if($faqs->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada FAQ. <a href="{{ route('admin.faqs.create') }}" class="text-accent">Tambah sekarang →</a></div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-5 py-3">Pertanyaan</th>
                    <th class="text-left px-5 py-3">Urutan</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($faqs as $faq)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="font-medium text-navy-900">{{ Str::limit($faq->question, 80) }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($faq->answer, 100) }}</div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $faq->sort_order }}</td>
                    <td class="px-5 py-3.5">
                        <span class="badge {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-accent hover:text-accent-hover text-xs font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}"
                                  onsubmit="return confirm('Hapus FAQ ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $faqs->links() }}
    </div>
    @endif
</div>
@endsection
