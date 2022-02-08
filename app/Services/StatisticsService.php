<?php

namespace App\Services;

use App\Helpers\CustomHelper;
use App\Models\Deposit;
use App\Models\ExchangeRate;
use App\Models\PaymentSystem;
use App\Models\Payout;
use App\Models\UserAccount;
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

    public function convertedDepositSum(?int $userId = null, ?string $status = null): float|int
    {
        $depositSum = 0;
        $totalDeposits = Deposit::join('payment_systems', 'payment_systems.id', '=', 'deposits.payment_system_id')
            ->when(!$status, function ($query) {
                $query->where(function($subQuery) {
                    return $subQuery->where('status', 'active')
                        ->orWhere('status', 'finished');
                });
            })
            ->when($status, fn($subQuery) => (
                $subQuery->where('deposits.status', $status)
            ))
            ->when($userId, fn($subQuery) => (
                $subQuery->where('user_id', $userId)
            ))
            ->selectRaw('payment_systems.currency as currency, payment_systems.decimals as decimals, payment_system_id, sum(`amount`) as total_deposit')
            ->groupBy('payment_systems.currency')
            ->get();

        foreach ($totalDeposits as $totalDeposit) {
            if($totalDeposit->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $totalDeposit->currency)->first();
                $depositSum += $totalDeposit->total_deposit * (json_decode($exchangeRate?->rate)?->USD ?? 1);
            } else {
                $depositSum += $totalDeposit->total_deposit;
            }
            $depositSum = round($depositSum, 2);
        }

        return $depositSum;
    }

    public function convertedAvailableBalance($userId = null): float|int
    {
        $availableBalance = 0;
        $balances = UserAccount::join('payment_systems', 'payment_systems.id', '=', 'user_accounts.payment_system_id')
            ->when($userId, fn($subQuery) => (
                $subQuery->where('user_id', $userId)
            ))
            ->selectRaw('payment_systems.currency as currency, payment_systems.decimals as decimals, payment_system_id, sum(`balance`) as available_balance')
            ->groupBy('payment_systems.currency')
            ->get();

        foreach ($balances as $balance) {
            if($balance->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $balance->currency)->first();
                $availableBalance += $balance->available_balance * (json_decode($exchangeRate?->rate)?->USD ?? 1);
            } else {
                $availableBalance += $balance->available_balance;
            }
            $availableBalance = round($availableBalance, 2);
        }

        return $availableBalance;
    }

    public function convertedPayoutSum(?int $userId = null, string $status = 'paid'): float|int
    {
        $payoutSum = 0;
        $totalPayouts = Payout::join('payment_systems', 'payment_systems.id', '=', 'payouts.payment_system_id')
            ->where('status', $status)
            ->when($userId, fn($subQuery) => (
                $subQuery->where('user_id', $userId)
            ))
            ->selectRaw('payment_systems.currency as currency, payment_systems.decimals as decimals, payment_system_id, sum(`amount`) as total_payout')
            ->groupBy('payment_systems.currency')
            ->get();

        foreach ($totalPayouts as $totalPayout) {
            if($totalPayout->currency != 'USD') {
                $exchangeRate = ExchangeRate::where('from', $totalPayout->currency)->first();
                $payoutSum += $totalPayout->total_payout * (json_decode($exchangeRate?->rate)?->USD ?? 1);
            } else {
                $payoutSum += $totalPayout->total_payout;
            }
            $payoutSum = round($payoutSum, 2);
        }

        return $payoutSum;
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

            $walletData[$paymentSystem->value]['balance'] = PaymentSystemService::getBalance($paymentSystem->value);

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

        $walletData['all']['balance'] = CustomHelper::formatAmount(round($walletData['all']['balance'], 2), 2);
        $walletData['all']['total_deposit'] = CustomHelper::formatAmount(round($walletData['all']['total_deposit'], 2), 2);
        $walletData['all']['total_payout'] = CustomHelper::formatAmount(round($walletData['all']['total_payout'], 2), 2);

        return [
            'walletData' => $walletData,
            'paymentSystems' => $paymentSystems
        ];
    }

}
