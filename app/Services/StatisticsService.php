<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\ExchangeRate;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\PaymentSystems\ePayCore;

class StatisticsService
{

    /**
     * @param $paymentSystemId
     * @return mixed
     */
    public function getDepositCount($paymentSystemId)
    {
        return Deposit::where(fn($query) => (
        $query->where('status', 'active')
            ->orWhere('status', 'finished')
        )
        )
            ->where('payment_system_id', $paymentSystemId)
            ->count();
    }

    /**
     * @param null $paymentSystemId
     * @return mixed
     */
    public function getDepositSum($paymentSystemId)
    {
        return Deposit::where(fn($query) => (
        $query->where('status', 'active')
            ->orWhere('status', 'finished')
        )
        )
            ->where('payment_system_id', $paymentSystemId)
            ->sum('amount');
    }


    /**
     * @param null $paymentSystemId
     * @return mixed
     */
    public function getPayoutSum($paymentSystemId)
    {
        return Payout::where('status', 'paid')
            ->where('payment_system_id', $paymentSystemId)
            ->sum('amount');
    }

    public function getStatistics()
    {
        $paymentSystems = PaymentSystem::active()->get();
        $walletData['all'] = [
            'deposit_count' => 0,
            'total_deposit' => 0,
            'total_payout' => 0,
            'balance' => 0
        ];


        foreach($paymentSystems as $paymentSystem)
        {
            $walletData[$paymentSystem->value] = [
                'deposit_count' => $this->getDepositCount($paymentSystem->id),
                'total_deposit' => $this->getDepositSum($paymentSystem->id),
                'total_payout' => $this->getPayoutSum($paymentSystem->id),
                'balance' => 0
            ];

            switch ($paymentSystem->value) {
                case 'epaycore':
                    $epayCore = new ePayCore();
                    $walletData[$paymentSystem->value]['balance'] = $epayCore->getBalance();
                    break;
                case 'bitcoin':
                case 'bitcoincash':
                case 'dash':
                case 'litecoin':

                    $nodeService = new CryptoNodeService($paymentSystem->value);
                    $walletData[$paymentSystem->value]['balance'] = $nodeService->getBalance();
                    break;
                default:
                    $walletData[$paymentSystem->value]['balance'] = 0;
            }

            if($paymentSystem->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $paymentSystem->currency)->first();
                $convertedBalance = $walletData[$paymentSystem->value]['balance'] * (json_decode($exchangeRate?->rate)?->USD ?? 1);
                $convertedTotalDeposit = $walletData[$paymentSystem->value]['total_deposit'] * (json_decode($exchangeRate?->rate)?->USD ?? 1);
                $convertedTotalPayout = $walletData[$paymentSystem->value]['total_payout'] * (json_decode($exchangeRate?->rate)?->USD ?? 1);
            }

            $walletData['all']['balance'] += $convertedBalance ?? $walletData[$paymentSystem->value]['balance'];
            $walletData['all']['deposit_count'] += $walletData[$paymentSystem->value]['deposit_count'];
            $walletData['all']['total_deposit'] += $convertedTotalDeposit ?? $walletData[$paymentSystem->value]['total_deposit'];
            $walletData['all']['total_payout'] +=  $convertedTotalPayout ?? $walletData[$paymentSystem->value]['total_payout'];

        }

        return [
            'walletData' => $walletData,
            'paymentSystems' => $paymentSystems
        ];
    }

}
