<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        // For roles table
        foreach (range(1,10) as $index) {
	        \DB::table('roles')->insert([
                'name' => $faker->word,
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
