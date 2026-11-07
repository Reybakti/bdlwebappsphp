<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LpsInterestRate extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'rate_idr',
        'rate_valas',
        'effective_start_date',
        'effective_end_date',
        'is_current',
    ];

    protected $casts = [
        'rate_idr' => 'decimal:2',
        'rate_valas' => 'decimal:2',
        'effective_start_date' => 'date',
        'effective_end_date' => 'date',
        'is_current' => 'boolean',
    ];
}