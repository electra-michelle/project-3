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
	
	/**
     * @return array
     */
    private function defaultRequestData()
    {
        return [
            'api_id' => (int)$this->config['id'],
            'api_key' => $this->config['password']
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
	
	public function getBalance($currency = null)
	{
		$balance = $this->makeRequest('', [
			'func' => 'api_get_shop_balance',
			'shop' => config('paykassa.sci.id')
		]);
		
		if(!$balance->error) {
			return $currency ? ($balance->data->{$currency} ?? 0) : $balance->data;
		}
		
		return 0;
	}
	
	public function statusCheck()
	{
		$balance = $this->makeRequest('', [
			'func' => 'api_get_shop_balance',
			'shop' => config('paykassa.sci.id')
		]);
		
		if($balance->error) {
			return [
				'error' => true,
				'message' => $balance->message
			];
		}
		
		return ['error' => false];
	}

}
