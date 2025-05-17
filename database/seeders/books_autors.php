<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class books_autors extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booksIds = DB::table('books')->pluck('id');
        $autoresIds = DB::table('autors')->pluck('id');
 
        foreach ($booksIds as $booksId) {
            $autoresForFilm = $autoresIds->random(3);
            foreach ($autoresForFilm as $autoresId) {
                DB::table('books_autors')->insert([
                    'book_id' => $booksId,
                    'autor_id' => $autoresId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}