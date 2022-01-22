<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\Payout;
use App\Models\UserAccount;
use App\Notifications\DepositConfirmedNotification;
use App\Notifications\ReferralCommissionNotification;
use App\Notifications\WithdrawalNotification;
use Illuminate\Http\Request;

class PayoutService
{

    /**
     * @param $payoutId
     * @param $transactionId
     * @return mixed
     */
    public function setAsPaid($payoutId, $transactionId)
    {
        $payout = Payout::find($payoutId);
        $payout->transaction_id = $transactionId;
        $payout->status = 'paid';
        $payout->paid_at = now();
        $payout->save();

        // Notify Here
        $payout->user->notify(new WithdrawalNotification(
            number_format($payout->amount, $payout->paymentSystem->decimals, '.', ''),
            $payout->paymentSystem->currency,
            $payout->paymentSystem->name,
            $transactionId
        ));

        $payout->user->histories()->create([
            'action' => 'withdraw_complete',
            'data' => json_encode([
                'payment_system' => $payout->paymentSystem->name,
                'amount' => number_format($payout->amount, $payout->paymentSystem->decimals, '.', ''),
                'currency' => $payout->paymentSystem->currency,
                'transaction_id' => $transactionId
            ])
        ]);

        return $payout;

    }

}
