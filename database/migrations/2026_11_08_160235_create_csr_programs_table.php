<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('csr_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->enum('category', [
                'PEMBERDAYAAN_UMKM',
                'PENDIDIKAN_LITERASI',
                'SOSIAL_KEMASYARAKATAN',
                'LINGKUNGAN_HIDUP'
            ]);
            $table->decimal('budget_amount', 15, 2)->nullable();
            $table->string('location', 150);
            $table->date('activity_date');
            $table->string('image_url')->nullable();
            $table->longText('description');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_published']);
            $table->index('activity_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('csr_programs');
    }
};