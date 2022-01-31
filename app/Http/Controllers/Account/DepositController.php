<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Models\Deposit;
use App\Models\PaymentSystem;
use App\Models\Plan;
use App\Services\CryptoNodeService;
use App\Services\DepositService;
use App\Services\WalletBalanceService;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $paymentSystems = PaymentSystem::active()->get();
        $plans = Plan::get();

        return view('account.deposit.create', compact('paymentSystems', 'plans'));
    }

    /**
     * @param $depositUrl
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function details($depositUrl)
    {
        $deposit = auth()->user()->deposits()
            ->where('url', $depositUrl)
            ->firstOrFail();

        return view('account.deposit.details', compact('deposit'));
    }

    /**
     * @param DepositRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createDeposit(DepositRequest $request)
    {
        $user = auth()->user();
        $paymentSystem = PaymentSystem::where('value', $request->input('payment_system'))->first();
        $plan = Plan::where('value', $request->input('investment_plan'))->first();

        $depositAddress = null;
        if(in_array($paymentSystem->value, array_keys(config('crypto'))) && $request->input('payment_method') == 'payment_processor') {
            $nodeService = new CryptoNodeService($paymentSystem->value);
            $depositAddress = $nodeService->node->getnewaddress();
        }

        $unique = false;
        $url = null;
        while(!$unique) {
            $url = Str::random();
            $unique = Deposit::where('url', $url)->count() == 0;
        }

        $deposit = $user->deposits()->create([
            'payment_system_id' => $paymentSystem->id,
            'plan_id' => $plan->id,
            'amount' => $request->input('amount'),
            'url' => $url,
            'deposit_address' => $depositAddress
        ]);

        if($request->input('payment_method') == 'account_balance') {
            $depositService = new DepositService();
            $depositService->acceptDeposit($deposit);

            // Reduce balance
            $wallet = $user->wallets()->where('payment_system_id', $paymentSystem->id)->first();
            $walletBalanceService = new WalletBalanceService();
            $walletBalanceService->subBalance($wallet, $request->input('amount'), $paymentSystem->decimals);
        }

        return redirect()->route('account.deposit.details', ['depositUrl' => $deposit->url]);

    }
}
