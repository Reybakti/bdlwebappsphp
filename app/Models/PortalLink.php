<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalLink extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'url',
        'description',
        'badge_text',
        'icon_name',
        'is_external',
        'is_active',
        'order_index',
    ];

    protected function casts(): array
    {
        return [
            'is_external' => 'boolean',
            'is_active' => 'boolean',
            'order_index' => 'integer',
        ];
    }
}