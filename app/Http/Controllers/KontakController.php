<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Mail\InquiryNotification;
use App\Models\Inquiry;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class KontakController extends Controller
{
    public function index(): View
    {
        $services = Service::active()
            ->with(['packages' => fn ($q) => $q->active(), 'packages.features'])
            ->get();

        return view('kontak', compact('services'));
    }

    public function store(InquiryRequest $request): RedirectResponse
    {
        if ($request->filled('website_url')) {
            return back()->with('success', 'Pesan Anda berhasil dikirim!');
        }

        // Rate limiting: max 3 submissions per 10 minutes per IP
        $key = 'inquiry:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withInput()->withErrors([
                'message' => "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }
        RateLimiter::hit($key, 600);

        $inquiry = Inquiry::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'company'      => $request->company,
            'service_id'   => $request->service_id,
            'package_id'   => $request->package_id,
            'budget_range' => $request->budget_range,
            'message'      => $request->message,
            'status'       => 'new',
        ]);

        try {
            Mail::to(config('mail.notification_to'))->send(new InquiryNotification($inquiry));
        } catch (\Throwable $e) {
            // Log the error but don't fail the user
            logger()->error('Failed to send inquiry email: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
