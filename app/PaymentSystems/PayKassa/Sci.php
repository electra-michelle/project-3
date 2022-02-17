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
        $this->config = config('paykassa.sci');

        $this->client = new Client([
            'base_uri' => 'https://paykassa.app/sci/0.4/index.php',
        ]);
    }
	
	/**
     * @return array
     */
    private function defaultRequestData()
    {
        return [
            'sci_id' => (int)$this->config['id'],
            'sci_key' => $this->config['password'],
			'test' => config('paykassa.test')
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
            ($method == 'GET' ? 'query' : 'form_params') => $data,
             'headers' => [
                 'Content-type' => 'application/x-www-form-urlencoded',
            ]
        ];
		
        $response = $this->client->request($method, $uri, $requestOptions);

        return json_decode($response->getBody()->__toString());
    }
	
	public function getCryptoAddress($orderId, $amount, $currency)
	{
		try {
			$result = $this->makeRequest('', [
				'func' => 'sci_create_order_get_data',
				'order_id' => $orderId,
				'amount' => $amount,
				'currency' => $currency,
				'system' => 30,
				'comment' => $this->config['description'] . ' #' . $orderId,
				'phone' => false,
				'paid_commission' => '',
			]);
			
			if($result->error) {
				return false;
			}
			return $result->data->wallet;
		} catch (\Exception $exception) {
			return false;
		}

	}
	
	public function checkPayment($hash)
	{
		try {
			$result = $this->makeRequest('', [
				'func' => 'sci_confirm_order',
				'private_hash' => $hash
			]);

			//dd($result);
			if($result->error) {
				return false;
			}
			
			return $result->data;
		} catch (\Exception $exception) {
			 return false;
		}
		
	}

}
