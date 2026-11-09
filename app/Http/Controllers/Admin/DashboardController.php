<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'inquiries_new'   => Inquiry::where('status', 'new')->count(),
            'inquiries_total' => Inquiry::count(),
            'services'        => Service::count(),
        ];

        $recentInquiries = Inquiry::with(['service', 'package'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries'));
    }
}
