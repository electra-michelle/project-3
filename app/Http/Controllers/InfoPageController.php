<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Plan;
use App\Models\PlanLimit;
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

    public function faq()
    {
        $paymentSystems = PaymentSystem::active()->get();
        $planLimits = PlanLimit::selectRaw('MIN(min_amount) AS min_amount, MAX(max_amount) AS max_amount, currency')->groupBy('currency')->get();

        $minDepositLimits = [];
        $maxDepositLimits = [];
        foreach($planLimits as $planLimit) {
            $minDepositLimits[] = $planLimit->min_amount . ' ' . $planLimit->currency;
            $maxDepositLimits[] = $planLimit->max_amount . ' ' . $planLimit->currency;
        }

        $withdrawMinimums = [];
        foreach($paymentSystems->pluck('withdraw_minimum', 'currency') as $currency => $minimum) {
            $withdrawMinimums[] = round($minimum, 8) . ' ' . $currency;
        }

        return view('faq', compact('paymentSystems', 'minDepositLimits', 'maxDepositLimits', 'withdrawMinimums'));
    }
}
