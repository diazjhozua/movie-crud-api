<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FilmProducerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $typeList = array('Executive producer', 'Line producer', 'Supervising producer', 'Producer', 'Co-producer', 'Coordinating producer', 'Production coordinator', 'Associate producer', 'Segment producer', 'Field producer');

        // For filmproducers table
        foreach (range(1,30) as $index) {
            $k = array_rand($typeList);
            $type = $typeList[$k];
	        \DB::table('film_producers')->insert([
                'producer_id' => $faker->numberBetween(1,20),
                'movie_id' => $faker->numberBetween(1,20),
                'type' => $type,
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
