<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\PaymentSystems\PerfectMoney;
use App\Services\PayoutService;
use Illuminate\Console\Command;

class PayoutPerfectMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:perfectmoney';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically transfers Perfect Money transactions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private PerfectMoney $perfectMoney, private PayoutService $payoutService)
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
        $paymentSystem = PaymentSystem::where('value', 'perfect_money')
            ->where('payouts_enabled', true)
            ->active()
            ->first();

        if(!$paymentSystem) {
            return self::SUCCESS;
        }

        $payouts = Payout::with(['user.wallets' => function($query) use ($paymentSystem) {
            return $query->where('payment_system_id', $paymentSystem->id);
        }])
            ->where('status', 'pending')
            ->where('payment_system_id', $paymentSystem->id)
            ->get();

        foreach ($payouts as $payout)
        {
            $wallet = $payout->user->wallets->first()->wallet;

            if($wallet) {
                $amount =  CustomHelper::formatAmount(round($payout->amount, $paymentSystem->decimals), $paymentSystem->decimals);

                $transfer = $this->perfectMoney->sendMoney(
                    $wallet,
                    $amount,
                    config('perfectmoney.payout_description') . ' #' . $payout->id,
                    $payout->id
                );

                if($transfer['status'] == 'success') {
                    $this->payoutService->setAsPaid($payout->id, $transfer['data']['PAYMENT_BATCH_NUM']);
                    $this->info('PAYOUT #' . $payout->id . ' has been completed with batch ' . $transfer['data']['PAYMENT_BATCH_NUM']);
                }
            }
        }
    }
}
