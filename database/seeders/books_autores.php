<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class books_autores extends Seeder
{



    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booksIds = DB::table('books')->pluck('id');
        $autoresIds = DB::table('autores')->pluck('id');
 
        foreach ($booksIds as $booksId) {
            $autoresForFilm = $autoresIds->random(3);
            foreach ($autoresForFilm as $autoresId) {
                DB::table('books_autores')->insert([
                    'books_id' => $booksId,
                    'autores_id' => $autoresId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}