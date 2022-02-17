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
		
		$systemId = [
			"perfectmoney" => 2, // supported currencies USD    
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
		
		try {
			$balance = $this->makeRequest('', [
				'func' => 'api_payment',
				'shop' => config('paykassa.sci.id'),
				'amount'   => $amount,
				'currency' => $currency,
				'system' => $systemId[$paymentSystemValue],
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
