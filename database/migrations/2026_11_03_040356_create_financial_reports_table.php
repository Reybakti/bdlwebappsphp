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
    Schema::create('financial_reports', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('created_by')->constrained('users')->cascadeOnDelete();
        $table->string('title', 255);
        $table->integer('year');
        $table->enum('type', ['TRIWULAN_1', 'TRIWULAN_2', 'TRIWULAN_3', 'TRIWULAN_4', 'AUDITED_ANNUAL', 'GCG']);
        $table->string('file_url', 255);
        $table->date('published_at');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
