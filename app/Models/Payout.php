<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'payment_system_id',
        'transaction_id',
        'amount',
        'status',
        'paid_at',
        'comment'
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'paid_at'
    ];

    /**
     * Get the user that owns the deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment System that owns the deposit.
     */
    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class);
    }
}
