<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_guard_logs_in_updates_last_login_and_logs_out(): void
    {
        $password = Str::random(32);
        $admin = Admin::create([
            'name' => 'Test Administrator',
            'email' => 'admin@example.test',
            'password_hash' => Hash::make($password),
        ]);

        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => $password,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin, 'admin');
        $this->assertNotNull($admin->fresh()->last_login_at);

        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    public function test_admin_lists_use_the_styled_delete_confirmation_modal(): void
    {
        $admin = Admin::create([
            'name' => 'Test Administrator',
            'email' => 'admin@example.test',
            'password_hash' => Hash::make(Str::random(32)),
        ]);

        $this->actingAs($admin, 'admin');

        foreach ([
            '/admin/clients',
            '/admin/faqs',
            '/admin/packages',
            '/admin/projects',
            '/admin/services',
            '/admin/testimonials',
        ] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('Hapus data ini?')
                ->assertSee('Ya, Hapus')
                ->assertSee('confirm-delete');
        }
    }
}
