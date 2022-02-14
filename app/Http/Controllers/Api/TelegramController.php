<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setupWebhook(Request $request)
    {
		abort_if(config('telegram.bots.notifications.chat_id'), 404);
		
		$updates = info(Telegram::bot('notifications')->getWebhookUpdates());

		return 'ok';
    }
}
