<?php

namespace App\PaymentSystems\PayKassa;

use GuzzleHttp\Client;

class Sci extends BasePayKassa  implements PayKassaInterface
{
    public $version = "0.4";

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
    public function defaultRequestData() : array
    {
        return [
            'sci_id' => (int)$this->config['id'],
            'sci_key' => $this->config['password'],
            'test' => config('paykassa.test')
        ];
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

            if ($result->error) {
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
            if ($result->error) {
                return false;
            }

            return $result->data;
        } catch (\Exception $exception) {
            return false;
        }

    }

}
