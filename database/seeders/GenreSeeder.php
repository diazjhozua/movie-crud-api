<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $movie = \Faker\Factory::create();
        $movie->addProvider(new \Xylis\FakerCinema\Provider\Movie($movie));

        // For genres table
        foreach (range(1,8) as $index) {
	        \DB::table('genres')->insert([
	            'name' => $movie->movieGenre,
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
