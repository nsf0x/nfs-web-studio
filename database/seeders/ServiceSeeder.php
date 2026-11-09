<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'              => 'Website Company Profile',
                'slug'              => 'website-company-profile',
                'short_description' => 'Website profesional untuk membangun kredibilitas bisnis Anda.',
                'sort_order'        => 1,
                'icon'              => '🏢',
                'is_active'         => DB::raw('true'),
            ],
            [
                'name'              => 'Website Toko Online',
                'slug'              => 'website-toko-online',
                'short_description' => 'Toko online lengkap dengan katalog dan checkout.',
                'sort_order'        => 2,
                'icon'              => '🛍️',
                'is_active'         => DB::raw('true'),
            ],
            [
                'name'              => 'Sistem Informasi Custom',
                'slug'              => 'sistem-informasi-custom',
                'short_description' => 'Aplikasi web sesuai kebutuhan proses bisnis Anda.',
                'sort_order'        => 3,
                'icon'              => '💻',
                'is_active'         => DB::raw('true'),
            ],
            [
                'name'              => 'Redesign & Maintenance',
                'slug'              => 'redesign-maintenance',
                'short_description' => 'Perbarui tampilan dan rawat website yang sudah ada.',
                'sort_order'        => 4,
                'icon'              => '🛠️',
                'is_active'         => DB::raw('true'),
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->updateOrInsert(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
