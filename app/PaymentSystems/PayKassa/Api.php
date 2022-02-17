<?php

namespace App\PaymentSystems\PayKassa;

use GuzzleHttp\Client;

class Api extends BasePayKassa  implements PayKassaInterface
{
    public $version = "0.5";

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
    public function defaultRequestData() : array
    {
        return [
            'api_id' => (int)$this->config['id'],
            'api_key' => $this->config['password']
        ];
    }


    public function getBalance($currency = null)
    {
        $balance = $this->makeRequest('', [
            'func' => 'api_get_shop_balance',
            'shop' => config('paykassa.sci.id')
        ]);

        if (!$balance->error) {
            return $currency ? ($balance->data->{$currency} ?? 0) : $balance->data;
        }

        return 0;
    }

    public function statusCheck()
    {
        try {
            $balance = $this->makeRequest('', [
                'func' => 'api_get_shop_balance',
                'shop' => config('paykassa.sci.id')
            ]);

            if ($balance->error) {
                return [
                    'error' => true,
                    'message' => $balance->message
                ];
            }

            return ['error' => false];
        } catch (\Exception $exception) {
            return json_decode(json_encode(['error' => $exception->getMessage()]));
        }
    }


	public function send($wallet, $amount, $currency, $paymentSystemValue, $data = [])
	{

		try {
			$balance = $this->makeRequest('', [
				'func' => 'api_payment',
				'shop' => config('paykassa.sci.id'),
				'amount'   => $amount,
				'currency' => $currency,
				'system' => $this->paymentSystemMappings($paymentSystemValue),
				'paid_commission' => $data['commission'] ?? '',
				'number' => $wallet,
				'tag' => $data['tag'] ?? '',
				'priority' =>  $data['priority'] ?? '',
			]);

			if($balance->error) {
				return [
					'error' => true,
					'message' => $balance->message
				];
			}

			return ['error' => false];
		} catch (\Exception $exception) {
			return json_decode(json_encode(['error' => $exception->getMessage()]));
		}
	}


}
