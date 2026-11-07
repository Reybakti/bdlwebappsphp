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
    Schema::create('articles', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignId('category_id')->constrained('article_categories')->cascadeOnDelete();
        $table->foreignUuid('author_id')->constrained('users')->cascadeOnDelete();
        $table->string('title', 255);
        $table->string('slug', 255)->unique();
        $table->string('thumbnail_url', 255)->nullable();
        $table->longText('content');
        $table->enum('status', ['DRAFT', 'PUBLISHED', 'ARCHIVED'])->default('DRAFT');
        $table->timestamp('published_at')->nullable();
        $table->integer('views_count')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
