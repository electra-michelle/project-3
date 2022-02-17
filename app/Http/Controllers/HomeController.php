<?php

namespace App\Http\Controllers;

use App\Services\PlanService;
use Illuminate\Http\Request;
use App\Models\PaymentSystem;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(PlanService $planService)
    {
        $plans = $planService->getPlanData();

        $paymentSystems = PaymentSystem::active()->get();

        return view('home', compact('plans', 'paymentSystems'));
    }

    public function test(Request $request)
    {

		//$paykassa = new PayKassaApi();
		//$paykassa->getCryptoAddress(1, 10.000000, 'USDT');
		//dd($paykassa->getBalance('tron_trc20_usdt'));

    }
}
