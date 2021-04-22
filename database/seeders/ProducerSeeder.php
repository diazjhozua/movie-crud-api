<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProducerSeeder extends Seeder
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

        // For producers table
        foreach (range(1,20) as $index) {
	        \DB::table('producers')->insert([
	            'name' => $person->director,
                'email' => $faker->companyEmail,
                'website' => $faker->domainName,
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
