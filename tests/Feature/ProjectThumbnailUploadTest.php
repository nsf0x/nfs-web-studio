<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProjectThumbnailUploadTest extends TestCase
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

    public function test_admin_uploads_project_thumbnail_to_supabase_storage(): void
    {
        Http::fake([
            '*supabase.co/storage/v1/object/client-logos*' => Http::response(['Key' => 'ok'], 200),
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->post(route('admin.projects.store'), [
                'client_id' => $this->client()->id,
                'title' => 'Website Proyek',
                'slug' => 'website-proyek',
                'thumbnail' => UploadedFile::fake()->image('thumbnail.png'),
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.projects.index'));

        $project = Project::where('slug', 'website-proyek')->firstOrFail();

        $this->assertStringStartsWith(
            'https://project-ref.supabase.co/storage/v1/object/public/client-logos/projects/',
            $project->thumbnail_url
        );

        Http::assertSent(fn (ClientRequest $request): bool => $request->method() === 'POST'
            && str_contains($request->url(), '/storage/v1/object/client-logos/projects/'));
    }

    public function test_replacing_project_thumbnail_removes_the_previous_supabase_object(): void
    {
        Http::fake([
            '*supabase.co/storage/v1/object/client-logos*' => Http::response(['Key' => 'ok'], 200),
        ]);

        $client = $this->client();
        $project = Project::create([
            'client_id' => $client->id,
            'title' => 'Website Proyek',
            'slug' => 'website-proyek',
            'thumbnail_url' => 'https://project-ref.supabase.co/storage/v1/object/public/client-logos/projects/old.png',
            'is_published' => true,
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->post(route('admin.projects.update', $project), [
                '_method' => 'PUT',
                'client_id' => $client->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'thumbnail' => UploadedFile::fake()->image('thumbnail-new.png'),
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.projects.index'));

        Http::assertSent(fn (ClientRequest $request): bool => $request->method() === 'DELETE'
            && str_contains($request->url(), '/storage/v1/object/client-logos')
            && $request['prefixes'] === ['projects/old.png']);
    }

    public function test_project_thumbnail_has_the_same_upload_limit_as_client_logos(): void
    {
        Http::fake();

        $this->actingAs($this->admin(), 'admin')
            ->from(route('admin.projects.create'))
            ->post(route('admin.projects.store'), [
                'client_id' => $this->client()->id,
                'title' => 'Website Proyek',
                'slug' => 'website-proyek',
                'thumbnail' => UploadedFile::fake()->image('thumbnail.png')->size(2049),
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.projects.create'))
            ->assertSessionHasErrors('thumbnail');

        Http::assertNothingSent();
    }

    public function test_project_form_compresses_large_images_before_uploading(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get(route('admin.projects.create'))
            ->assertOk()
            ->assertSee('File besar akan dikecilkan otomatis')
            ->assertSee('createImageBitmap')
            ->assertSee('400 * 1024')
            ->assertSee('Memuat pemroses gambar...')
            ->assertSee('input.disabled = false');
    }

    private function admin(): Admin
    {
        return Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.test',
            'password_hash' => Hash::make('test-password'),
        ]);
    }

    private function client(): Client
    {
        return Client::create([
            'name' => 'Example Client',
            'slug' => 'example-client',
            'is_active' => true,
        ]);
    }
}
