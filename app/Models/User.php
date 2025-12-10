<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'ward_id',
        'clinic_name',
        'internet_status',
        'internet_speed',
        'bandwidth',
        'latitude',   // Newly added
        'longitude',  // Newly added
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'latitude'          => 'decimal:7',   // Optional cast, precision for safety
        'longitude'         => 'decimal:7',  // Optional cast
    ];

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    public function installation()
    {
        return $this->hasOne(Installation::class);
    }
}
