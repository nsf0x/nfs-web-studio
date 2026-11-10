<?php

namespace Tests\Feature;

use App\Models\Package;
use Database\Seeders\PaketDanFaqSeeder;
use Database\Seeders\PricingPackageSeeder;
use Database\Seeders\ServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingPackageSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ServiceSeeder::class);
        $this->seed(PaketDanFaqSeeder::class);
    }

    public function test_it_seeds_all_categories_idempotently_and_preserves_manual_prices(): void
    {
        $this->seed(PricingPackageSeeder::class);
        $this->seed(PricingPackageSeeder::class);

        $this->assertDatabaseCount('packages', 13);
        $this->assertSame(3, Package::whereHas('service', fn ($query) => $query->where('slug', 'website-company-profile'))->count());
        $this->assertSame(3, Package::whereHas('service', fn ($query) => $query->where('slug', 'website-toko-online'))->count());
        $this->assertSame(3, Package::whereHas('service', fn ($query) => $query->where('slug', 'sistem-informasi-custom'))->count());
        $this->assertSame(4, Package::whereHas('service', fn ($query) => $query->where('slug', 'redesign-maintenance'))->count());
        $this->assertSame(1500000, Package::where('slug', 'company-profile-basic')->firstOrFail()->price);
        $this->assertSame(3500000, Package::where('slug', 'toko-online-basic')->firstOrFail()->price);
        $this->assertSame(7500000, Package::where('slug', 'si-starter')->firstOrFail()->price);
        $this->assertNull(Package::where('slug', 'si-enterprise')->firstOrFail()->price);

        $legacyPackage = Package::where('slug', 'company-profile-business')->firstOrFail();
        $legacyPackage->price = 2750000;
        $legacyPackage->save();

        $newPackage = Package::where('slug', 'si-starter')->firstOrFail();
        $newPackage->price = 4800000;
        $newPackage->save();

        $this->seed(PricingPackageSeeder::class);

        $this->assertSame(2750000, $legacyPackage->fresh()->price);
        $this->assertSame(4800000, $newPackage->fresh()->price);
        $this->assertSame(8, $newPackage->fresh()->features()->count());
    }

    public function test_custom_and_recurring_package_prices_display_correctly(): void
    {
        $this->seed(PricingPackageSeeder::class);

        $this->get('/layanan/redesign-maintenance')
            ->assertOk()
            ->assertSee('Lihat Detail Paket')
            ->assertSee('per bulan')
            ->assertSee('per tahun');

        $this->get('/layanan/sistem-informasi-custom')
            ->assertOk()
            ->assertSee('Harga sesuai ruang lingkup');
    }

    public function test_package_selection_opens_a_detail_summary_before_contact(): void
    {
        $this->seed(PricingPackageSeeder::class);

        $this->get('/layanan/website-company-profile')
            ->assertOk()
            ->assertSee('Lihat Detail Paket')
            ->assertSee('show-package-details')
            ->assertSee('x-on:show-package-details.window')
            ->assertSee('Lanjut ke Kontak')
            ->assertSee('Website profil usaha sederhana');

        $package = Package::where('slug', 'company-profile-basic')->firstOrFail();

        $this->get('/kontak?layanan=' . $package->service_id . '&paket=' . $package->id)
            ->assertOk()
            ->assertSee('Paket yang Diminati')
            ->assertSee('Lanjutkan konsultasi via WhatsApp')
            ->assertSee($package->name);
    }

    public function test_it_matches_existing_packages_by_category_and_name_without_creating_duplicates(): void
    {
        $package = Package::where('slug', 'company-profile-basic')->firstOrFail();
        $package->slug = 'legacy-company-profile-basic';
        $package->save();

        $this->seed(PricingPackageSeeder::class);

        $this->assertDatabaseCount('packages', 13);
        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'slug' => 'legacy-company-profile-basic',
        ]);
    }
}
