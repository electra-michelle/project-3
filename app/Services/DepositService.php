<?php

namespace App\Services;

use App\Helpers\CustomHelper;
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
     * @return Deposit
     */
    public function acceptDeposit(Deposit $deposit, ?string $transactionId = null)
    {
        // Activate Deposit
        $deposit->status = 'active';
        $deposit->confirmed_at = now();
        $deposit->last_credited_at = now();
        $deposit->transaction_id = $transactionId;
        $deposit->save();

        $amount = CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals);
        $wallet = $deposit->paymentSystem->name;
        $currency = $deposit->paymentSystem->currency;
        $plan = $deposit->plan->name;

        if(CustomHelper::isEmailNotificationEnabled('deposit_confirmed')) {
            $deposit->user->notify(new DepositConfirmedNotification($amount, $currency, $plan, $wallet));
        }

        $deposit->user->histories()->create([
            'action' => 'new_investment',
            'data' => json_encode([
                'id' => $deposit->id,
                'payment_system' => $wallet,
                'amount' => $amount,
                'currency' => $currency,
                'plan' => $plan,
            ])
        ]);

        if($deposit->user->upline) {

            $commission = round($deposit->plan->affiliate_commission*$amount/100, $deposit->paymentSystem->decimals);

            $refBalance = UserAccount::firstOrCreate([
                    'user_id' => $deposit->user->upline,
                    'payment_system_id' => $deposit->payment_system_id,
                ]);

            $walletBalanceService = new WalletBalanceService();
            $walletBalanceService->addBalance($refBalance, $commission, $deposit->paymentSystem->decimals);

            if(CustomHelper::isEmailNotificationEnabled('ref_commission')) {
                $deposit->user->referredBy->notify(new ReferralCommissionNotification(
                    CustomHelper::formatAmount($commission, $deposit->paymentSystem->decimals),
                    $currency,
                    $wallet,
                    $deposit->user->username
                ));
            }

            $deposit->user->referredBy->histories()->create([
                'action' => 'commission_earned',
                'data' => json_encode([
                    'from_deposit' => $deposit->id,
                    'user_id' => $deposit->user->id,
                    'from_user' => $deposit->user->username,
                    'payment_system' => $wallet,
                    'amount' => CustomHelper::formatAmount($commission, $deposit->paymentSystem->decimals),
                    'currency' => $currency,
                ])
            ]);

            trans();
        }

        return $deposit;

    }

}
