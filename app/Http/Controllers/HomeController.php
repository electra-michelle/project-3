<?php

namespace App\Http\Controllers;


use \IEXBase\TronAPI\Tron;
use \IEXBase\TronAPI\Provider\HttpProvider;

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

    public function test()
    {
        $fullNode = new HttpProvider('https://api.trongrid.io');
        $solidityNode = new HttpProvider('https://api.trongrid.io');
        $eventServer = new HttpProvider('https://api.trongrid.io');
        try {
            $tron = new Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            exit($e->getMessage());
        }

        $acc = $tron->createAccount();
        dd($acc);
//        $contract = $tron->contract('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');

//        dd($contract->balanceOf());
    }
}
