<?php

namespace App\Http\Controllers;

use App\Models\PaymentSystem;
use App\Models\Plan;
use Illuminate\Http\Request;

class InfoPageController extends Controller
{
    public function investments()
    {
        $plans = Plan::get();
        $paymentSystems = PaymentSystem::active()->get();
        return view('investments', compact('plans', 'paymentSystems'));
    }
}
