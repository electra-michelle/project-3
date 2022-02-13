<?php

namespace App\Services;

use App\PaymentSystems\Crypto;

class CryptoNodeService
{

    public $node;

    public $config;

    public function __construct($value)
    {
        $this->config = config('crypto.' . $value);
        $this->node = new Crypto(
            $this->config['username'],
            $this->config['password'],
            $this->config['host'],
            $this->config['port'],
            $this->config['wallet'] ?? null
        );
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        $balance = $this->config['account'] ?
            $this->node->getbalance($this->config['account']) :
            $this->node->getbalance();

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
