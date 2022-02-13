<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::firstOrCreate([
            'email' => 'support@forextion.com',
        ], [
            'name' => 'Forextion',
            'password' => Hash::make('DaudzNaudas123$')
        ]);
    }
}
