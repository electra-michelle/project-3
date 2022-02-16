<?php

namespace App\PaymentSystems\PayKassa;

use GuzzleHttp\Client;

class Api
{
    public $version = "0.5";

    private $client;

    private $config;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://paykassa.app/api/0.5/index.php',
        ]);

        $this->config = config('paykassa.api');
    }

}
