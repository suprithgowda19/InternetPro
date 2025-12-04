<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'installed_on',
        'comments',
        'ward_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
