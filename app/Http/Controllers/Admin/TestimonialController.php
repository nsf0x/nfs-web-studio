<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Testimonial;
use App\Support\DatabaseBoolean;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::with('client')->orderByDesc('created_at')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        $clients = Client::active()->get();
        return view('admin.testimonials.form', ['testimonial' => new Testimonial(), 'clients' => $clients]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateTestimonial($request);
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial): View
    {
        $clients = Client::active()->get();
        return view('admin.testimonials.form', compact('testimonial', 'clients'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $this->validateTestimonial($request);
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }

    private function validateTestimonial(Request $request): array
    {
        $data = $request->validate([
            'client_id'       => ['nullable', 'exists:clients,id'],
            'person_name'     => ['required', 'string', 'max:100'],
            'person_position' => ['nullable', 'string', 'max:100'],
            'content'         => ['required', 'string'],
            'rating'          => ['required', 'integer', 'min:1', 'max:5'],
            'is_published'    => ['boolean'],
        ]);
        $data['is_published'] = DatabaseBoolean::fromRequest($request, 'is_published');
        return $data;
    }
}
