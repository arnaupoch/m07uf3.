<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Autor;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::with('autores')->get();
    }

    public function show($id)
    {
        return Book::with('autores')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $book = Book::create($request->only(['name', 'year', 'gender', 'pages', 'img_url']));

        // Relacionar autores si vienen en el request
        if ($request->has('autores')) {
            $book->autores()->sync($request->autores);
        }

        return response()->json($book->load('autores'), 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->only(['name', 'year', 'gender', 'pages', 'img_url']));

        if ($request->has('autores')) {
            $book->autores()->sync($request->autores);
        }

        return response()->json($book->load('autores'));
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->autores()->detach(); // Limpia relación many-to-many
        $book->delete();

        return response()->noContent();
    }
}

?>

