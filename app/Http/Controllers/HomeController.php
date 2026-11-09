<?php

namespace App\Http\Controllers;

use App\Mail\InquiryNotification;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Http\Requests\InquiryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::active()
            ->with(['packages' => fn ($q) => $q->active()->with('features')])
            ->get();

        $clients = Client::active()->get();

        $projects = Project::published()
            ->with(['client', 'service'])
            ->orderBy('is_featured', 'desc')
            ->get()
            ->groupBy('client_id');

        $testimonials = Testimonial::published()
            ->with('client')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $faqs = Faq::active()->get();

        // Only services that have active packages for the tab UI
        $servicesWithPackages = $services->filter(
            fn ($s) => $s->packages->isNotEmpty()
        );

        return view('home', compact(
            'services',
            'clients',
            'projects',
            'testimonials',
            'faqs',
            'servicesWithPackages'
        ));
    }
}
