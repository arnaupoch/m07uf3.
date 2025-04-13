<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function index()
    {
        $autors = Autor::with('books')->get();
        return response()->json($autors);
    }
}
