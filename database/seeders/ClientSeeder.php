<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Kaizen Kreasi Indonesia',  'slug' => 'kaizen-kreasi-indonesia',  'sort_order' => 1],
            ['name' => 'Kaizen Mitra Indonesia',    'slug' => 'kaizen-mitra-indonesia',   'sort_order' => 2],
            ['name' => 'PT Berlian Bangun Cipta',   'slug' => 'pt-berlian-bangun-cipta',  'sort_order' => 3],
            ['name' => 'PT Cendikia Trust Integrity','slug' => 'pt-cendikia-trust-integrity','sort_order' => 4],
        ];

        foreach ($clients as $client) {
            DB::table('clients')->updateOrInsert(
                ['slug' => $client['slug']],
                array_merge($client, ['is_active' => true])
            );
        }
    }
}
