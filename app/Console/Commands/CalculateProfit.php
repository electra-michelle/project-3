<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Models\Plan;
use App\Models\Deposit;
use App\Models\UserAccount;
use App\Models\UserHistory;
use App\Notifications\DepositFinishedNotification;
use App\Notifications\PrincipalsReturnedNotification;
use App\Notifications\ProfitAddedNotification;
use App\Services\WalletBalanceService;
use Illuminate\Console\Command;

class CalculateProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates profits for active deposits';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plans = Plan::get();
        $balanceService = new WalletBalanceService();

        foreach ($plans as $plan) {

            switch($plan->period_type) {
                case 'hourly':
                    $periodStamp = now()->subHour();
                    break;
                case 'daily':
                    $periodStamp = now()->subDay();
                    break;
                case 'weekly':
                    $periodStamp = now()->subWeek();
                    break;
                case 'monthly':
                    $periodStamp = now()->subMonth();
                    break;
                default: $periodStamp = null;
            }

            $maxPeriod = $plan->periods->max('period_end');

            $deposits = Deposit::with('paymentSystem', 'user')
                ->where('status', 'active')
                ->where('plan_id', $plan->id)
                ->where('last_credited_at', '<', $periodStamp)
                ->get();

            foreach ($deposits as $deposit)
            {
                $deposit->last_credited_at = now();
                $deposit->increment('period_passed');

                $interest = $plan->periods->where('period_start', '<=', $deposit->period_passed)
                    ->where('period_end', '>=', $deposit->period_passed)
                    ->first()?->interest ?? null;

                if($interest) {
                    $profit = round($deposit->amount*$interest/100, $deposit->paymentSystem->decimals);
                    $userAccount = UserAccount::where('user_id', $deposit->user_id)
                        ->where('payment_system_id', $deposit->payment_system_id)
                        ->firstOrCreate();

                    $balanceService->addBalance($userAccount, $profit, $deposit->paymentSystem->decimals);

                    $deposit->user->histories()->create([
                        'action' => 'daily_income',
                        'data' => json_encode([
                            'plan' => $deposit->plan->value,
                            'amount' => CustomHelper::formatAmount($profit, $deposit->paymentSystem->decimals),
                            'currency' => $deposit->paymentSystem->currency
                        ])
                    ]);

                    if(CustomHelper::isEmailNotificationEnabled('profit_added')) {
                        $deposit->user->notify(new ProfitAddedNotification($profit, $deposit->paymentSystem->currency, $deposit->paymentSystem->name));
                    }
                }

                if($deposit->period_passed >= $maxPeriod){

                    $deposit->status = 'finished';
                    $deposit->user->histories()->create([
                        'action' => 'plan_finished',
                        'data' => json_encode([
                            'id'    =>  $deposit->id,
                            'plan_name'  => $deposit->plan->name,
                            'plan_value'  => $deposit->plan->value,
                            'amount'  => CustomHelper::formatAmount($deposit->amount, $deposit->paymentSystem->decimals),
                        ])
                    ]);

                    if(CustomHelper::isEmailNotificationEnabled('deposit_finished')) {
                        $deposit->user->notify(new DepositFinishedNotification($deposit->id));
                    }

                    if($deposit->plan->principal_return == true)
                    {
                        $userAccount = UserAccount::where('user_id', $deposit->user_id)
                            ->where('payment_system_id', $deposit->payment_system_id)
                            ->firstOrCreate();

                        $balanceService->addBalance($userAccount, $deposit->amount, $deposit->paymentSystem->decimals);

                        if(CustomHelper::isEmailNotificationEnabled('principals_returned')) {
                            $deposit->user->notify(new PrincipalsReturnedNotification($deposit->id, $deposit->paymentSystem->name));
                        }

                        $deposit->user->histories()->create([
                            'action' => 'principals_returned',
                            'data' => json_encode([
                                'deposit_id' => $deposit->id,
                                'amount' => CustomHelper::formatAmount($deposit->paymentSystem->name, $deposit->paymentSystem->decimals),
                                'currency' => $deposit->paymentSystem->currency,
                            ])
                        ]);

                        $this->info("Principals Returned" . $deposit->amount);
                    }
                }

                $deposit->save();

            }

        }
    }
}
