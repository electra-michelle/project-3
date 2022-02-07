<?php

namespace App\Services;


use App\Helpers\CustomHelper;
use App\Models\UserAccount;

class WalletBalanceService
{

    /**
     * @param UserAccount $userAccount
     * @param $amount
     * @param $decimals
     * @return UserAccount
     */
    public function addBalance(UserAccount $userAccount, $amount, $decimals)
    {
        $userAccount->balance =  round($userAccount->balance+$amount, $decimals);
        $userAccount->save();

        return $userAccount;
    }

    public function subBalance(UserAccount $userAccount, $amount, $decimals)
    {
        $userAccount->balance = CustomHelper::formatAmount(round(($userAccount->balance-$amount), $decimals), $decimals, '.', '');
        $userAccount->save();

        return $userAccount;
    }

}
