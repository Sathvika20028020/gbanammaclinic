<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationRecharge extends Model
{
    use HasFactory;

    protected $table = 'installation_recharges';

    protected $fillable = [
        'installation_id',
        'recharge_date',
        'expiry_date',
        'plan_validity',
        'amount',
        'receipt_no',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'recharge_date' => 'date',
        'expiry_date'   => 'date',
        'amount'        => 'decimal:2',
    ];

    public function installation()
    {
        return $this->belongsTo(Installation::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
