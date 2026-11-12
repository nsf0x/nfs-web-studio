<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\SupabaseStorage;
use App\Support\DatabaseBoolean;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use PDOException;
use Throwable;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::orderBy('sort_order')->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.form', ['client' => new Client]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateClient($request);
        $storage = app(SupabaseStorage::class);
        $stage = 'logo_upload';
        $uploadedLogoUrl = null;

        try {
            $data = $this->handleLogoUpload($request, $data, $storage);
            $uploadedLogoUrl = $request->hasFile('logo') ? ($data['logo_url'] ?? null) : null;

            $stage = 'database_insert';
            Client::create($data);
        } catch (Throwable $exception) {
            $this->deleteFailedUpload($uploadedLogoUrl, $storage, 'client_creation');
            Log::error('Admin client creation failed.', $this->failureContext($stage, $exception));

            throw $exception;
        }

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.form', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $this->validateClient($request, $client);
        $oldLogoUrl = $client->logo_url;
        $storage = app(SupabaseStorage::class);
        $stage = 'logo_upload';
        $uploadedLogoUrl = null;

        try {
            $data = $this->handleLogoUpload($request, $data, $storage);
            $uploadedLogoUrl = $request->hasFile('logo') ? ($data['logo_url'] ?? null) : null;

            $stage = 'database_update';
            $client->update($data);
        } catch (Throwable $exception) {
            $this->deleteFailedUpload($uploadedLogoUrl, $storage, 'client_update');
            Log::error('Admin client update failed.', $this->failureContext($stage, $exception, $client->getKey()));

            throw $exception;
        }

        $this->deleteReplacedLogo($oldLogoUrl, $client->logo_url, $storage, $client->getKey());

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->deleteLogo($client->logo_url, app(SupabaseStorage::class));
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil dihapus.');
    }

    private function validateClient(Request $request, ?Client $client = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('slug', ''))]);
        $slugRule = 'unique:clients,slug'.($client ? ",{$client->id}" : '');
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', $slugRule],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo_url' => ['nullable', 'url', 'max:2048'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'industry' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $data['is_active'] = DatabaseBoolean::fromRequest($request, 'is_active');

        return $data;
    }

    private function handleLogoUpload(Request $request, array $data, SupabaseStorage $storage): array
    {
        if ($request->hasFile('logo')) {
            $data['logo_url'] = $storage->upload($request->file('logo'), 'clients');
        } elseif (! $request->filled('logo_url')) {
            unset($data['logo_url']);
        }

        unset($data['logo']);

        return $data;
    }

    private function deleteReplacedLogo(
        ?string $oldUrl,
        ?string $newUrl,
        SupabaseStorage $storage,
        int|string $clientId
    ): void {
        if (! $oldUrl || $oldUrl === $newUrl) {
            return;
        }

        try {
            $this->deleteLogo($oldUrl, $storage);
        } catch (Throwable $exception) {
            Log::warning('Old client logo cleanup failed after saving the client.', [
                'client_id' => $clientId,
                ...$this->failureContext('old_logo_cleanup', $exception),
            ]);
        }
    }

    private function deleteFailedUpload(?string $url, SupabaseStorage $storage, string $operation): void
    {
        if (! $url) {
            return;
        }

        try {
            $this->deleteLogo($url, $storage);
        } catch (Throwable $exception) {
            Log::warning('New client logo cleanup failed after a database error.', [
                'operation' => $operation,
                ...$this->failureContext('failed_upload_cleanup', $exception),
            ]);
        }
    }

    private function failureContext(string $stage, Throwable $exception, int|string|null $clientId = null): array
    {
        $context = [
            'stage' => $stage,
            'exception' => $exception::class,
        ];

        if ($clientId !== null) {
            $context['client_id'] = $clientId;
        }

        if ($exception instanceof RequestException) {
            $context['upstream_status'] = $exception->response->status();
        }

        if ($exception instanceof PDOException) {
            $context['sql_state'] = $exception->errorInfo[0] ?? null;
        }

        if ($stage === 'logo_upload') {
            $context['supabase_config'] = [
                'url_present' => (string) config('services.supabase.url') !== '',
                'bucket_present' => (string) config('services.supabase.storage_bucket') !== '',
                'service_role_key_present' => (string) config('services.supabase.service_role_key') !== '',
            ];
        }

        return $context;
    }

    private function deleteLogo(?string $url, SupabaseStorage $storage): void
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
