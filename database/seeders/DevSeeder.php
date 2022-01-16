<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

//        $this->call([
//            AdminsTableSeeder::class,
//            PaymentSystemsSeeder::class
//        ]);
        \App\Models\Message::factory(50)->create();
    }
}
