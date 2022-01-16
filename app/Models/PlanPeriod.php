<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPeriod extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id', 'interest', 'period_start', 'period_end'
    ];

    /**
     * Get the plan that owns the period.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
