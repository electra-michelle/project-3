<?php

namespace App\Http\Controllers;

use App\Events\StatisticsEvent;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Laravel\Facades\Telegram;

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
        StatisticsEvent::dispatch(['test' => time()]);

		return 'ok';

    }
}
