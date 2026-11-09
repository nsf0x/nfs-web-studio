<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('client_id')->nullable();
            $table->string('person_name', 100);
            $table->string('person_position', 100)->nullable();
            $table->text('content');
            $table->tinyInteger('rating')->default(5);
            $table->boolean('is_published')->default(false);
            $table->dateTime('created_at')->useCurrent();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
