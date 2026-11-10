<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PricingPackageSeeder extends Seeder
{
    private array $prices = [
        'company-profile-basic' => null, // TODO: isi harga
        'company-profile-business' => null, // TODO: isi harga
        'company-profile-premium' => null, // TODO: isi harga
        'toko-online-basic' => null, // TODO: isi harga
        'toko-online-business' => null, // TODO: isi harga
        'toko-online-premium' => null, // TODO: isi harga
        'si-starter' => null, // TODO: isi harga
        'si-business' => null, // TODO: isi harga
        'si-enterprise' => null, // TODO: isi harga
        'rd-basic' => null, // TODO: isi harga
        'rd-pro' => null, // TODO: isi harga
        'mt-monthly' => null, // TODO: isi harga
        'mt-yearly' => null, // TODO: isi harga
    ];

    public function run(): void
    {
        foreach ($this->packages() as $serviceSlug => $packages) {
            $service = Service::query()->where('slug', $serviceSlug)->first();

            if (! $service) {
                throw new RuntimeException("Service [{$serviceSlug}] must exist before seeding pricing packages.");
            }

            foreach ($packages as $package) {
                $this->upsertPackage($service, $package);
            }
        }
    }

    private function packages(): array
    {
        return [
            'website-company-profile' => [
                [
                    'name' => 'Basic',
                    'slug' => 'company-profile-basic',
                    'description' => null,
                    'billing_period' => 'one_time',
                    'delivery_days' => 7,
                    'revision_count' => 2,
                    'is_featured' => false,
                    'sort_order' => 1,
                    'features' => [
                        'Hingga 5 halaman (Beranda, Tentang, Layanan, Galeri, Kontak)',
                        'Desain responsif (HP, tablet, desktop)',
                        'Form kontak + tombol WhatsApp',
                        'SEO dasar (meta title dan description)',
                        'Integrasi Google Maps',
                    ],
                ],
                [
                    'name' => 'Business',
                    'slug' => 'company-profile-business',
                    'description' => null,
                    'billing_period' => 'one_time',
                    'delivery_days' => 14,
                    'revision_count' => 3,
                    'is_featured' => true,
                    'sort_order' => 2,
                    'features' => [
                        'Hingga 10 halaman',
                        'Desain responsif sesuai brand',
                        'Panel admin untuk mengubah konten',
                        'Form kontak dengan notifikasi email',
                        'SEO on-page lengkap dan sitemap',
                        'Halaman portofolio dan blog/berita',
                    ],
                ],
                [
                    'name' => 'Premium',
                    'slug' => 'company-profile-premium',
                    'description' => null,
                    'billing_period' => 'one_time',
                    'delivery_days' => 21,
                    'revision_count' => 5,
                    'is_featured' => false,
                    'sort_order' => 3,
                    'features' => [
                        'Halaman sesuai kebutuhan',
                        'Desain eksklusif sesuai identitas perusahaan',
                        'Panel admin lengkap',
                        'Multi-bahasa (jika diperlukan)',
                        'Optimasi kecepatan dan keamanan lanjutan',
                        'Pelatihan penggunaan admin',
                        'Prioritas dukungan setelah launching',
                    ],
                ],
            ],
            'website-toko-online' => [
                [
                    'name' => 'Basic',
                    'slug' => 'toko-online-basic',
                    'description' => null,
                    'billing_period' => 'one_time',
                    'delivery_days' => 14,
                    'revision_count' => 2,
                    'is_featured' => false,
                    'sort_order' => 1,
                    'features' => [
                        'Katalog produk (jumlah sesuai kesepakatan)',
                        'Keranjang dan checkout via WhatsApp',
                        'Desain responsif',
                        'Panel admin untuk kelola produk',
                    ],
                ],
                [
                    'name' => 'Business',
                    'slug' => 'toko-online-business',
                    'description' => null,
                    'billing_period' => 'one_time',
                    'delivery_days' => 21,
                    'revision_count' => 3,
                    'is_featured' => true,
                    'sort_order' => 2,
                    'features' => [
                        'Katalog produk lebih banyak dan kategori',
                        'Checkout dengan pilihan pembayaran online',
                        'Hitung ongkos kirim otomatis',
                        'Manajemen pesanan dan stok',
                        'SEO produk',
                    ],
                ],
                [
                    'name' => 'Premium',
                    'slug' => 'toko-online-premium',
                    'description' => null,
                    'billing_period' => 'one_time',
                    'delivery_days' => 30,
                    'revision_count' => 5,
                    'is_featured' => false,
                    'sort_order' => 3,
                    'features' => [
                        'Fitur sesuai kebutuhan bisnis',
                        'Voucher/diskon dan laporan penjualan',
                        'Integrasi marketplace atau sistem lain (sesuai kelayakan)',
                        'Optimasi kecepatan dan keamanan lanjutan',
                        'Pelatihan penggunaan admin',
                        'Prioritas dukungan setelah launching',
                    ],
                ],
            ],
            'sistem-informasi-custom' => [
                [
                    'name' => 'Starter',
                    'slug' => 'si-starter',
                    'description' => 'Sistem informasi untuk memulai digitalisasi proses bisnis inti.',
                    'billing_period' => 'one_time',
                    'delivery_days' => 21,
                    'revision_count' => 2,
                    'is_featured' => false,
                    'sort_order' => 1,
                    'features' => [
                        'Analisis kebutuhan dan alur kerja',
                        'Hingga 3 modul inti',
                        'Manajemen user dan role dasar',
                        'Dashboard ringkasan operasional',
                        'Export laporan dasar',
                        'Konfigurasi hosting dan deployment',
                        'Training penggunaan admin',
                        'Garansi bug 30 hari',
                    ],
                ],
                [
                    'name' => 'Business',
                    'slug' => 'si-business',
                    'description' => 'Sistem terintegrasi untuk mengelola proses dan laporan bisnis.',
                    'billing_period' => 'one_time',
                    'delivery_days' => 35,
                    'revision_count' => 3,
                    'is_featured' => true,
                    'sort_order' => 2,
                    'features' => [
                        'Analisis kebutuhan dan dokumentasi proses',
                        'Hingga 8 modul terintegrasi',
                        'Manajemen user, role, dan hak akses',
                        'Dashboard sesuai kebutuhan operasional',
                        'Export laporan Excel atau PDF',
                        'Integrasi API eksternal',
                        'Konfigurasi hosting dan deployment',
                        'Training untuk pengguna',
                        'Garansi bug 60 hari',
                    ],
                ],
                [
                    'name' => 'Enterprise',
                    'slug' => 'si-enterprise',
                    'description' => 'Solusi enterprise dengan ruang lingkup dan penawaran khusus.',
                    'billing_period' => 'custom',
                    'delivery_days' => null,
                    'revision_count' => null,
                    'is_featured' => false,
                    'sort_order' => 3,
                    'features' => [
                        'Analisis kebutuhan dan arsitektur sistem',
                        'Modul dan alur kerja sesuai ruang lingkup',
                        'Manajemen user, role, dan hak akses lanjutan',
                        'Dashboard dan laporan sesuai kebutuhan',
                        'Integrasi API dan sistem yang sudah digunakan',
                        'Konfigurasi hosting dan deployment',
                        'Training pengguna dan administrator',
                        'Garansi bug sesuai kesepakatan',
                    ],
                ],
            ],
            'redesign-maintenance' => [
                [
                    'name' => 'Redesign Basic',
                    'slug' => 'rd-basic',
                    'description' => 'Penyegaran tampilan untuk website bisnis dengan ruang lingkup terarah.',
                    'billing_period' => 'one_time',
                    'delivery_days' => 7,
                    'revision_count' => 2,
                    'is_featured' => false,
                    'sort_order' => 1,
                    'features' => [
                        'Redesign hingga 5 halaman',
                        'Pembaruan UI/UX sesuai identitas brand',
                        'Tampilan responsif untuk perangkat utama',
                        'Optimasi kecepatan dasar',
                        'SEO teknis dasar',
                        'Dukungan setelah redesign',
                    ],
                ],
                [
                    'name' => 'Redesign Pro',
                    'slug' => 'rd-pro',
                    'description' => 'Redesign menyeluruh untuk meningkatkan pengalaman dan performa website.',
                    'billing_period' => 'one_time',
                    'delivery_days' => 14,
                    'revision_count' => 3,
                    'is_featured' => true,
                    'sort_order' => 2,
                    'features' => [
                        'Redesign hingga 10 halaman',
                        'Pembaruan UI/UX dan konsistensi visual',
                        'Tampilan responsif lintas perangkat',
                        'Optimasi kecepatan dan performa',
                        'SEO teknis dasar dan pengalihan URL',
                        'Pembaruan form dan alur konversi',
                        'Dukungan setelah redesign',
                    ],
                ],
                [
                    'name' => 'Maintenance Bulanan',
                    'slug' => 'mt-monthly',
                    'description' => 'Perawatan rutin website dengan dukungan teknis bulanan.',
                    'billing_period' => 'monthly',
                    'delivery_days' => null,
                    'revision_count' => null,
                    'is_featured' => false,
                    'sort_order' => 3,
                    'features' => [
                        'Backup website berkala',
                        'Monitoring uptime',
                        'Update plugin dan framework',
                        'Pemeriksaan keamanan dan error',
                        'Optimasi performa dasar',
                        'Support teknis bulanan',
                    ],
                ],
                [
                    'name' => 'Maintenance Tahunan',
                    'slug' => 'mt-yearly',
                    'description' => 'Perawatan website selama satu tahun dengan dukungan berkelanjutan.',
                    'billing_period' => 'yearly',
                    'delivery_days' => null,
                    'revision_count' => null,
                    'is_featured' => false,
                    'sort_order' => 4,
                    'features' => [
                        'Backup website terjadwal',
                        'Monitoring uptime berkala',
                        'Update plugin dan framework',
                        'Pemeriksaan keamanan dan error',
                        'Optimasi performa berkala',
                        'Support teknis tahunan',
                    ],
                ],
            ],
        ];
    }

    private function upsertPackage(Service $service, array $data): void
    {
        DB::transaction(function () use ($service, $data): void {
            $features = $data['features'];
            unset($data['features']);

            $package = Package::query()
                ->where('slug', $data['slug'])
                ->orWhere(function ($query) use ($service, $data): void {
                    $query->where('service_id', $service->id)
                        ->whereRaw('LOWER(name) = ?', [mb_strtolower($data['name'])]);
                })
                ->first();

            if ($package && (int) $package->service_id !== (int) $service->id) {
                throw new RuntimeException("Package slug [{$data['slug']}] is assigned to another service.");
            }

            if ($package) {
                $price = $package->price;
                $package = Package::updateOrCreate(
                    ['slug' => $package->slug],
                    [
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'is_featured' => DB::raw($data['is_featured'] ? 'true' : 'false'),
                        'sort_order' => $data['sort_order'],
                    ]
                );

                if ($price === null && $this->prices[$data['slug']] !== null) {
                    $package->price = $this->prices[$data['slug']];
                    $package->save();
                }
            } else {
                $package = Package::updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'service_id' => $service->id,
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'billing_period' => $data['billing_period'],
                        'price' => $this->prices[$data['slug']],
                        'price_note' => null,
                        'delivery_days' => $data['delivery_days'],
                        'revision_count' => $data['revision_count'],
                        'is_featured' => DB::raw($data['is_featured'] ? 'true' : 'false'),
                        'is_active' => DB::raw('true'),
                        'sort_order' => $data['sort_order'],
                    ]
                );
            }

            $package->features()->delete();

            foreach ($features as $index => $feature) {
                PackageFeature::create([
                    'package_id' => $package->id,
                    'feature' => $feature,
                    'sort_order' => $index + 1,
                ]);
            }
        });
    }
}
