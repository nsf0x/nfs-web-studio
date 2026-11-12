<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Services\SupabaseStorage;
use App\Support\DatabaseBoolean;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with(['client', 'service'])->orderByDesc('id')->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        $clients = Client::active()->get();
        $services = Service::active()->get();

        return view('admin.projects.form', [
            'project' => new Project,
            'clients' => $clients,
            'services' => $services,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProject($request);

        $stage = 'thumbnail_upload';

        try {
            Log::debug('Admin project upload reached storage stage.', [
                'has_thumbnail' => $request->hasFile('thumbnail'),
            ]);
            $data = $this->handleThumbnail($request, $data, app(SupabaseStorage::class));

            $stage = 'database_insert';
            Log::debug('Admin project upload reached database stage.');
            Project::create($data);
        } catch (Throwable $exception) {
            Log::error('Admin project creation failed.', [
                'stage' => $stage,
                'exception' => $exception::class,
            ]);

            throw $exception;
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        $clients = Client::active()->get();
        $services = Service::active()->get();

        return view('admin.projects.form', compact('project', 'clients', 'services'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateProject($request, $project);
        $oldThumbnailUrl = $project->thumbnail_url;
        $storage = app(SupabaseStorage::class);
        $stage = 'thumbnail_upload';

        try {
            Log::debug('Admin project update reached storage stage.', [
                'project_id' => $project->getKey(),
                'has_thumbnail' => $request->hasFile('thumbnail'),
            ]);
            $data = $this->handleThumbnail($request, $data, $storage);

            $stage = 'database_update';
            $project->update($data);

            $stage = 'old_thumbnail_cleanup';
            $this->deleteReplacedThumbnail($oldThumbnailUrl, $project->thumbnail_url, $storage);
        } catch (Throwable $exception) {
            Log::error('Admin project update failed.', [
                'project_id' => $project->getKey(),
                'stage' => $stage,
                'exception' => $exception::class,
            ]);

            throw $exception;
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteThumbnail($project->thumbnail_url, app(SupabaseStorage::class));
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    private function validateProject(Request $request, ?Project $project = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('slug', ''))]);
        $slugRule = 'unique:projects,slug'.($project ? ",{$project->id}" : '');
        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:200', $slugRule],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'tech_stack' => ['nullable', 'string', 'max:255'],
            'completed_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
        ]);
        $data['is_featured'] = DatabaseBoolean::fromRequest($request, 'is_featured');
        $data['is_published'] = DatabaseBoolean::fromRequest($request, 'is_published');

        return $data;
    }

    private function handleThumbnail(Request $request, array $data, SupabaseStorage $storage): array
    {
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_url'] = $storage->upload($request->file('thumbnail'), 'projects');
        }
        unset($data['thumbnail']);

        return $data;
    }

    private function deleteReplacedThumbnail(
        ?string $oldThumbnailUrl,
        ?string $newThumbnailUrl,
        SupabaseStorage $storage
    ): void {
        if ($oldThumbnailUrl && $oldThumbnailUrl !== $newThumbnailUrl) {
            $this->deleteThumbnail($oldThumbnailUrl, $storage);
        }
    }

    private function deleteThumbnail(?string $url, SupabaseStorage $storage): void
    {
        if (! $url) {
            return;
        }

        if ($storage->manages($url)) {
            $storage->delete($url);

            return;
        }

        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            Storage::disk('public')->delete($url);
        }
    }
}
