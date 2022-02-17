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

}
