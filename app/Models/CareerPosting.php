<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerPosting extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'deadline',
        'is_active',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];
}