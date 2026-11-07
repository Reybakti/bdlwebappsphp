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
    Schema::create('products', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
        $table->string('name', 200);
        $table->string('slug', 200)->unique();
        $table->text('short_description')->nullable();
        $table->text('full_description')->nullable();
        $table->text('terms_and_conditions')->nullable();
        $table->string('riplay_file_url', 255)->nullable();
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
