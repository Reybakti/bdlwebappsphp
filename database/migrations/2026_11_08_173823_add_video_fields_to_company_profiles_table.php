<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('video_title', 150)->nullable()->after('ojk_lps_statement');$table->enum('video_source_type', ['URL', 'UPLOAD'])->default('URL')->after('video_title');
            $table->string('video_url', 255)->nullable()->after('video_source_type');$table->string('video_file_path', 255)->nullable()->after('video_url');
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {$table->dropColumn(['video_title', 'video_source_type', 'video_url', 'video_file_path']);
        });
    }
};