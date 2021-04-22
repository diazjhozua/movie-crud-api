<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FilmActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $character = \Faker\Factory::create(); 
        $character->addProvider(new \Xylis\FakerCinema\Provider\Character($character));
        // For filmactors table
        foreach (range(1,30) as $index) {
	        \DB::table('film_actors')->insert([
                'movie_id' => $faker->numberBetween(1,20),
                'actor_id' => $faker->numberBetween(1,20),
                'role_id' => $faker->numberBetween(1,10),
                'name' => $character->character,
                'description' => $faker->paragraph,
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
