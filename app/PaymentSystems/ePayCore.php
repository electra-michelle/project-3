<?php

namespace App\PaymentSystems;

use GuzzleHttp\Client;

class ePayCore
{

    private $client;

    private $config;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.epaycore.com/v1/',
        ]);

        $this->config = config('epaycore.api');
    }

    /**
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalance()
    {
        try {
            $response = $this->client->post('balance',
                ['form_params' => [
                    'api_id' => $this->config['id'],
                    'api_secret' => $this->config['secret']]
                ]
            );
            $balance = json_decode($response->getBody()->getContents());

            return $balance->total;

        } catch (\Exception $exception) {
            return 0;
        }

    }

}
