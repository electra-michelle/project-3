<?php

namespace App\PaymentSystems\PayKassa;

use GuzzleHttp\Client;

class Sci
{
    public $version = "0.4";

    private $client;

    private $config;

    public function __construct()
    {
        $this->config('paykassa.sci');

        $this->client = new Client([
            'base_uri' => 'https://paykassa.app/sci/0.4/index.php',
        ]);
    }

}
