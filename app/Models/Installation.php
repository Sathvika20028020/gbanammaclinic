<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Installation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ward_id',
        'image',
        'installed_on',
        'comments',
        'routes',
        'cables',
        'latitude',
        'longitude',
        'uploaded_ip',
        'gps_image',
        // Internet Data & Recharge Tracking
        'provider',
        'internet_id',
        'internet_password',
        'last_recharge_date',
        'recharge_expiry_date',
        'plan_validity',
        'status',
    ];

    protected $casts = [
        'installed_on'        => 'date',
        'last_recharge_date'  => 'date',
        'recharge_expiry_date'=> 'date',
    ];

    /**
     * Virtual attribute: Installation expires exactly 6 months after installation date.
     */
    public function getExpiryDateAttribute()
    {
        if ($this->recharge_expiry_date) {
            return $this->recharge_expiry_date->format('d M Y');
        }

        if (!$this->installed_on) {
            return null;
        }

        return Carbon::parse($this->installed_on)
            ->addMonths(6)
            ->format('d M Y');
    }

    /**
     * Calculated real-time status of the internet connection.
     */
    public function getComputedStatusAttribute()
    {
        $expiry = $this->recharge_expiry_date;
        if (!$expiry && $this->installed_on) {
            $expiry = Carbon::parse($this->installed_on)->addMonths(6);
        }

        if (!$expiry) {
            return $this->status ?? 'active';
        }

        $today = Carbon::today();
        if ($today->gt($expiry)) {
            return 'expired';
        } elseif ($today->diffInDays($expiry, false) <= 7) {
            return 'expiring_soon';
        }

        return $this->status ?? 'active';
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

    /**
     * Relation: Installation has many recharges.
     */
    public function recharges()
    {
        return $this->hasMany(InstallationRecharge::class)->latest('recharge_date');
    }
}
