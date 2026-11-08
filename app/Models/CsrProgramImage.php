<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CsrProgramImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'csr_program_id',
        'image_url',
        'caption',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(CsrProgram::class, 'csr_program_id');
    }
}