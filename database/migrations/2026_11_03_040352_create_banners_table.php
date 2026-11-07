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
    Schema::create('banners', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('title', 200);
        $table->string('subtitle', 255)->nullable();
        $table->string('image_desktop_url', 255);
        $table->string('image_mobile_url', 255);
        $table->string('button_text', 50)->nullable();
        $table->string('button_url', 255)->nullable();
        $table->integer('order_index')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
