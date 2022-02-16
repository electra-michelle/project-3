<?php

namespace App\Http\Controllers;

use App\PaymentSystems\PayKassa\Api as PayKassaApi;
use Illuminate\Http\Request;
use App\Rules\TronNetworkRule;

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
		$request->validate([
			'test' => 
		]);
		
		// $paykassa = new PayKassaApi();
		// dd($paykassa->getBalance('tron_trc20_usdt'));

    }
}
