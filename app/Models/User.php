<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'ref_url',
        'upline',
        'country'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function referredBy()
    {
        return $this->belongsTo(User::class, 'upline');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'upline');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

    public function wallets()
    {
        return $this->hasMany(UserAccount::class);
    }

    public function histories()
    {
        return $this->hasMany(UserHistory::class);
    }

    public function depositSum()
    {
        return $this->deposits()
            ->join('payment_systems', 'payment_systems.id', '=', 'deposits.payment_system_id')
            ->where('status', 'active')->orWhere('status', 'finished')
            ->selectRaw('user_id, payment_systems.currency as currency, payment_systems.decimals as decimals, payment_system_id, sum(`amount`) as total_deposit')
            ->groupBy('payment_systems.currency');
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
//    public function sendPasswordResetNotification($token)
//    {
//        $this->notify(new ResetPasswordNotification($token));
//    }
}
