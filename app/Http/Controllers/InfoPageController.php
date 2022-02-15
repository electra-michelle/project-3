<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Plan;
use Illuminate\Http\Request;

class InfoPageController extends Controller
{
    public function investments()
    {
        $plans = Plan::with(['limits' => function ($query) {
            $query->select('min_amount', 'max_amount', 'decimals', 'plan_limits.currency', 'plan_id')
                ->join('payment_systems', function ($join) {
                    $join->on('payment_systems.currency', '=', 'plan_limits.currency');
                });
        }])
        ->withMax('periods', 'period_end')
        ->withAvg('periods', 'interest')
        ->get();

        $paymentSystems = PaymentSystem::active()->get();

        return view('investments', compact('plans', 'paymentSystems'));
    }
}
