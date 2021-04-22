<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            CertificateSeeder::class,
            RoleSeeder::class,
            ProducerSeeder::class,
            ActorSeeder::class,
            MovieSeeder::class,
            FeedBackSeeder::class,
            FilmActorSeeder::class,
            FilmProducerSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // $faker = \Faker\Factory::create(); // for normal faker data
        // $movie = \Faker\Factory::create();
        // $movie->addProvider(new \Xylis\FakerCinema\Provider\Movie($movie)); //for movie data
        // $network = \Faker\Factory::create();
        // $network->addProvider(new \Xylis\FakerCinema\Provider\TvShow($network)); // for certificate data
        // $person = \Faker\Factory::create(); 
        // $person->addProvider(new \Xylis\FakerCinema\Provider\Person($person)); // for actor/producer/director name
        // $character = \Faker\Factory::create(); 
        // $character->addProvider(new \Xylis\FakerCinema\Provider\Character($character)); // for character name

        // $picture = \Faker\Factory::create();
        // $picture->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($picture));

        // // For users table
        // foreach (range(1,20) as $index) {
	    //     \DB::table('users')->insert([
        //         'name' => $faker->name,
        //         'email' => $faker->companyEmail,
        //         'password' => Hash::make($faker->password),
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // // For genres table
        // foreach (range(1,10) as $index) {
	    //     \DB::table('genres')->insert([
	    //         'name' => $movie->movieGenre,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // // For certificates table
        // foreach (range(1,10) as $index) {
	    //     \DB::table('certificates')->insert([
	    //         'name' => $network->tvNetwork,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // // For roles table
        // foreach (range(1,10) as $index) {
	    //     \DB::table('roles')->insert([
        //         'name' => $faker->word,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // // For producers table
        // foreach (range(1,20) as $index) {
	    //     \DB::table('producers')->insert([
	    //         'name' => $person->director,
        //         'email' => $faker->lastName,
        //         'website' => $faker->companyEmail,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // For actors table
        // foreach (range(1,20) as $index) {
	    //     \DB::table('actors')->insert([
        //         'name' => $person->actor,
        //         'city' => $faker->city,
        //         'email' => $faker->email,
        //         'website' => $faker->domainName,
        //         'background' => $faker->paragraph,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // // For movies table
        // foreach (range(1,20) as $index) {
	    //     \DB::table('movies')->insert([
	    //         'genre_id' => $faker->numberBetween(1,10),
        //         'certificate_id' => $faker->numberBetween(1,10),
        //         'title' => $movie->movie,
        //         'studio' => $movie->studio,
        //         'saga' => $movie->saga,
        //         'duration' => $movie->runtime,
        //         'background' => $movie->overview,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // For feedbacks table
        // foreach (range(1,5) as $index) {
	    //     \DB::table('feedbacks')->insert([
        //         'user_id' => $faker->numberBetween(1,20),
        //         'movie_id' => $faker->numberBetween(1,20),
        //         'comment' => $faker->paragraph,
        //         'score' => $faker->numberBetween(3,5),
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }

        // For filmactors table
        // foreach (range(1,30) as $index) {
	    //     \DB::table('film_actors')->insert([
        //         'movie_id' => $faker->numberBetween(1,20),
        //         'actor_id' => $faker->numberBetween(1,20),
        //         'role_id' => $faker->numberBetween(1,10),
        //         'name' => $character->character,
        //         'description' => $faker->paragraph,
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }
        
        // // For filmproducers table
        // foreach (range(1,30) as $index) {
	    //     \DB::table('film_producers')->insert([
        //         'producer_id' => $faker->numberBetween(1,20),
        //         'movie_id' => $faker->numberBetween(1,20),
        //         'created_at' => $faker->dateTime,
	    //     ]);
        // }
    }
}
