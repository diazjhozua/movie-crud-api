<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        \DB::table('certificates')->insert([
            'name' => "U",
            'description' => "Films considered suitable for unrestricted public exhibition",
            'created_at' => $faker->dateTime,
        ]);

        \DB::table('certificates')->insert([
            'name' => "UA",
            'description' => "Films which contain portions considered unsuitable for children below the age of twelve, but otherwise suitable for unrestricted public exhibition",
            'created_at' => $faker->dateTime,
        ]);

        \DB::table('certificates')->insert([
            'name' => "A",
            'description' => "Films considered suitable for exhibition restricted to adults only",
            'created_at' => $faker->dateTime,
        ]);

        \DB::table('certificates')->insert([
            'name' => "S",
            'description' => "Films restricted for exhibition to specialized audience such as doctors etc",
            'created_at' => $faker->dateTime,
        ]);        
    }
}
