<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function index()
    {
        return view('account.deposit.create');
    }
}
