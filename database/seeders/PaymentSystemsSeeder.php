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
            'value'				=>	'perfect_money',
        ], [
            'name'				=>	'Perfect Money',
            'process_type'      => 'perfect_money',
            'decimals'			=>	2,
            'currency'			=>	'USD',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.10,
        ]);

        PaymentSystem::firstOrCreate([
            'value'				=>	'epaycore',
        ], [
            'name'				=>	'ePayCore',
            'process_type'      => 'epaycore',
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
            'process_type'      =>  'node',
            'decimals'			=>	8,
            'currency'			=>	'BTC',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.00005,
        ]);

        PaymentSystem::firstOrCreate([
            'value'				=>	'bitcoincash',
        ], [
            'name'				=>	'Bitcoin Cash',
            'process_type'      =>  'node',
            'decimals'			=>	8,
            'currency'			=>	'BCH',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.005,
        ]);

        PaymentSystem::firstOrCreate([
            'value'				=>	'litecoin',
        ], [
            'name'				=>	'Litecoin',
            'process_type'      =>  'node',
            'decimals'			=>	8,
            'currency'			=>	'LTC',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	0.01,
        ]);


        PaymentSystem::firstOrCreate([
            'value'				=>	'dogecoin'
        ], [
            'name'				=>	'Dogecoin',
            'process_type'      =>  'node',
            'decimals'			=>	8,
            'currency'			=>	'DOGE',
            'is_active'			=>	true,
            'payouts_enabled'	=>	true,
            'withdraw_minimum'	=>	5,
        ]);


//        PaymentSystem::firstOrCreate([
//            'value'				=>	'tron_trc20_usdt'
//        ], [
//            'name'				=>	'Tether (TRC20)',
//            'decimals'			=>	6,
//            'currency'			=>	'USDT',
//            'is_active'			=>	true,
//            'payouts_enabled'	=>	true,
//            'withdraw_minimum'	=>	0.01,
//        ]);
    }
}
