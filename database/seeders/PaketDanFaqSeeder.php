<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketDanFaqSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPackages();
        $this->seedFaqs();
    }

    private function seedPackages(): void
    {
        // --- LAYANAN: website-company-profile ---
        $cpId = DB::table('services')->where('slug', 'website-company-profile')->value('id');

        if ($cpId) {
            $packages = [
                [
                    'service_id'     => $cpId,
                    'name'           => 'Basic',
                    'slug'           => 'company-profile-basic',
                    'price_note'     => null,
                    'delivery_days'  => 7,
                    'revision_count' => 2,
                    'is_featured'    => DB::raw('false'),
                    'is_active'      => DB::raw('true'),
                    'sort_order'     => 1,
                    'features'       => [
                        'Hingga 5 halaman (Beranda, Tentang, Layanan, Galeri, Kontak)',
                        'Desain responsif (HP, tablet, desktop)',
                        'Form kontak + tombol WhatsApp',
                        'SEO dasar (meta title dan description)',
                        'Integrasi Google Maps',
                    ],
                ],
                [
                    'service_id'     => $cpId,
                    'name'           => 'Business',
                    'slug'           => 'company-profile-business',
                    'price_note'     => null,
                    'delivery_days'  => 14,
                    'revision_count' => 3,
                    'is_featured'    => DB::raw('true'),
                    'is_active'      => DB::raw('true'),
                    'sort_order'     => 2,
                    'features'       => [
                        'Hingga 10 halaman',
                        'Desain responsif sesuai brand',
                        'Panel admin untuk mengubah konten',
                        'Form kontak dengan notifikasi email',
                        'SEO on-page lengkap dan sitemap',
                        'Halaman portofolio dan blog/berita',
                    ],
                ],
                [
                    'service_id'     => $cpId,
                    'name'           => 'Premium',
                    'slug'           => 'company-profile-premium',
                    'price_note'     => null,
                    'delivery_days'  => 21,
                    'revision_count' => 5,
                    'is_featured'    => DB::raw('false'),
                    'is_active'      => DB::raw('true'),
                    'sort_order'     => 3,
                    'features'       => [
                        'Halaman sesuai kebutuhan',
                        'Desain eksklusif sesuai identitas perusahaan',
                        'Panel admin lengkap',
                        'Multi-bahasa (jika diperlukan)',
                        'Optimasi kecepatan dan keamanan lanjutan',
                        'Pelatihan penggunaan admin',
                        'Prioritas dukungan setelah launching',
                    ],
                ],
            ];

            $this->insertPackages($packages);
        }

        // --- LAYANAN: website-toko-online ---
        $toId = DB::table('services')->where('slug', 'website-toko-online')->value('id');

        if ($toId) {
            $packages = [
                [
                    'service_id'     => $toId,
                    'name'           => 'Basic',
                    'slug'           => 'toko-online-basic',
                    'price_note'     => null,
                    'delivery_days'  => 14,
                    'revision_count' => 2,
                    'is_featured'    => DB::raw('false'),
                    'is_active'      => DB::raw('true'),
                    'sort_order'     => 1,
                    'features'       => [
                        'Katalog produk (jumlah sesuai kesepakatan)',
                        'Keranjang dan checkout via WhatsApp',
                        'Desain responsif',
                        'Panel admin untuk kelola produk',
                    ],
                ],
                [
                    'service_id'     => $toId,
                    'name'           => 'Business',
                    'slug'           => 'toko-online-business',
                    'price_note'     => null,
                    'delivery_days'  => 21,
                    'revision_count' => 3,
                    'is_featured'    => DB::raw('true'),
                    'is_active'      => DB::raw('true'),
                    'sort_order'     => 2,
                    'features'       => [
                        'Katalog produk lebih banyak dan kategori',
                        'Checkout dengan pilihan pembayaran online',
                        'Hitung ongkos kirim otomatis',
                        'Manajemen pesanan dan stok',
                        'SEO produk',
                    ],
                ],
                [
                    'service_id'     => $toId,
                    'name'           => 'Premium',
                    'slug'           => 'toko-online-premium',
                    'price_note'     => null,
                    'delivery_days'  => 30,
                    'revision_count' => 5,
                    'is_featured'    => DB::raw('false'),
                    'is_active'      => DB::raw('true'),
                    'sort_order'     => 3,
                    'features'       => [
                        'Fitur sesuai kebutuhan bisnis',
                        'Voucher/diskon dan laporan penjualan',
                        'Integrasi marketplace atau sistem lain (sesuai kelayakan)',
                        'Optimasi kecepatan dan keamanan lanjutan',
                        'Pelatihan penggunaan admin',
                        'Prioritas dukungan setelah launching',
                    ],
                ],
            ];

            $this->insertPackages($packages);
        }
    }

    private function insertPackages(array $packages): void
    {
        foreach ($packages as $pkg) {
            $features = $pkg['features'];
            unset($pkg['features']);

            DB::table('packages')->updateOrInsert(
                ['slug' => $pkg['slug']],
                $pkg
            );

            $packageId = DB::table('packages')->where('slug', $pkg['slug'])->value('id');

            if ($packageId) {
                // Replace features for idempotency
                DB::table('package_features')->where('package_id', $packageId)->delete();
                foreach ($features as $i => $feature) {
                    DB::table('package_features')->insert([
                        'package_id' => $packageId,
                        'feature'    => $feature,
                        'sort_order' => $i + 1,
                    ]);
                }
            }
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            [
                'question'   => 'Berapa lama proses pembuatan website?',
                'answer'     => 'Tergantung paket dan kelengkapan bahan dari Anda (logo, teks, foto). Estimasi pengerjaan tercantum di masing-masing paket, dan waktu pastinya kami sepakati di awal sebelum pengerjaan dimulai.',
                'sort_order' => 1,
                'is_active'  => DB::raw('true'),
            ],
            [
                'question'   => 'Bagaimana sistem pembayarannya?',
                'answer'     => 'Konsultasi, kesepakatan ruang lingkup, dan instruksi pembayaran dilakukan melalui WhatsApp. Rincian biaya dan jadwal disepakati sebelum pengerjaan dimulai; website ini tidak memproses pembayaran otomatis.',
                'sort_order' => 2,
                'is_active'  => DB::raw('true'),
            ],
            [
                'question'   => 'Apakah saya bisa meminta revisi?',
                'answer'     => 'Bisa. Jumlah revisi mengikuti paket yang dipilih. Revisi mencakup perbaikan desain dan konten sesuai brief awal; permintaan fitur baru di luar kesepakatan dibahas sebagai tambahan.',
                'sort_order' => 3,
                'is_active'  => DB::raw('true'),
            ],
            [
                'question'   => 'Apakah harga sudah termasuk domain dan hosting?',
                'answer'     => 'Biaya paket hanya mencakup ruang lingkup yang tertulis. Domain, hosting, dan lisensi pihak ketiga dapat menjadi biaya tambahan; rinciannya akan disampaikan sebelum Anda menyetujui pekerjaan.',
                'sort_order' => 4,
                'is_active'  => DB::raw('true'),
            ],
            [
                'question'   => 'Apakah ada dukungan setelah website diluncurkan?',
                'answer'     => 'Dukungan dan garansi bug mengikuti rincian paket serta kesepakatan proyek. Perawatan rutin seperti pembaruan dan backup tersedia sebagai layanan maintenance terpisah.',
                'sort_order' => 5,
                'is_active'  => DB::raw('true'),
            ],
            [
                'question'   => 'Apakah saya bisa mengubah isi website sendiri?',
                'answer'     => 'Bisa untuk paket yang dilengkapi panel admin. Anda dapat mengubah teks, gambar, dan konten tanpa keahlian coding, dan kami siap membantu jika Anda butuh panduan.',
                'sort_order' => 6,
                'is_active'  => DB::raw('true'),
            ],
        ];

        // Replace all faqs for idempotency
        DB::table('faqs')->truncate();
        DB::table('faqs')->insert($faqs);
    }
}
