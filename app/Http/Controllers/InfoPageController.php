<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\PlanLimit;
use App\Services\PlanService;

class InfoPageController extends Controller
{
    public function investments(PlanService $planService)
    {
        $plans = $planService->getPlanData();

        $paymentSystems = PaymentSystem::active()->get();

        return view('investments', compact('plans', 'paymentSystems'));
    }

    public function faq()
    {
        $paymentSystems = PaymentSystem::active()->get();
        $planLimits = PlanLimit::selectRaw('MIN(min_amount) AS min_amount, MAX(max_amount) AS max_amount, currency')->groupBy('currency')->get();

        $minDepositLimits = [];
        $maxDepositLimits = [];
        foreach ($planLimits as $planLimit) {
            $minDepositLimits[] = $planLimit->min_amount . ' ' . $planLimit->currency;
            $maxDepositLimits[] = $planLimit->max_amount . ' ' . $planLimit->currency;
        }

        $withdrawMinimums = [];
        foreach ($paymentSystems->pluck('withdraw_minimum', 'currency') as $currency => $minimum) {
            $decimals = $paymentSystems->where('currency', $currency)->first();
            $withdrawMinimums[] = CustomHelper::formatAmount($minimum, $decimals->decimals) . ' ' . $currency;
        }

        return view('faq', compact('paymentSystems', 'minDepositLimits', 'maxDepositLimits', 'withdrawMinimums'));
    }

    public function affiliate()
    {
        return view('affiliate');
    }
}
