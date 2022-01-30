<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Payout;

class WithdrawController extends Controller
{
    public function index()
    {
        $payouts = Payout::paginate(15);

        return view('account.withdraw.form', compact('payouts'));
    }
}
