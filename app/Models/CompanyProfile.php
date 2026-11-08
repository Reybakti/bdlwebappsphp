<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'history',
        'vision',
        'mission',
        'phone',
        'email',
        'head_office_address',
        'ojk_lps_statement',

        // Video Profil
        'video_title',
        'video_source_type',
        'video_url',
        'video_file_path',

        // Media Sosial & Humas
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'linkedin_url',
        'tiktok_url',
        'whatsapp_hotline',
        'media_contact_person',
        'media_contact_phone',
        'media_contact_email',
    ];

    /**
     * Konversi URL YouTube biasa ke format Embed URL
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        $url =$this->video_url;

        // Cocokkan pola youtube.com/watch?v=ID atau youtu.be/ID
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url,$matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
        }

        return $url;
    }
}