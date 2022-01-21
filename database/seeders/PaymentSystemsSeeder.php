<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSystem;

class PaymentSystemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PaymentSystem::firstOrCreate([
            'value'				=>	'epaycore',
        ], [
            'name'				=>	'ePayCore',
            'decimals'			=>	2,
            'currency'			=>	'USD',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.10,
        ]);

        PaymentSystem::firstOrCreate([
            'value'				=>	'bitcoin',
        ], [
            'name'				=>	'Bitcoin',
            'decimals'			=>	8,
            'currency'			=>	'BTC',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.0001,
        ]);

        PaymentSystem::firstOrCreate([
            'value'				=>	'bitcoincash',
        ], [
            'name'				=>	'Bitcoin Cash',
            'decimals'			=>	8,
            'currency'			=>	'BCH',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.0001,
        ]);

        PaymentSystem::firstOrCreate([
            'value'				=>	'litecoin',
        ], [
            'name'				=>	'Litecoin',
            'decimals'			=>	8,
            'currency'			=>	'LTC',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.001,
        ]);


        PaymentSystem::firstOrCreate([
            'value'				=>	'dogecoin'
        ], [
            'name'				=>	'Dogecoin',
            'decimals'			=>	8,
            'currency'			=>	'DOGE',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	10,
        ]);
    }
}