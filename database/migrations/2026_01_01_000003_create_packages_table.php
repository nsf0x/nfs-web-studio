<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('service_id');
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->decimal('price', 12, 2);
            $table->string('price_note', 100)->nullable();
            $table->integer('delivery_days')->nullable();
            $table->integer('revision_count')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
