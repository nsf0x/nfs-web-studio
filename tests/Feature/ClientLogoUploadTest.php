<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientLogoUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.supabase.url' => 'https://project-ref.supabase.co',
            'services.supabase.service_role_key' => 'test-service-role-key',
            'services.supabase.storage_bucket' => 'client-logos',
        ]);
    }

    public function test_admin_uploads_logo_to_supabase_storage(): void
    {
        Http::fake([
            '*supabase.co/storage/v1/object/client-logos*' => Http::response(['Key' => 'ok'], 200),
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->post(route('admin.clients.store'), [
                'name' => 'Kaizen Kreasi Indonesia',
                'slug' => 'kaizen-kreasi-indonesia',
                'website_url' => 'https://kaizenkreasi.com',
                'logo' => UploadedFile::fake()->image('kaizen-logo.png'),
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.clients.index'));

        $client = Client::where('slug', 'kaizen-kreasi-indonesia')->firstOrFail();

        $this->assertStringStartsWith(
            'https://project-ref.supabase.co/storage/v1/object/public/client-logos/clients/',
            $client->logo_url
        );

        Http::assertSent(fn (ClientRequest $request): bool => $request->method() === 'POST'
            && str_contains($request->url(), '/storage/v1/object/client-logos/clients/'));
    }

    public function test_replacing_logo_removes_the_previous_supabase_object(): void
    {
        Http::fake([
            '*supabase.co/storage/v1/object/client-logos*' => Http::response(['Key' => 'ok'], 200),
        ]);

        $client = Client::create([
            'name' => 'Kaizen Kreasi Indonesia',
            'slug' => 'kaizen-kreasi-indonesia',
            'logo_url' => 'https://project-ref.supabase.co/storage/v1/object/public/client-logos/clients/old.png',
            'website_url' => 'https://kaizenkreasi.com',
            'is_active' => true,
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->post(route('admin.clients.update', $client), [
                '_method' => 'PUT',
                'name' => $client->name,
                'slug' => $client->slug,
                'website_url' => $client->website_url,
                'logo' => UploadedFile::fake()->image('kaizen-logo-new.png'),
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.clients.index'));

        Http::assertSent(fn (ClientRequest $request): bool => $request->method() === 'DELETE'
            && str_contains($request->url(), '/storage/v1/object/client-logos')
            && $request['prefixes'] === ['clients/old.png']);
    }

    private function admin(): Admin
    {
        return Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.test',
            'password_hash' => Hash::make('test-password'),
        ]);
    }
}
