<?php
// app/http/controller (capa 5) controlador
// app/http/controllers/bookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class bookController extends Controller
{
    public function index()
    {
        $books = Book::with('autors')->get();
        return response()->json($books);
    }
}
?>

