<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $services = Service::with(['packages' => fn ($q) => $q->orderBy('sort_order')])->orderBy('sort_order')->get();
        return view('admin.packages.index', compact('services'));
    }

    public function create(): View
    {
        $services = Service::active()->get();
        return view('admin.packages.form', ['package' => new Package(), 'services' => $services]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePackage($request);
        $features = $this->extractFeatures($request);
        unset($data['features']);

        DB::transaction(function () use ($data, $features): void {
            $package = Package::create($data);
            $this->syncFeatures($package, $features);
        });

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package): View
    {
        $services = Service::active()->get();
        $package->load('features');
        return view('admin.packages.form', compact('package', 'services'));
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $data = $this->validatePackage($request, $package);
        $features = $this->extractFeatures($request);
        unset($data['features']);

        DB::transaction(function () use ($package, $data, $features): void {
            $package->update($data);
            $this->syncFeatures($package, $features);
        });

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus.');
    }

    private function validatePackage(Request $request, ?Package $package = null): array
    {
        $request->merge(['slug' => Str::slug((string) $request->input('slug', ''))]);
        $slugRule = 'unique:packages,slug' . ($package ? ",{$package->id}" : '');
        $data = $request->validate([
            'service_id'     => ['required', 'exists:services,id'],
            'name'           => ['required', 'string', 'max:100'],
            'slug'           => ['required', 'string', 'max:120', $slugRule],
            'price'          => ['required', 'numeric', 'min:0'],
            'price_note'     => ['nullable', 'string', 'max:100'],
            'delivery_days'  => ['nullable', 'integer', 'min:1'],
            'revision_count' => ['nullable', 'integer', 'min:0'],
            'is_featured'    => ['boolean'],
            'is_active'      => ['boolean'],
            'sort_order'     => ['nullable', 'integer'],
            'features'       => ['nullable', 'array'],
            'features.*'     => ['nullable', 'string', 'max:255'],
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');
        return $data;
    }

    private function extractFeatures(Request $request): array
    {
        $features = $request->input('features', []) ?? [];
        return array_values(array_filter(array_map('trim', $features), fn ($feature) => $feature !== ''));
    }

    private function syncFeatures(Package $package, array $features): void
    {
        $package->features()->delete();
        foreach ($features as $i => $feature) {
            PackageFeature::create([
                'package_id' => $package->id,
                'feature'    => $feature,
                'sort_order' => $i + 1,
            ]);
        }
    }
}
