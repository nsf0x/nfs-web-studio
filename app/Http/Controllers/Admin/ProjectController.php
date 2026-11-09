<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with(['client', 'service'])->orderByDesc('id')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        $clients  = Client::active()->get();
        $services = Service::active()->get();
        return view('admin.projects.form', [
            'project'  => new Project(),
            'clients'  => $clients,
            'services' => $services,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProject($request);
        $data = $this->handleThumbnail($request, $data);
        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        $clients  = Client::active()->get();
        $services = Service::active()->get();
        return view('admin.projects.form', compact('project', 'clients', 'services'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateProject($request, $project);
        $data = $this->handleThumbnail($request, $data, $project);
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->thumbnail_url && !str_starts_with($project->thumbnail_url, 'http')) {
            Storage::disk('public')->delete($project->thumbnail_url);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    private function validateProject(Request $request, ?Project $project = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('slug', ''))]);
        $slugRule = 'unique:projects,slug' . ($project ? ",{$project->id}" : '');
        $data = $request->validate([
            'client_id'     => ['required', 'exists:clients,id'],
            'service_id'    => ['nullable', 'exists:services,id'],
            'title'         => ['required', 'string', 'max:200'],
            'slug'          => ['required', 'string', 'max:200', $slugRule],
            'description'   => ['nullable', 'string'],
            'thumbnail'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'project_url'   => ['nullable', 'url', 'max:255'],
            'tech_stack'    => ['nullable', 'string', 'max:255'],
            'completed_at'  => ['nullable', 'date'],
            'is_featured'   => ['boolean'],
            'is_published'  => ['boolean'],
        ]);
        $data['is_featured']  = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        return $data;
    }

    private function handleThumbnail(Request $request, array $data, ?Project $project = null): array
    {
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('projects', 'public');
            if ($thumbnailPath === false) {
                throw new RuntimeException('Unable to store the uploaded project thumbnail.');
            }
            if ($project?->thumbnail_url && !str_starts_with($project->thumbnail_url, 'http')) {
                Storage::disk('public')->delete($project->thumbnail_url);
            }
            $data['thumbnail_url'] = $thumbnailPath;
        }
        unset($data['thumbnail']);
        return $data;
    }
}
