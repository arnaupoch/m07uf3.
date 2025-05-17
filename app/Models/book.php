<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Book extends Model
{
    use HasFactory;
 
    protected $fillable = ['name', 'year', 'gender', 'athor', 'pages', 'img_url'];

public function Autores()
    {
        return $this->belongsToMany(Autor::class, 'books_autores');
    }
}
?>