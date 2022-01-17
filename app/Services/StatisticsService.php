<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\Payout;

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

}
