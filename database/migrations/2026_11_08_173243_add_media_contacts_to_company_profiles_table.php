<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            // Media Sosial Resmi
            $table->string('facebook_url', 255)->nullable()->after('email');$table->string('instagram_url', 255)->nullable()->after('facebook_url');
            $table->string('youtube_url', 255)->nullable()->after('instagram_url');$table->string('linkedin_url', 255)->nullable()->after('youtube_url');
            $table->string('tiktok_url', 255)->nullable()->after('linkedin_url');$table->string('whatsapp_hotline', 50)->nullable()->after('tiktok_url');

            // Narahubung Pers / Media Relations (Humas)
            $table->string('media_contact_person', 150)->nullable()->after('whatsapp_hotline');
            $table->string('media_contact_phone', 50)->nullable()->after('media_contact_person');$table->string('media_contact_email', 100)->nullable()->after('media_contact_phone');
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {$table->dropColumn([
                'facebook_url',
                'instagram_url',
                'youtube_url',
                'linkedin_url',
                'tiktok_url',
                'whatsapp_hotline',
                'media_contact_person',
                'media_contact_phone',
                'media_contact_email',
            ]);
        });
    }
};