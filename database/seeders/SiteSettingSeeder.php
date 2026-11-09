<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['setting_key' => 'brand_name',  'setting_value' => 'NFS Web Studio'],
            ['setting_key' => 'tagline',     'setting_value' => 'Website Profesional untuk Bisnis Anda'],
            ['setting_key' => 'phone',       'setting_value' => '0882-1274-3260'],
            ['setting_key' => 'whatsapp',    'setting_value' => '6288212743260'],
            ['setting_key' => 'email',       'setting_value' => 'naufalshaflyfawwaz@gmail.com'],
            ['setting_key' => 'wa_message',  'setting_value' => 'Halo%20NFS%20Web%20Studio,%20saya%20tertarik%20membuat%20website'],
            ['setting_key' => 'address',     'setting_value' => ''],
            ['setting_key' => 'instagram',   'setting_value' => ''],
            ['setting_key' => 'facebook',    'setting_value' => ''],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['setting_key' => $setting['setting_key']],
                ['setting_value' => $setting['setting_value']]
            );
        }
    }
}
