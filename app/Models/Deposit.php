<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'user_id',
        'payment_system_id',
        'amount',
        'period_passed',
        'status',
        'deposit_address',
        'payment_type',
        'transaction_id',
        'confirmed_at',
        'last_credited_at',
        'comment',
        'url'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_credited_at',
        'confirmed_at'
    ];

    /**
     * Get the user that owns the deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan that owns the deposit.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    /**
     * Get the payment System that owns the deposit.
     */
    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class);
    }

    public function planPeriod()
    {
        return $this->hasMany(PlanPeriod::class, 'plan_id', 'plan_id');
    }
}
