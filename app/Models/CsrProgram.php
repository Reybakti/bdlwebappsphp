<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CsrProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'budget_amount',
        'location',
        'activity_date',
        'image_url',       // Sampul utama
        'document_url',    // Dokumen laporan / pertanggungjawaban
        'document_name',   // Nama asli berkas dokumen
        'description',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'budget_amount' => 'decimal:2',
            'activity_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Galeri Multi Foto Kegiatan CSR
     */
    public function galleryImages(): HasMany
    {
        return $this->hasMany(CsrProgramImage::class, 'csr_program_id');
    }
}