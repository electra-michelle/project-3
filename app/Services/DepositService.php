<?php

namespace App\Services;

use App\Events\StatisticsEvent;
use App\Helpers\CustomHelper;
use App\Models\Deposit;
use App\Models\UserAccount;
use App\Notifications\DepositConfirmedNotification;
use App\Notifications\ReferralCommissionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Laravel\Facades\Telegram;

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

        if(CustomHelper::isBroadcastNotificationEnabled('new_deposit')) {
            StatisticsEvent::dispatch([
                'type' => 'new_deposit',
                'amount' => CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals),
                'currency' => $deposit->paymentSystem->currency,
                'transaction_id' => Str::mask($transactionId, '*', 5),
                'method' => $deposit->paymentSystem->name,
                'username' => Str::mask($deposit->user->username, '*', 4),
                'timeAgo' => now()->diffForHumans(),
                'date' => now(),
                'timestamp' => now()->timestamp,
            ]);
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

        $telegramConfig = config('telegram.bots.notifications');
        if($telegramConfig['chat_id'] && $telegramConfig['token']) {
            Telegram::bot('notifications')
                ->sendMessage([
                    'chat_id' => config('telegram.bots.notifications.chat_id'),
                    'text' => Emojify::text(trans('telegram.notification') . trans('telegram.new_deposit', [
                            'username' => $deposit->user->username,
                            'currency' => $deposit->paymentSystem->currency,
                            'amount' => CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals)
                        ])),
                ]);
        }

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

            if(CustomHelper::isBroadcastNotificationEnabled('ref_commission')) {
                StatisticsEvent::dispatch([
                    'type' => 'ref_commission',
                    'amount' => CustomHelper::formatAmount($commission, $deposit->paymentSystem->decimals),
                    'currency' => $deposit->paymentSystem->currency,
                    'method' => $deposit->paymentSystem->name,
                    'username' =>  Str::mask($deposit->user->referredBy->username, '*', 4),
                    'timeAgo' => now()->diffForHumans(),
                    'date' => now(),
                    'timestamp' => now()->timestamp,
                ]);
            }


            if($telegramConfig['chat_id'] && $telegramConfig['token']) {
                Telegram::bot('notifications')
                    ->sendMessage([
                        'chat_id' => config('telegram.bots.notifications.chat_id'),
                        'text' => Emojify::text(trans('telegram.notification') . trans('telegram.new_commission', [
                            'username' => $deposit->user->referredBy->username,
                            'downline' => $deposit->user->username,
                            'currency' => $deposit->paymentSystem->currency,
                            'amount' => CustomHelper::formatAmount($commission, $deposit->paymentSystem->decimals)
                        ])),
                    ]);
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

        }

        return $deposit;

    }

}
