<?php

namespace App\Services;

use App\PaymentSystems\Crypto;

class CryptoNodeService
{

    public $node;

    public function __construct($value)
    {
        $config = config('crypto.' . $value);
        $this->node = new Crypto(
            $config['username'],
            $config['password'],
            $config['host'],
            $config['port'],
            $config['wallet'] ?? null
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

    /**
     * @param $transactionCount
     * @param null $account
     * @return mixed
     */
    public function listtransactions($transactionCount, $account = null)
    {
        return $this->node->listtransactions($account ?: '*', $transactionCount);
    }

    /**
     * @param null $block
     * @return mixed
     */
    public function listsinceblock($block = null)
    {
        return $block ? $this->node->listsinceblock($block) : $this->node->listsinceblock();
    }

}
