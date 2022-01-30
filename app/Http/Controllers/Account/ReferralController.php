<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    public function index()
    {
        return view('account.referrals');
    }

    public function banners()
    {
        return view('account.banners');
    }
}
