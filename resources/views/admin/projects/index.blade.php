@extends('layouts.admin')
@section('page_title', 'Manajemen Proyek')
@section('title', 'Proyek')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Total: {{ $projects->total() }} proyek</p>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary text-sm py-2 px-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Proyek
    </a>
</div>

<div class="bg-white rounded-xl shadow-card overflow-hidden">
    @if($projects->isEmpty())
    <div class="p-10 text-center text-gray-400">Belum ada proyek. <a href="{{ route('admin.projects.create') }}" class="text-accent">Tambah sekarang →</a></div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-5 py-3">Proyek</th>
                    <th class="text-left px-5 py-3">Klien</th>
                    <th class="text-left px-5 py-3">Layanan</th>
                    <th class="text-left px-5 py-3">Selesai</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($projects as $project)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            @if($project->thumbnail_url)
                                <img src="{{ str_starts_with($project->thumbnail_url, 'http') ? $project->thumbnail_url : Storage::url($project->thumbnail_url) }}"
                                     alt="" class="w-12 h-8 object-cover rounded">
                            @else
                                <div class="w-12 h-8 bg-gradient-to-br from-navy-700 to-accent rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ strtoupper(substr($project->title, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-navy-900">{{ Str::limit($project->title, 50) }}</div>
                                @if($project->is_featured)
                                    <span class="badge bg-gold/10 text-gold text-xs">Featured</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $project->client->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $project->service->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $project->completed_at?->format('d/m/Y') ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="badge {{ $project->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $project->is_published ? 'Publik' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('portofolio.show', $project->slug) }}" target="_blank" class="text-gray-400 hover:text-gray-600 text-xs">Lihat</a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="text-accent hover:text-accent-hover text-xs font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}">
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
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
