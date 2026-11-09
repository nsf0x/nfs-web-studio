<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email    = env('ADMIN_SEED_EMAIL', 'admin@nfsweb.com');
        $password = env('ADMIN_SEED_PASSWORD');
        $name     = env('ADMIN_SEED_NAME', 'Administrator');

        if (! is_string($password) || $password === '') {
            throw new RuntimeException('Set ADMIN_SEED_PASSWORD in the environment before seeding the admin account.');
        }

        DB::table('admins')->updateOrInsert(
            ['email' => $email],
            [
                'name'          => $name,
                'email'         => $email,
                'password_hash' => Hash::make($password),
                'created_at'    => now(),
            ]
        );
    }
}
