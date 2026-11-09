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
                    'price'          => 0,
                    'price_note'     => 'Mulai dari',
                    'delivery_days'  => 7,
                    'revision_count' => 2,
                    'is_featured'    => false,
                    'is_active'      => true,
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
                    'price'          => 0,
                    'price_note'     => 'Mulai dari',
                    'delivery_days'  => 14,
                    'revision_count' => 3,
                    'is_featured'    => true,
                    'is_active'      => true,
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
                    'price'          => 0,
                    'price_note'     => 'Mulai dari',
                    'delivery_days'  => 21,
                    'revision_count' => 5,
                    'is_featured'    => false,
                    'is_active'      => true,
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
                    'price'          => 0,
                    'price_note'     => 'Mulai dari',
                    'delivery_days'  => 14,
                    'revision_count' => 2,
                    'is_featured'    => false,
                    'is_active'      => true,
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
                    'price'          => 0,
                    'price_note'     => 'Mulai dari',
                    'delivery_days'  => 21,
                    'revision_count' => 3,
                    'is_featured'    => true,
                    'is_active'      => true,
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
                    'price'          => 0,
                    'price_note'     => 'Mulai dari',
                    'delivery_days'  => 30,
                    'revision_count' => 5,
                    'is_featured'    => false,
                    'is_active'      => true,
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
                'is_active'  => true,
            ],
            [
                'question'   => 'Bagaimana sistem pembayarannya?',
                'answer'     => 'Setelah penawaran disetujui, pembayaran dilakukan bertahap: uang muka di awal dan pelunasan sebelum website diluncurkan. Rincian skemanya kami tuangkan dalam penawaran. [SESUAIKAN DENGAN SKEMA ANDA]',
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'question'   => 'Apakah saya bisa meminta revisi?',
                'answer'     => 'Bisa. Jumlah revisi mengikuti paket yang dipilih. Revisi mencakup perbaikan desain dan konten sesuai brief awal; permintaan fitur baru di luar kesepakatan dibahas sebagai tambahan.',
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'question'   => 'Apakah harga sudah termasuk domain dan hosting?',
                'answer'     => 'Kami dapat membantu pengadaan domain dan hosting. Biaya keduanya dijelaskan terpisah di penawaran supaya transparan. [SESUAIKAN]',
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'question'   => 'Apakah ada dukungan setelah website diluncurkan?',
                'answer'     => 'Ya. Kami menyediakan dukungan setelah launching untuk membantu kendala teknis awal. Perawatan rutin seperti pembaruan dan backup tersedia sebagai layanan terpisah. [SESUAIKAN MASA SUPPORT]',
                'sort_order' => 5,
                'is_active'  => true,
            ],
            [
                'question'   => 'Apakah saya bisa mengubah isi website sendiri?',
                'answer'     => 'Bisa untuk paket yang dilengkapi panel admin. Anda dapat mengubah teks, gambar, dan konten tanpa keahlian coding, dan kami siap membantu jika Anda butuh panduan.',
                'sort_order' => 6,
                'is_active'  => true,
            ],
        ];

        // Replace all faqs for idempotency
        DB::table('faqs')->truncate();
        DB::table('faqs')->insert($faqs);
    }
}
