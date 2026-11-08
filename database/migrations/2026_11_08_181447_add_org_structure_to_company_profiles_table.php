<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('org_chart_image', 255)->nullable()->after('video_file_path');
            $table->string('org_structure_decree', 150)->nullable()->after('org_chart_image'); // Contoh: SK Direksi No. 012/SK/DIR/BDL/2026
            $table->date('org_structure_effective_date')->nullable()->after('org_structure_decree');
            $table->text('org_structure_notes')->nullable()->after('org_structure_effective_date');
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'org_chart_image',
                'org_structure_decree',
                'org_structure_effective_date',
                'org_structure_notes',
            ]);
        });
    }
};