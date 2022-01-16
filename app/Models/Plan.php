<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'value', 'period_type', 'principal_return', 'affiliate_commission'
    ];

    /**
     * Get the periods for the plan.
     */
    public function periods()
    {
        return $this->hasMany(PlanPeriod::class);
    }
    /**
     * Get the limits for the plan.
     */
    public function limits()
    {
        return $this->hasMany(PlanLimit::class);
    }


    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
}
