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
        'image_path',
        'image_status',
        'image_error',
        'source',
        'raw_payload',
    ];


    protected $casts = [
        // Always use `json` cast for DB → array conversion
        'raw_payload' => 'json',

        // Your migration uses decimal(10,7)
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',

        // Ensure datetime formatting is handled properly
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
