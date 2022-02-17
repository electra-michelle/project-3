<?php

namespace App\PaymentSystems\PayKassa;

use GuzzleHttp\Client;

interface PayKassaInterface
{

    public function defaultRequestData() : array;

}
