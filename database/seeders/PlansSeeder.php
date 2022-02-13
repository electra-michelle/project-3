<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use function Composer\Autoload\includeFile;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $planDefaults = include(database_path('/defaults/plans.php'));
        foreach($planDefaults as $planValue => $planData) {
            $plan = Plan::firstOrCreate([
                'value'	=> $planValue,
            ], Arr::except($planData, ['periods', 'limits']));

            foreach($planData['periods'] as $periodData) {
                $plan->periods()->firstOrCreate([], $periodData);
            }

            foreach ($planData['limits'] as $limitCurrency => $limitData)
            {
                $plan->limits()->firstOrCreate([
                    'currency'	=>	$limitCurrency,
                ], $limitData);
            }
        }

    }
}
