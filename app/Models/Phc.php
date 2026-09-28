<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phc extends Model
{
    protected $fillable = [
        'name',
        'ward_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

 
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }
}
