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
		
		$paykassa = new PayKassaSci();
		$paykassa->getCryptoAddress(1, 10.000000, 'USDT');
		// dd($paykassa->getBalance('tron_trc20_usdt'));

    }
}
