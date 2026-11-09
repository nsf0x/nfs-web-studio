<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function show(string $slug): View|HttpResponse
    {
        $layanan = Service::where('slug', $slug)
            ->whereRaw('is_active is true')
            ->with(['packages' => fn ($q) => $q->active()->with('features')])
            ->firstOrFail();

        return view('layanan.show', compact('layanan'));
    }
}
