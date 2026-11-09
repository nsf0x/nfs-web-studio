<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSettingSeeder::class,  // 1. Pengaturan brand & kontak
            ClientSeeder::class,       // 2. Klien
            ServiceSeeder::class,      // 3. Layanan
            PaketDanFaqSeeder::class,  // 4. Paket + fitur + FAQ (butuh services sudah ada)
            AdminSeeder::class,        // 5. Akun admin
        ]);
    }
}
