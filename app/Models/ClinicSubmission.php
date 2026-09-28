<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSubmission extends Model
{
    protected $table = 'clinic_submissions';

    protected $fillable = [
        'phc',
        'clinic_name',
        'doctor_name',
        'phone',
        'lat',
        'lng',
        'image',
        'source',
        'raw_payload',
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'raw_payload' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
