<?php

namespace App\PaymentSystems\PayKassa;

use GuzzleHttp\Client;

class BasePayKassa
{

    protected $client;

    protected $config;

    /**
     * @param $uri
     * @param array $data
     * @param string $method
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeRequest($uri, $data = [], $method = 'POST')
    {
        $data = array_merge(
            $this->defaultRequestData(),
            $data
        );

        $requestOptions = [
            ($method == 'GET' ? 'query' : 'form_params') => $data,
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
            ]
        ];

        $response = $this->client->request($method, $uri, $requestOptions);

        return json_decode($response->getBody()->__toString());
    }

    protected function paymentSystemMappings($paymentSystemValue)
    {
        $systemId = [
            "perfect_money" => 2, // supported currencies USD
            "berty" => 7, // supported currencies RUB, USD
            "bitcoin" => 11, // supported currencies BTC
            "ethereum" => 12, // supported currencies ETH
            "litecoin" => 14, // supported currencies LTC
            "dogecoin" => 15, // supported currencies DOGE
            "dash" => 16, // supported currencies DASH
            "bitcoincash" => 18, // supported currencies BCH
            "zcash" => 19, // supported currencies ZEC
            "ripple" => 22, // supported currencies XRP
            "tron" => 27, // supported currencies TRX
            "stellar" => 28, // supported currencies XLM
            "binancecoin" => 29, // supported currencies BNB
            "tron_trc20_usdt" => 30, // supported currencies USDT
            "binancesmartchain_bep20" => 31, // supported currencies USDT, BUSD, USDC, ADA, EOS, BTC, ETH, DOGE
            "ethereum_erc20" => 32, // supported currencies USDT
        ];

        return $systemId[$paymentSystemValue] ?? null;
    }

}
