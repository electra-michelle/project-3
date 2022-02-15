<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanLimit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'min_amount' => 'float',
        'max_amount' => 'float',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id', 'min_amount', 'max_amount', 'currency'
    ];

    /**
     * Get the plan that owns the period.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
