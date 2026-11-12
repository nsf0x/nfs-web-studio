<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\DatabaseBoolean;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validate($request);
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validate($request, $service);
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    private function validate(Request $request, ?Service $service = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('slug', ''))]);
        $slugRule = 'unique:services,slug' . ($service ? ",{$service->id}" : '');
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:150'],
            'slug'              => ['required', 'string', 'max:150', $slugRule],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'icon'              => ['nullable', 'string', 'max:100'],
            'sort_order'        => ['nullable', 'integer'],
            'is_active'         => ['boolean'],
        ]);

        $data['is_active'] = DatabaseBoolean::fromRequest($request, 'is_active');

        return $data;
    }
}
