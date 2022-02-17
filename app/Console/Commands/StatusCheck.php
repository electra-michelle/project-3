<?php

namespace App\Console\Commands;

use App\Models\PaymentSystem;
use App\PaymentSystems\ePayCore;
use App\Services\CryptoNodeService;
use Illuminate\Console\Command;
use App\PaymentSystems\PayKassa\Api as PayKassaApi;

class StatusCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the statuses of each payment system';

    private function errorMessage($message = '')
    {
        $this->error('STATUS: FAIL');
        $this->error('Reason: ' . $message);
    }

    private function statusOk()
    {
        $this->info('STATUS: OK');
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $paymentSystems = PaymentSystem::active()->get();
        foreach($paymentSystems as $paymentSystem)
        {
            $this->line('Checking ' . $paymentSystem->name);

            if(in_array($paymentSystem->value, array_keys(config('crypto')))) {
                $nodeService = new CryptoNodeService($paymentSystem->value);
                $walletInfo = $nodeService->node->getwalletinfo();

                !$walletInfo ? $this->errorMessage($nodeService->node->error) : $this->statusOk();

            } else {
                switch ($paymentSystem->value) {
					case 'tron_trc20_usdt':
						$paykassa = new PayKassaApi();
						$status = $paykassa->statusCheck();
						$status['error'] ? $this->errorMessage($status['message']) : $this->statusOk();
						break;
                    case 'epaycore':
                        $epaycore = new ePayCore();
                        $status = $epaycore->checkStatus();
                        isset($status->error) ? $this->errorMessage($status->error) : $this->statusOk();
                        break;
                    default:
                        $this->warn('Missing status checker');
                }
            }


        }
    }
}
