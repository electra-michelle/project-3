<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Models\Deposit;
use App\Services\CryptoNodeService;
use App\Services\StatisticsService;
use Illuminate\Console\Command;
use App\Models\PaymentSystem;
use Illuminate\Support\Arr;

class CryptoTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores TXID/confirmations of Cryptocurrency deposits';


    protected $largeInMinutes = 30;


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $paymentSystems = PaymentSystem::where('process_type', 'node')
            ->active()
            ->get();


        foreach ($paymentSystems as $paymentSystem)
        {
            $this->info('------------' . $paymentSystem->name . '-----------');

            $nodeService = new CryptoNodeService($paymentSystem->value);

            $large = false;
            if(!$paymentSystem->last_large_cron || $paymentSystem->last_large_cron < now()->subMinutes($this->largeInMinutes)) {

                $paymentSystem->last_large_cron = now();
                $lists = $nodeService->listtransactions(200, config('crypto.' . $paymentSystem->value . '.account'));
                $large = true;
            } else {
                $lists = $nodeService->listsinceblock($paymentSystem->last_visited_block);
                $paymentSystem->last_visited_block = $lists['lastblock'];
            }

            $paymentSystem->save();


            if(!$lists) {
                $this->info(" * NODE ERROR: " . $nodeService->node->error);
                continue;
            }

            $transactions = $large ? $lists : $lists['transactions'];


            foreach($transactions as $transaction) {
                if($transaction['category'] != "receive") {
                    continue;
                }

                if($transaction['confirmations'] < 0) {
                    $this->info("  -- IGNORE:  Transation conflict with the block chain \"" . $transaction['txid'] . "\"!");
                }

                $deposit = Deposit::with(['plan.limits' => function($query) use ($paymentSystem){
                    return $query->where('currency', $paymentSystem->currency);
                }])
                ->where('payment_system_id', $paymentSystem->id)
                ->where('deposit_address', $transaction['address'])
                ->whereNull('transaction_id')
                ->where('status', 'pending')
                ->first();

                if(!$deposit) {
                    continue;
                }

                $amount = CustomHelper::formatAmount($transaction['amount'], $paymentSystem->decimals);
                if($amount != $deposit->amount)
                {
                    if($amount >= $deposit->plan->limits->first()->min_amount && $amount <= $deposit->plan->limits->first()->max_amount) {
                        $this->info("  -- UPDATED: Updating deposit #" . $deposit->id . " amount from " . $deposit->amount . " to " . $amount );
                        $deposit->amount = $amount;
                    } else {
                        $this->info("  -- IGNORE: Wrong amount has been sent to address " . $transaction['address'] . " - Deposit ID: " . $deposit->id .  " (Received: " . $amount . ", WAITING FOR: " . $deposit->amount . ")");
                        continue;
                    }
                }

                $deposit->transaction_id = $transaction['txid'];
                $deposit->confirmations = $transaction['confirmations'];
                $deposit->save();

            }

        }

    }
}
