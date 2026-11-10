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

    public function test_packages_without_prices_display_contact_label_and_billing_period(): void
    {
        $this->seed(PricingPackageSeeder::class);

        $this->get('/layanan/redesign-maintenance')
            ->assertOk()
            ->assertSee('Hubungi Kami')
            ->assertSee('per bulan')
            ->assertSee('per tahun');
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
