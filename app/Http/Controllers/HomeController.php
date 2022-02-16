<?php

namespace App\Http\Controllers;

use App\PaymentSystems\PayKassa\Api as PayKassaApi;
use App\PaymentSystems\PayKassa\Sci as PayKassaSci;
use Illuminate\Http\Request;
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
        return view('home');
    }

    public function test(Request $request)
    {
		
		$tronHelper = new TronHelper();
		$tronHelper->validateAddress('TCzcGAq3k5hNt8LEtkrzRwGDfs5aDYRF3s');
		// dd($paykassa->getBalance('tron_trc20_usdt'));

    }
}
