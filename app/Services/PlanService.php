<?php

namespace App\Services;

use App\Models\Plan;

class PlanService
{

    public function getPlanData()
    {
        return Plan::with(['limits' => function ($query) {
            $query->select('min_amount', 'max_amount', 'decimals', 'plan_limits.currency', 'plan_id')
                ->join('payment_systems', function ($join) {
                    $join->on('payment_systems.currency', '=', 'plan_limits.currency');
                });
        }])
            ->withMax('periods', 'period_end')
            ->withAvg('periods', 'interest')
            ->get();

    }

}
