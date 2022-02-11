<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\PaymentSystems\ePayCore;
use App\Services\PayoutService;
use Illuminate\Console\Command;

class ePayCorePayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:epaycore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically transfers ePayCore transactions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ePayCore $ePayCore, private PayoutService $payoutService)
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
        $paymentSystem = PaymentSystem::where('value', 'epaycore')
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

                $transfer = $this->ePayCore->transfer(
                    $wallet,
                    $amount,
                    config('epaycore.api.description') . ' #' . $payouts->id,
                    $payout->id
                );
                if(isset($transfer->error) || !$transfer) {
                    $this->info('PAYOUT #' . $payout->id . ' sending failed with message: ' . $transfer->error ?? '' );
                    continue;
                }

                $this->payoutService->setAsPaid($payout->id, $transfer->batch);
                $this->info('PAYOUT #' . $payout->id . ' has been completed with batch ' .  $transfer->batch);
            }
        }
    }
}
