<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

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
        $data = $this->handleLogoUpload($request, $data);
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
        $data = $this->handleLogoUpload($request, $data, $client);
        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->logo_url && ! $this->isExternalUrl($client->logo_url)) {
            Storage::disk('public')->delete($client->logo_url);
        }
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
            'logo_url' => ['nullable', 'url', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'industry' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function handleLogoUpload(Request $request, array $data, ?Client $client = null): array
    {
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('clients', 'public');
            if ($logoPath === false) {
                throw new RuntimeException('Unable to store the uploaded client logo.');
            }
            if ($client?->logo_url && ! $this->isExternalUrl($client->logo_url)) {
                Storage::disk('public')->delete($client->logo_url);
            }
            $data['logo_url'] = $logoPath;
        } elseif (
            $client?->logo_url
            && array_key_exists('logo_url', $data)
            && $client->logo_url !== $data['logo_url']
            && ! $this->isExternalUrl($client->logo_url)
        ) {
            Storage::disk('public')->delete($client->logo_url);
        }

        unset($data['logo']);

        return $data;
    }

    private function isExternalUrl(string $url): bool
    {
        return str_starts_with($url, 'https://') || str_starts_with($url, 'http://');
    }
}
