<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $person = \Faker\Factory::create(); 
        $person->addProvider(new \Xylis\FakerCinema\Provider\Person($person));
        
        // For actors table
        foreach (range(1,20) as $index) {
	        \DB::table('actors')->insert([
                'name' => $person->actor,
                'city' => $faker->city,
                'email' => $faker->email,
                'website' => $faker->domainName,
                'background' => $faker->paragraph,
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
