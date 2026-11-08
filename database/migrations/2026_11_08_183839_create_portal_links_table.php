<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_links', function (Blueprint $table) {$table->uuid('id')->primary();
            $table->string('title', 150);$table->string('slug', 180)->unique();
            $table->string('category', 60); // REGULATOR, PEMDA, LAYANAN_PUBLIK, DOKUMEN_PUBLIKASI, REKANAN$table->string('url', 255);
            $table->string('description', 255)->nullable();$table->string('badge_text', 50)->nullable(); // Misal: "Resmi", "24 Jam", "Mandatori"
            $table->string('icon_name', 50)->default('globe'); // globe, shield, building, file, phone
            $table->boolean('is_external')->default(true);$table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);$table->timestamps();

            $table->index(['category', 'is_active', 'order_index']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_links');
    }
};