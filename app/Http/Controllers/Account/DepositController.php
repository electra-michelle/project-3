<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Models\Deposit;
use App\Models\PaymentSystem;
use App\Models\Plan;
use App\Services\CryptoNodeService;
use App\Services\DepositService;
use App\Services\PlanService;
use App\Services\WalletBalanceService;
use Illuminate\Support\Str;
use App\PaymentSystems\PayKassa\Sci as PayKassaSci;

class DepositController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(PlanService $planService)
    {
        $paymentSystems = PaymentSystem::active()->get();
        //$plans = Plan::get();

        $plans = $planService->getPlanData();

        return view('account.deposit.create', compact('paymentSystems', 'plans'));
    }

    /**
     * @param $depositUrl
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function details($depositUrl)
    {
        $deposit = auth()->user()->deposits()
            ->withMax('planPeriod', 'period_end')
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
        if($paymentSystem->processing_type == 'node' && $request->input('payment_method') == 'payment_processor') {
            $nodeService = new CryptoNodeService($paymentSystem->value);
            $depositAddress = $nodeService->config['account'] ?
                $nodeService->node->getnewaddress($nodeService->config['account']) :
                $nodeService->node->getnewaddress();

            if(!$depositAddress) {
                return redirect()->back()->withInput()
                    ->withErrors([
                        'message' => 'This payment method is currently unavailable. Please, try again later.'
                    ]);
            }
        }

        $unique = false;
        while(!$unique) {
            $url = Str::random();
            $unique = Deposit::where('url', $url)->count() == 0;
        }

        $deposit = $user->deposits()->create([
            'payment_system_id' => $paymentSystem->id,
            'plan_id' => $plan->id,
            'amount' => $request->input('amount'),
            'payment_type' => $request->input('payment_method') == 'account_balance' ? 'reinvest' : 'invest',
            'url' => $url,
            'deposit_address' => $depositAddress
        ]);

		if($paymentSystem->process_type == 'paykassa' && $request->input('payment_method') == 'payment_processor') {

			$paykassa = new PayKassaSci();
			if(in_array($paymentSystem->value, config('paykassa.crypto'))) {
				$address = $paykassa->getCryptoAddress($deposit->id, $deposit->amount, $deposit->paymentSystem->currency, $deposit->paymentSystem->value);
			} else {
				$address = $paykassa->getRedirectUrl($deposit->id, $deposit->amount, $deposit->paymentSystem->currency, $deposit->paymentSystem->value);
			}
			
			
			if(!$address) {
				$deposit->delete();
				return redirect()->back()->withInput()
                    ->withErrors([
                        'message' => 'This payment method is currently unavailable. Please, try again later.'
                    ]);

			} else {
				$deposit->deposit_address = $address;
				$deposit->save();
			}

		}

        if($request->input('payment_method') == 'account_balance') {
            $depositService = new DepositService();
            $depositService->acceptDeposit($deposit);

            // Reduce balance
            $wallet = $user->wallets()->where('payment_system_id', $paymentSystem->id)->first();
            $walletBalanceService = new WalletBalanceService();
            $walletBalanceService->subBalance($wallet, $deposit->amount, $paymentSystem->decimals);
        }

        return redirect()->route('account.deposit.details', ['depositUrl' => $deposit->url]);

    }
}
