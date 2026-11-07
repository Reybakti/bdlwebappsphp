<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSimulationParam extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'min_amount',
        'max_amount',
        'min_tenor_months',
        'max_tenor_months',
        'base_interest_rate_pa',
        'interest_type',
        'provision_fee_percent',
        'admin_fee_amount',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'base_interest_rate_pa' => 'decimal:2',
        'provision_fee_percent' => 'decimal:2',
        'admin_fee_amount' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}