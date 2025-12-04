<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'admin_resolution',
        'admin_remarks',
        'admin_image',
        'status',
    ];
    protected $casts = [
        'status' => 'string',
    ];

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper: full image URL for admin image
     */
    public function getAdminImageUrlAttribute(): ?string
    {
        if (!$this->admin_image) {
            return null;
        }

        return asset('storage/' . $this->admin_image);
    }
}
