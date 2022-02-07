<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::firstOrCreate([
            'value'	=> 'plan_1',
        ], [
            'name'	=> '5 Day Plan',
            'period_type'	=>	'daily',
            'principal_return'	=> false,
            'affiliate_commission'	=> 5
        ]);

        $plan->periods()->create([
            'period_start'	=>	1,
            'period_end'	=>	10,
            'interest'	=>	12,
        ]);

        $plan->limits()->create([
            'min_amount'	=>	10,
            'max_amount'	=>	1000,
            'currency'	=>	'USD',
        ]);


        $plan->limits()->create([
            'min_amount'	=>	0.05,
            'max_amount'	=>	5.5,
            'currency'	=>	'LTC',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	0.015,
            'max_amount'	=>	1.5,
            'currency'	=>	'BCH',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	30,
            'max_amount'	=>	3000,
            'currency'	=>	'DOGE',
        ]);

        $plan = Plan::firstOrCreate([
         'value'	=> 'plan_15_days',
        ], [
            'name'	=> '15 Day Plan',
            'period_type'	=>	'daily',
            'principal_return'	=> false,
            'affiliate_commission'	=> 4
        ]);

        $plan->periods()->create([
            'period_start'	=>	1,
            'period_end'	=>	20,
            'interest'	=>	5.5,
        ]);


        $plan->limits()->create([
            'min_amount'	=>	10,
            'max_amount'	=>	10000,
            'currency'	=>	'USD',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	0.05,
            'max_amount'	=>	55,
            'currency'	=>	'LTC',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	0.015,
            'max_amount'	=>	15,
            'currency'	=>	'BCH',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	30,
            'max_amount'	=>	30000,
            'currency'	=>	'DOGE',
        ]);


        $plan->limits()->create([
            'min_amount'	=>	0.05,
            'max_amount'	=>	55,
            'currency'	=>	'DASH',
        ]);

        $plan = Plan::firstOrCreate([
            'value'	=> 'plan_30_days',
        ], [
            'name'	=> '30 Day Plan',
            'period_type'	=>	'daily',
            'principal_return'	=> false,
            'affiliate_commission'	=> 5
        ]);


        $plan->periods()->create([
            'period_start'	=>	1,
            'period_end'	=>	30,
            'interest'	=>	6.5,
        ]);


        $plan->limits()->create([
            'min_amount'	=>	10,
            'max_amount'	=>	100000,
            'currency'	=>	'USD',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	0.05,
            'max_amount'	=>	550,
            'currency'	=>	'LTC',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	0.015,
            'max_amount'	=>	150,
            'currency'	=>	'BCH',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	30,
            'max_amount'	=>	300000,
            'currency'	=>	'DOGE',
        ]);

        $plan->limits()->create([
            'min_amount'	=>	0.05,
            'max_amount'	=>	550,
            'currency'	=>	'DASH',
        ]);
    }
}
