<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'latitude',
        'longitude',
        'validity',          // NEW
        'items_provided',    // NEW (JSON)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'latitude'          => 'decimal:7',
        'longitude'         => 'decimal:7',
        'items_provided'    => 'array',  
        'validity'          => 'integer', 
    ];

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function Constituency(): BelongsTo
    {
        return $this->belongsTo(Constituency::class);
    }
    // app/Models/User.php

public function corporation(): BelongsTo
{
    return $this->belongsTo(Corporation::class);
}

public function zone(): BelongsTo
{
    return $this->belongsTo(Zone::class);
}

    public function installation()
    {
        return $this->hasOne(Installation::class);
    }
}
