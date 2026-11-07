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
    Schema::create('wbs_reports', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('tracking_code', 64)->unique();
        $table->string('reporter_name', 150)->nullable();
        $table->string('reporter_contact', 150)->nullable();
        $table->string('incident_type', 100);
        $table->string('reported_person', 150);
        $table->date('incident_date');
        $table->string('incident_location', 150);
        $table->text('description');
        $table->string('evidence_file_url', 255)->nullable();
        $table->enum('status', ['RECEIVED', 'INVESTIGATING', 'CLOSED'])->default('RECEIVED');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wbs_reports');
    }
};
