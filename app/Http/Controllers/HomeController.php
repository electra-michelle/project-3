<?php

namespace App\Http\Controllers;

use App\PaymentSystems\PayKassa\Api as PayKassaApi;
use App\PaymentSystems\PayKassa\Sci as PayKassaSci;
use Illuminate\Http\Request;
use App\Models\PaymentSystem;
use App\Models\Plan;
use App\Helpers\TronHelper;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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

        return view('home', compact('plans', 'paymentSystems'));
    }

    public function test(Request $request)
    {
		
		$paykassa = new PayKassaSci();
		$paykassa->getCryptoAddress(1, 10.000000, 'USDT');
		// dd($paykassa->getBalance('tron_trc20_usdt'));

    }
}
