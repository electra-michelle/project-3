<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SupportMessageRequest;
use App\Mail\SupportMessage;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MessagesController extends Controller
{
    /**
     * @param null $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($type = null)
    {
        $messages = Message::latest()
            ->when($type == 'unread', fn($query) => (
                $query->where('is_read', false)
            ))
            ->when($type == 'read', fn($query) => (
                $query->where('is_read', true)
            ))
            ->paginate(15);

        return view('admin.messages.list', compact('messages'));
    }

    /**
     * @param Message $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Message $message)
    {
        $message->is_read = true;
        $message->save();

        return view('admin.messages.show', compact('message'));
    }


    public function update(Message $message, SupportMessageRequest $request)
    {
        Mail::to($message->email)
            ->send(new SupportMessage($message, $request->validated()));

        $message->is_answered = true;
        $message->save();

        return redirect()->back()
            ->with(['success' => 'Message has been successfully sent']);
    }

    /**
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->back()
            ->with(['success' => 'Message has been successfully deleted']);
    }
}
