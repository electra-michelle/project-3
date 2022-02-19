<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\PaymentSystems\PayKassa\Api;
use App\Services\PayoutService;
use Illuminate\Console\Command;

class PayKassaPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:paykassa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically send all pending PayKassa Transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private Api $payKassaApi, private PayoutService $payoutService)
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
        $paymentSystems = PaymentSystem::whereIn('value', config('paykassa.crypto'))
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

            foreach ($payouts as $payout) {
                $wallet = $payout->user->wallets->first()->wallet;

                if($wallet) {
                    $amount =  CustomHelper::formatAmount(round($payout->amount, $paymentSystem->decimals), $paymentSystem->decimals);

                    $transfer = $this->payKassaApi->send(
                        $payout->id,
                        $wallet,
                        $amount,
                        $paymentSystem->currency,
                        $paymentSystem->value
                    );

                    if($transfer->error) {
                        $this->info('PAYOUT #' . $payout->id . ' sending failed with message: ' . $transfer->Information ?? '' );
                        continue;
                    }

                    $this->payoutService->setAsPaid($payout->id, $transfer->data->txid);
                    $this->info('PAYOUT #' . $payout->id . ' has been completed with batch ' .  $transfer->data->txid);
                }
            }
        }
    }
}
