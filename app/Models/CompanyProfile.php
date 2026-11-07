<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'history',
        'vision',
        'mission',
        'phone',
        'email',
        'head_office_address',
        'ojk_lps_statement',
    ];
}