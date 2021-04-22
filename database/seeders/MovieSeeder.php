<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
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

        // For movies table
        foreach (range(1,20) as $index) {
	        \DB::table('movies')->insert([
	            'genre_id' => $faker->numberBetween(1,8),
                'certificate_id' => $faker->numberBetween(1,4),
                'title' => $movie->movie,
                'studio' => $movie->studio,
                'saga' => $movie->saga,
                'duration' => $movie->runtime,
                'background' => $movie->overview,
                'created_at' => $faker->dateTime,
	        ]);
        }

    }
}
