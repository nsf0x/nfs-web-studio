<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class PortofolioController extends Controller
{
    public function index(): View
    {
        $projects = Project::published()
            ->with(['client', 'service'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('portofolio.index', compact('projects'));
    }

    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->with(['client', 'service'])
            ->firstOrFail();

        return view('portofolio.show', compact('project'));
    }
}
