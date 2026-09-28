<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;   // Correct Carbon import

class Installation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ward_id',
        'image',
        'installed_on',
        'comments',
        'latitude',
        'longitude',
        'uploaded_ip',
        'gps_image'
      
    ];

    /**
     * Virtual attribute: Installation expires exactly 6 months after installation date.
     */
    public function getExpiryDateAttribute()
    {
        if (!$this->installed_on) {
            return null;
        }

        return Carbon::parse($this->installed_on)
            ->addMonths(6)
            ->format('d M Y');
    }

    /**
     * Relation: Installation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Installation belongs to a ward.
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
