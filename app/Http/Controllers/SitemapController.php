<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $services = Service::active()->get();
        $projects = Project::published()->get();

        $xml = view('sitemap', compact('services', 'projects'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $appUrl = config('app.url');
        $isLocal = ! app()->environment('production')
            || str_contains($appUrl, 'localhost')
            || str_contains($appUrl, '127.0.0.1');

        $content = $isLocal
            ? "User-agent: *\nDisallow: /\n"
            : "User-agent: *\nAllow: /\nSitemap: " . rtrim($appUrl, '/') . "/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
