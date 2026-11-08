<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {$table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();$table->string('user_name', 150)->nullable();
            $table->string('user_role', 50)->nullable();$table->string('module', 50); // AUTH, COMPLAINT, WBS, REPORT, PRODUCT, SYSTEM
            $table->string('action', 50); // LOGIN, LOGOUT, CREATE, UPDATE, DELETE, VIEW$table->text('description'); // Penjelasan ringkas aktivitas
            $table->json('changes')->nullable(); // Snapshot data lama vs data baru$table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();$table->timestamps();

            // Indexing untuk pencarian cepat audit trail
            $table->index(['module', 'action']);$table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};