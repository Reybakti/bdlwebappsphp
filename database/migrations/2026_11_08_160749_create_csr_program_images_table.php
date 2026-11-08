<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('csr_program_images', function (Blueprint $table) {$table->id();
            $table->foreignId('csr_program_id')->constrained('csr_programs')->cascadeOnDelete();$table->string('image_url');
            $table->string('caption', 150)->nullable();$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('csr_program_images');
    }
};