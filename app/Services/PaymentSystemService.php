<?php

namespace App\Services;

use App\PaymentSystems\ePayCore;
use App\Rules\CryptoNodeRule;

class PaymentSystemService
{

    /**
     * @param string $paymentSystemValue
     * @return CryptoNodeRule|string|void
     */
    public static function getValidationRule(string $paymentSystemValue)
    {
        switch($paymentSystemValue) {
            case 'bitcoin':
            case 'bitcoincash':
            case 'litecoin':
            case 'dash':
            case 'dogecoin':
                return new CryptoNodeRule();
            case 'epaycore':
                return 'regex:/^[Ee][\d]{6,9}$/';
            default:
                return null;
        }

    }

    public static function getBalance(string $paymentSystemValue)
    {
        switch ($paymentSystemValue) {
            case 'epaycore':
                $epayCore = new ePayCore();
                return $epayCore->getBalance();
            case 'bitcoin':
            case 'bitcoincash':
            case 'dash':
            case 'litecoin':
            case 'dogecoin':
                $nodeService = new CryptoNodeService($paymentSystemValue);
                return $nodeService->getBalance();
            default:
                return 0;
        }
    }

}
