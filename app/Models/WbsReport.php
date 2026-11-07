<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WbsReport extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tracking_code',
        'reporter_name',
        'reporter_contact',
        'incident_type',
        'reported_person',
        'incident_date',
        'incident_location',
        'description',
        'evidence_file_url',
        'status',
    ];

    protected $casts = [
        'incident_date' => 'date',
    ];
}