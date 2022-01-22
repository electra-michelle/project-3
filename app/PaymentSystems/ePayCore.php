<?php

namespace App\PaymentSystems;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return false|string
     */
    public function generateHash(Request $request)
    {
        # sign params
        $sign = [
            $request->input('epc_merchant_id'),
            $request->input('epc_order_id'),
            $request->input('epc_created_at'),
            $request->input('epc_amount'),
            $request->input('epc_currency_code'),
            $request->input('epc_dst_account'),
            $request->input('epc_src_account'),
            $request->input('epc_batch'),
            config('epaycore.sci.password')
        ];

        # get sha256 signature
        return hash('sha256', implode(':', $sign));

    }

}
