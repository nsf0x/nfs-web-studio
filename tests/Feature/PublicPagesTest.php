<?php

namespace Tests\Feature;

use App\Mail\InquiryNotification;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Package;
use App\Models\Service;
use Database\Seeders\ClientSeeder;
use Database\Seeders\PaketDanFaqSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\SiteSettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            SiteSettingSeeder::class,
            ClientSeeder::class,
            ServiceSeeder::class,
            PaketDanFaqSeeder::class,
        ]);
    }

    public function test_public_pages_render_successfully(): void
    {
        foreach (['/', '/kontak', '/portofolio', '/kebijakan-privasi', '/syarat-ketentuan', '/robots.txt', '/sitemap.xml'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_home_page_has_no_inquiry_form_and_routes_contact_to_whatsapp(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('action="' . route('kontak.store') . '"', false)
            ->assertSee('Transaksi via WhatsApp');
    }

    public function test_client_logo_links_to_the_client_website(): void
    {
        $client = Client::where('slug', 'kaizen-kreasi-indonesia')->firstOrFail();
        $client->update([
            'logo_url' => 'https://cdn.example.test/kaizen-logo.png',
            'website_url' => 'https://kaizenkreasi.com',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('src="https://cdn.example.test/kaizen-logo.png"', false)
            ->assertSee('href="https://kaizenkreasi.com"', false)
            ->assertSee('aria-label="Kunjungi website Kaizen Kreasi Indonesia"', false);
    }

    public function test_contact_form_stores_an_inquiry_and_sends_a_notification(): void
    {
        Mail::fake();

        $this->from('/kontak')
            ->post('/kontak', $this->validInquiry())
            ->assertRedirect('/kontak')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Test Contact',
            'email' => 'contact@example.test',
            'status' => 'new',
        ]);

        Mail::assertSent(InquiryNotification::class);
    }

    public function test_honeypot_submission_is_not_saved(): void
    {
        $this->from('/kontak')
            ->post('/kontak', $this->validInquiry(['website_url' => 'https://spam.example']))
            ->assertRedirect('/kontak')
            ->assertSessionHas('success');

        $this->assertSame(0, Inquiry::count());
    }

    public function test_package_must_belong_to_the_selected_service(): void
    {
        $service = Service::where('slug', 'website-company-profile')->firstOrFail();
        $package = Package::where('slug', 'toko-online-basic')->firstOrFail();

        $this->from('/kontak')
            ->post('/kontak', $this->validInquiry([
                'service_id' => $service->id,
                'package_id' => $package->id,
            ]))
            ->assertRedirect('/kontak')
            ->assertSessionHasErrors('package_id');

        $this->assertSame(0, Inquiry::count());
    }

    private function validInquiry(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test Contact',
            'email' => 'contact@example.test',
            'message' => 'Saya ingin berkonsultasi tentang website.',
            'privacy_agree' => '1',
        ], $overrides);
    }
}
