<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'subtitle',
        'image_desktop_url',
        'image_mobile_url',
        'button_text',
        'button_url',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'order_index' => 'integer',
        'is_active' => 'boolean',
    ];
}