<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\SupabaseStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
        $data = $this->handleLogoUpload($request, $data, app(SupabaseStorage::class));
        Client::create($data);

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
        $data = $this->handleLogoUpload($request, $data, app(SupabaseStorage::class));
        $client->update($data);
        $this->deleteReplacedLogo($oldLogoUrl, $client->logo_url, app(SupabaseStorage::class));

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
        $data['is_active'] = $request->boolean('is_active');

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

    private function deleteReplacedLogo(?string $oldUrl, ?string $newUrl, SupabaseStorage $storage): void
    {
        if ($oldUrl && $oldUrl !== $newUrl) {
            $this->deleteLogo($oldUrl, $storage);
        }
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
