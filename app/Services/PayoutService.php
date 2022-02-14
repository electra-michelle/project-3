<?php

namespace App\Services;

use App\Events\StatisticsEvent;
use App\Helpers\CustomHelper;
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

        $payout->user->histories()->create([
            'action' => 'withdraw_complete',
            'data' => json_encode([
                'id' => $payout->id,
                'payment_system' => $payout->paymentSystem->name,
                'amount' => CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals),
                'currency' => $payout->paymentSystem->currency
            ])
        ]);

        // Notify
        if(CustomHelper::isEmailNotificationEnabled('withdraw')) {
            $payout->user->notify(new WithdrawalNotification(
                CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals),
                $payout->paymentSystem->currency,
                $payout->paymentSystem->name,
                $transactionId
            ));
        }

        if(CustomHelper::isBroadcastNotificationEnabled('withdraw')) {
            StatisticsEvent::dispatch([
                'type' => 'withdraw',
                'amount' => CustomHelper::formatAmount($payout->amount, $payout->paymentSystem->decimals),
                'currency' => $payout->paymentSystem->currency,
                'transaction_id' => $transactionId,
                'method' => $payout->paymentSystem->name,
                'username' => $payout->user->username,
                'timeAgo' => now()->diffForHumans(),
                'date' => now(),
                'timestamp' => now()->timestamp,
            ]);
        }

        return $payout;

    }

}
