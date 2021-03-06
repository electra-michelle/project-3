<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSystem extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'decimals',
        'currency',
        'is_active',
        'payouts_enabled',
        'withdraw_minimum',
        'last_large_cron',
        'last_visited_block',
        'process_type'
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_large_cron'
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

    public function accounts()
    {
        return $this->hasMany(UserAccount::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }
}
