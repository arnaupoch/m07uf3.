<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class autores extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('autors')->insert([
                'name' => $faker->firstName(),
                'surname' => $faker->lastName(),
                'birthdate' => $faker->date('Y-m-d', '2000-01-01'),
                'country' => substr($faker->country(), 0, 30),
                'img_url' => $faker->imageUrl(200, 200, 'people'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
