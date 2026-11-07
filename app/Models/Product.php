<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'full_description',
        'terms_and_conditions',
        'riplay_file_url',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function simulationParam(): HasOne
    {
        return $this->hasOne(ProductSimulationParam::class, 'product_id');
    }
}