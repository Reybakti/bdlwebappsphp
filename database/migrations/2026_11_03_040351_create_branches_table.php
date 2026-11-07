<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('branches', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('name', 150);
        $table->enum('type', ['HEAD_OFFICE', 'BRANCH', 'CASH_OFFICE']);
        $table->text('address');
        $table->string('phone', 50)->nullable();
        $table->string('whatsapp', 50)->nullable();
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->string('google_maps_url', 255)->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
