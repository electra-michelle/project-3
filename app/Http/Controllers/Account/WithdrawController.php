<?php

namespace App\Http\Controllers\Account;

use App\Helpers\CustomHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\Models\UserAccount;
use App\Services\WalletBalanceService;

class WithdrawController extends Controller
{
    public function index()
    {
        $payouts = Payout::with('paymentSystem')->latest()->paginate(15);
        $paymentSystems = PaymentSystem::active()
            ->leftJoin('user_accounts', fn($join) => (
                $join->on('payment_systems.id', '=', 'user_accounts.payment_system_id')
                ->where('user_accounts.user_id', auth()->user()->id)
            ))
            ->get();


        return view('account.withdraw.form', compact('payouts', 'paymentSystems'));
    }

    public function store(WalletBalanceService $balanceService, WithdrawRequest $request)
    {
        $user = auth()->user();
        $wallet = $user->wallets()
            ->select('user_accounts.id', 'user_accounts.balance', 'payment_systems.decimals', 'payment_systems.id as payment_system_id')
            ->join('payment_systems', 'payment_systems.id', '=', 'user_accounts.payment_system_id')
            ->where('payment_systems.value', $request->input('payment_system'))
            ->first();

        $payout = $user->payouts()->create([
            'payment_system_id' => $wallet->payment_system_id,
            'amount' => round($request->input('amount'), $wallet->decimals)
        ]);

        $balanceService->subBalance($wallet, $request->input('amount'), $wallet->decimals);

        // User history
        $user->histories()->create([
            'action' => 'withdraw_request',
            'data' => json_encode([
                'id' => $payout->id,
                'payment_system' => $payout->paymentSystem->name,
                'amount' => CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals),
                'currency' => $payout->paymentSystem->currency,
            ])
        ]);

        return redirect()->back()->with([
            'withdraw_success' => 'Withdraw request has been successfully created.'
        ]);

    }
}
