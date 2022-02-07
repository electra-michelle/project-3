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
     * @return array
     */
    private function defaultRequestData()
    {
        return [
            'api_id' => $this->config['id'],
            'api_secret' => $this->config['secret']
        ];
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
        $data = array_merge(
            $this->defaultRequestData(),
            $data
        );

        $requestOptions = [
            ($method == 'GET' ? 'query' : 'body') => $method == 'GET' ? $data : json_encode($data),
            'headers' => [
                'content-type' => 'application/json',
                'Accept'    => 'application/json',
            ]
        ];

        $response = $this->client->request($method, $uri, $requestOptions);

        return json_decode($response->getBody()->__toString());
    }

    /**
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalance()
    {
        try {
            $balance = $this->makeRequest('balance');

            return $balance->total;

        } catch (\Exception $exception) {
            return 0;
        }
    }

    /**
     * @param $account
     * @param $amount
     * @param null $description
     * @param null $paymentId
     * @param null $currency
     * @return mixed|null
     */
    public function transfer($account, $amount, $description = null, $paymentId = null, $currency = null)
    {
        $data = [
            'currency' => $currency ?? config('epaycore.currency'),
            'account' => $account,
            'amount' => $amount,
        ];

        if($description) {
            $data['descr'] = $description;
        }

        if($paymentId) {
            $data['payment_id'] = $paymentId;
        }

        try {
            return $this->makeRequest('transfer', $data);
        } catch (\Exception $exception) {
            return null;
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

    /**
     * @param float $amount
     * @param string|int $orderId
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function renderForm(float $amount, string|int $orderId, array $data = [])
    {

        $params = [
            'epc_merchant_id' => config('epaycore.sci.id'),
            'epc_commission' => ($data['epc_commission'] ?? config('epaycore.commission')),
            'epc_amount' => $amount,
            'epc_currency_code' => ($data['epc_currency'] ?? config('epaycore.currency')),
            'epc_order_id' => $orderId,
            'epc_success_url' => ($data['epc_success_url'] ?? config('epaycore.success_url')),
            'epc_cancel_url' => ($data['epc_cancel_url'] ?? config('epaycore.cancel_url')),
            'epc_status_url' => ($data['status_url'] ?? config('epaycore.status_url'))
        ];

        $description = ($data['epc_descr'] ?? config('epaycore.sci.id'));
        if($description) {
            $params['epc_descr'] = $description;
        }

        # get epc_sign hash
        $sign = hash('sha256', implode(':', [
            $params['epc_merchant_id'],
            $params['epc_amount'],
            $params['epc_currency_code'],
            $orderId,
            config('epaycore.sci.password')
        ]));


        return view('paymentsystems.epaycore', compact('sign', 'params'));
    }


}
