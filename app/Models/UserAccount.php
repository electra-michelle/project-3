<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet', 'balance', 'payment_system_id', 'user_id'
    ];

    protected $casts = [
        'balance' => 'float',
    ];


    /**
     * Get the user that owns the user account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the paymentSystem that owns the user account.
     */
    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class);
    }
}
