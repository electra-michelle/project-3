<?php

namespace App\Console\Commands;

use App\Models\Deposit;
use App\Models\PaymentSystem;
use App\Services\CryptoNodeService;
use App\Services\DepositService;
use Illuminate\Console\Command;

class AcceptCryptoTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:accept';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accepts cryptocurrency deposits.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private DepositService $depositService)
    {
        parent::__construct();
    }

    public function handle()
    {

        $paymentSystems = PaymentSystem::whereIn('value', collect(config('crypto'))->keys()->toArray())
            ->active()
            ->get();

        foreach ($paymentSystems as $paymentSystem) {

            $deposits = Deposit::with(['plan', 'user'])
                ->where('payment_system_id', $paymentSystem->id)
                ->whereNotNull('transaction_id')
                ->where('status', 'pending')
                ->get();

            if (count($deposits)) {

                $nodeService = new CryptoNodeService($paymentSystem->value);

                foreach ($deposits as $deposit) {

                    // Fetching Transaction Data
                    $transaction = $nodeService->node->gettransaction($deposit->transaction_id);

                    if (!$transaction) {
                        $this->info(" * NODE ERROR: " . $nodeService->node->error);
                        break;
                    }

                    //Updating Confirmations
                    if ($transaction['confirmations'] != $deposit->confirmations) {
                        $deposit->confirmations = $transaction['confirmations'];
                    }

                    // Double Spend Detection
                    if ($transaction['confirmations'] < 0) {
                        $deposit->status = 'cancelled';
                        $this->info("  -- ERROR (" . $deposit->id . "): DOUBLE SPEND DETECTED !");
                    }

                    if ($transaction['amount'] != $deposit->amount) {
                        $deposit->status = 'cancelled';
                        $this->info("  -- ERROR (" . $deposit->id . "): WRONG AMOUNT !");
                    }

                    if ($transaction['confirmations'] >= 1) {
                        $deposit = $this->depositService->acceptDeposit($deposit, $deposit->transaction_id);
                        $this->info("  -- SAVED (" . $deposit->id . "): Deposit has been activated!");
                    }

                    $deposit->save();

                }
            }
        }
    }
}
