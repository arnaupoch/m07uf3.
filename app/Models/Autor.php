<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
 
    protected $fillable = ['name', 'birthdate', 'nationality'];
 
    public function book()
    {
        return $this->belongsToMany(book::class, 'books_autores');
    }
}
 