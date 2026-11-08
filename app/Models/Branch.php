<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory, HasUuids;

    /**
     * Tipe data primary key adalah string (UUID), bukan integer.
     */
    protected $keyType = 'string';

    /**
     * Nonaktifkan auto-incrementing karena menggunakan UUID.
     */
    public $incrementing = false;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'type',
        'address',
        'city',
        'postal_code',
        'phone',
        'whatsapp',
        'email',
        'latitude',
        'longitude',
        'google_maps_url',
        'maps_url',
        'operating_hours',
        'is_active',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }
}