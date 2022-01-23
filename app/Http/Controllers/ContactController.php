<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Message;

class ContactController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * @param ContactRequest $request
     */
    public function sendMessage(ContactRequest $request)
    {
        Message::create($request->validated());

        return redirect()->back()->with(['success' => 'Your message has been successfully sent.']);
    }
}
