<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TelegramRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function __construct()
    {
        abort_if(!config('telegram.bots.notifications.chat_id') || !config('telegram.bots.notifications.token'), 404);
    }

    public function show()
    {
        $emojies = json_decode(file_get_contents(public_path('vendor/emoji.json')), true);

        return view('admin.telegram.form', compact('emojies'));
    }

    public function send(TelegramRequest $request)
    {
        try {
            Telegram::bot('notifications')
                ->sendMessage([
                    'chat_id' => config('telegram.bots.notifications.chat_id'),
                    'text' => Emojify::text($request->input('message')),
                ]);

            return redirect()->back()->with(['success' => 'Message has been sent.']);
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => 'Exception error ' . $exception->getMessage()]);
        }


        return redirect()->back()
            ->with(['success' => 'Message has been successfuly sent.']);
    }
}
