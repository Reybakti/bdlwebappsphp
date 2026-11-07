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
    Schema::create('company_profiles', function (Blueprint $table) {
        $table->id();
        $table->string('name', 200)->default('PT BPR Bank Daerah Lamongan (Perseroda)');
        $table->text('history');
        $table->text('vision');
        $table->text('mission');
        $table->string('phone', 50);
        $table->string('email', 100);
        $table->text('head_office_address');
        $table->text('ojk_lps_statement');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
