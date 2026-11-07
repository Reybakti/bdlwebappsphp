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
    Schema::create('product_simulation_params', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
        $table->decimal('min_amount', 15, 2);
        $table->decimal('max_amount', 15, 2);
        $table->integer('min_tenor_months');
        $table->integer('max_tenor_months');
        $table->decimal('base_interest_rate_pa', 5, 2);
        $table->enum('interest_type', ['FLAT', 'ANNUITY', 'EFFECTIVE']);
        $table->decimal('provision_fee_percent', 5, 2)->default(0.00);
        $table->decimal('admin_fee_amount', 15, 2)->default(0.00);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_simulation_params');
    }
};
