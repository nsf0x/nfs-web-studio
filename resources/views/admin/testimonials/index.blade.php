@extends('layouts.admin')
@section('page_title', 'Manajemen Testimoni')
@section('title', 'Testimoni')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Total: {{ $testimonials->total() }} testimoni</p>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-primary text-sm py-2 px-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Testimoni
    </a>
</div>

<div class="bg-white rounded-xl shadow-card overflow-hidden">
    @if($testimonials->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada testimoni. <a href="{{ route('admin.testimonials.create') }}" class="text-accent">Tambah sekarang →</a></div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-5 py-3">Testimoni</th>
                    <th class="text-left px-5 py-3">Rating</th>
                    <th class="text-left px-5 py-3">Klien</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($testimonials as $testimonial)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="font-medium text-navy-900">{{ $testimonial->person_name }}</div>
                        <div class="text-xs text-gray-400">{{ $testimonial->person_position }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($testimonial->content, 80) }}</div>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-gold' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $testimonial->client->name ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="badge {{ $testimonial->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $testimonial->is_published ? 'Publik' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-accent hover:text-accent-hover text-xs font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                  onsubmit="return confirm('Hapus testimoni ini?')">
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
        {{ $testimonials->links() }}
    </div>
    @endif
</div>
@endsection
