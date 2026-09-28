<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'contact_person_name',
        'title',
        'phone',
        'description',
        'admin_resolution',
        'admin_remarks',
        'admin_image',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Public URL helper for image
    public function getAdminImageUrlAttribute(): ?string
    {
        return $this->admin_image ? asset('storage/' . $this->admin_image) : null;
    }
}
