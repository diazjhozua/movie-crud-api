<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FeedBackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        // For feedbacks table
        foreach (range(1,5) as $index) {
	        \DB::table('feedbacks')->insert([
                'user_id' => $faker->numberBetween(1,20),
                'movie_id' => $faker->numberBetween(1,20),
                'comment' => $faker->paragraph,
                'score' => $faker->numberBetween(3,5),
                'created_at' => $faker->dateTime,
	        ]);
        }
    }
}
