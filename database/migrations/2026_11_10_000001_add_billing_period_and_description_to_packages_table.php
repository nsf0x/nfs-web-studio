<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table): void {
            $table->string('billing_period', 20)->default('one_time');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('packages')->whereNull('price')->update(['price' => 0]);

        Schema::table('packages', function (Blueprint $table): void {
            $table->decimal('price', 12, 2)->nullable(false)->change();
            $table->dropColumn(['billing_period', 'description']);
        });
    }
};
