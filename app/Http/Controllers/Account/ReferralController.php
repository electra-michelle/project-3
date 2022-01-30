<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $referrals = auth()->user()->referrals()
            ->latest()
            ->paginate(1);

        return view('account.referrals', compact('referrals'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function banners()
    {
        return view('account.banners');
    }
}
