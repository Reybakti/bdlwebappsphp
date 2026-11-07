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
    Schema::create('customer_complaints', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('handled_by')->nullable()->constrained('users')->nullOnDelete();
        $table->string('ticket_code', 50)->unique();
        $table->string('full_name', 150);
        $table->string('nik', 16);
        $table->string('phone', 50);
        $table->string('email', 150);
        $table->string('account_number', 50)->nullable();
        $table->string('category', 100);
        $table->text('description');
        $table->string('attachment_url', 255)->nullable();
        $table->enum('status', ['PENDING', 'IN_REVIEW', 'RESOLVED', 'REJECTED'])->default('PENDING');
        $table->text('resolution_notes')->nullable();
        $table->timestamp('resolved_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_complaints');
    }
};
