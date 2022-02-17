<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use GuzzleHttp\Client;

class TronHelper
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.trongrid.io/',
        ]);

    }

    /**
     * @param $uri
     * @param array $data
     * @param string $method
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest($uri, $data = [], $method = 'POST')
    {

        $requestOptions = [
            ($method == 'GET' ? 'query' : 'body') => $method == 'GET' ? $data : json_encode($data),
            'headers' => [
                'content-type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ];

        $response = $this->client->request($method, $uri, $requestOptions);

        return json_decode($response->getBody()->__toString());
    }


    public function validateAddress($address)
    {
        try {
            $response = $this->makeRequest('wallet/validateaddress', [
                'address' => $address
            ]);

            return $response->result;
        } catch (\Exception $e) {
            return false;
        }

    }
}
