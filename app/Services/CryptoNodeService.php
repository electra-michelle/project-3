<?php

namespace App\Services;

use App\PaymentSystems\Crypto;

class CryptoNodeService
{

    private $node;

    public function __construct($value)
    {
        $config = config('crypto.' . $value);
        $this->node = new Crypto(
            $config['username'],
            $config['password'],
            $config['host'],
            $config['port'],
            $config['wallet']
        );
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        $balance = $this->node->getbalance();

        return $balance ?: 0;
    }

    /**
     * @param $value
     * @return boolean
     */
    public function validateAddress($value)
    {
        return $this->node
                ->validateaddress($value)['isvalid'] ?? false;
    }

}
