<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        // For users table
        foreach (range(1,20) as $index) {
	        \DB::table('users')->insert([
                'name' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => $faker->companyEmail,
                'password' => Hash::make($faker->password),
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
