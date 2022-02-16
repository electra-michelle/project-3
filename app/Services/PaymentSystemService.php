<?php

namespace App\Services;

use App\PaymentSystems\ePayCore;
use App\Rules\CryptoNodeRule;
use App\Rules\TronNetworkRule;
use App\PaymentSystems\PayKassa\Api as PayKassaApi;

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
			case 'tron_trc20_usdt':
				return new TronNetworkRule();
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
			case 'tron_trc20_usdt':
				$paykassa = new PayKassaApi();
				return $paykassa->getBalance($paymentSystemValue);
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
