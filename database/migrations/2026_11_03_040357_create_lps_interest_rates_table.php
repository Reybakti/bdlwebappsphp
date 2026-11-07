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
    Schema::create('lps_interest_rates', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->decimal('rate_idr', 5, 2);
        $table->decimal('rate_valas', 5, 2)->default(0.00);
        $table->date('effective_start_date');
        $table->date('effective_end_date');
        $table->boolean('is_current')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lps_interest_rates');
    }
};
