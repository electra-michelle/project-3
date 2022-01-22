<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\UserAccount;
use App\Notifications\DepositConfirmedNotification;
use App\Notifications\ReferralCommissionNotification;
use Illuminate\Http\Request;

class DepositService
{
    /**
     * @param Deposit $deposit
     * @param $transactionId
     */
    public function acceptDeposit(Deposit $deposit, $transactionId)
    {
        // Activate Deposit
        $deposit->status = 'active';
        $deposit->confirmed_at = now();
        $deposit->last_credited_at = now();
        $deposit->transaction_id = $transactionId;
        $deposit->save();

        $amount = number_format($deposit->amount, $deposit->paymentSystem->decimals, '.', '');
        $wallet = $deposit->paymentSystem->name;
        $currency = $deposit->paymentSystem->currency;
        $plan = $deposit->plan->name;

        $deposit->user->notify(new DepositConfirmedNotification($amount, $currency, $plan, $wallet));

        $deposit->user->histories()->create([
            'action' => 'new_investment',
            'data' => json_encode([
                'payment_system' => $wallet,
                'amount' => $amount,
                'currency' => $currency,
                'plan' => $plan,
            ])
        ]);

        if($deposit->user->upline) {

            $commission = round($deposit->plan->affiliate_commission*$amount/100, $deposit->paymentSystem->decimals);

            $refBalance = UserAccount::where('user_id', $deposit->user->upline)
                ->where('payment_system_id', $deposit->paymentSystem->id)
                ->firstOrCreate();

            $refBalance->balance =  round($refBalance->balance+$commission, $deposit->paymentSystem->decimals);
            $refBalance->save();

            $deposit->user->referredBy->notify(new ReferralCommissionNotification(
                number_format($commission, $deposit->paymentSystem->decimals, '.', ''),
                $currency,
                $wallet,
                $deposit->user->username
            ));

            $deposit->user->referredBy->histories()->create([
                'action' => 'commission_earned',
                'data' => json_encode([
                    'from_user' => $deposit->user->username,
                    'payment_system' => $wallet,
                    'amount' => number_format($commission, $deposit->paymentSystem->decimals, '.', ''),
                    'currency' => $currency,
                ])
            ]);
        }

    }

}
