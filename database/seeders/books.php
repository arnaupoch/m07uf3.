<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class books extends Seeder
{
     /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // $gender = ["Acción", "Ciencia ficción", "Drama", "Comedia", "Terror", "Romance, infantil", "Fantasía", "Misterio", "Documental", "Animación"];


        for ($i = 0; $i < 10; $i++) {
            DB::table('books')->insert([
                'id'         => $i + 1,
                'name'       => $faker->unique()->sentence(3),
                'year'       => $faker->numberBetween(1980, 2024),
                // 'genre'      => $faker->randomElement($gender),
                'gender'      => $faker->name(),
                'author'     => $faker->name(),
                'pages'      => $faker->numberBetween(100, 500),
                'img_url'    => $faker->imageUrl(640, 480, 'movies'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
