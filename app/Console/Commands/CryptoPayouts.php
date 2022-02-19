<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\Notifications\WithdrawalNotification;
use App\Services\CryptoNodeService;
use App\Services\PayoutService;
use Illuminate\Console\Command;

class CryptoPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:crypto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically send all pending Crypto Transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private PayoutService $payoutService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $paymentSystems = PaymentSystem::whereIn('value', collect(config('crypto'))->keys()->toArray())
            ->where('payouts_enabled', true)
            ->active()
            ->get();

        foreach ($paymentSystems as $paymentSystem) {

            $this->info('------------' . $paymentSystem->name . '-----------');

            $payouts = Payout::with(['user.wallets' => function($query) use ($paymentSystem) {
                return $query->where('payment_system_id', $paymentSystem->id);
            }])
            ->where('status', 'pending')
            ->where('payment_system_id', $paymentSystem->id)
            ->get();

            $toSend = [];
            $payoutIds = [];
            foreach($payouts as $payout){
                $wallet = $payout->user->wallets->first()->wallet;

                if($wallet) {
                    if(isset($toSend[$wallet])) {
                        $amount = $toSend[$wallet]+$payout->amount;
                    } else {
                        $amount = round($payout->amount, $paymentSystem->decimals);
                    }

                    $toSend[$wallet] = CustomHelper::formatAmount($amount, $paymentSystem->decimals);
                    $payoutIds[] = $payout->id;
                }
            }

            if(!empty($toSend) && !empty($payoutIds))
            {
                $nodeService = new CryptoNodeService($paymentSystem->value);
                $transaction = $nodeService->node->sendmany($nodeService->config['account'], $toSend);

                if(!$transaction) {
                    $this->info('Node error: ' . $nodeService->node->error);
                    continue;
                }

                foreach ($payoutIds as $payoutId) {
                    $this->payoutService->setAsPaid($payoutId, $transaction);
                }
            }
        }
    }
}
