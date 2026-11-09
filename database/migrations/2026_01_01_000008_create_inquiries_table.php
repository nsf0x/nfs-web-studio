<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->string('company', 150)->nullable();
            $table->integer('service_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->string('budget_range', 50)->nullable();
            $table->text('message');
            $table->enum('status', ['new', 'contacted', 'negotiation', 'won', 'lost'])->default('new');
            $table->dateTime('created_at')->useCurrent();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
