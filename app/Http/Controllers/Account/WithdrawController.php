<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
    public function index()
    {
        return view('account.withdraw');
    }
}
