<?php
// app/http/controller (capa 5) controlador
// app/http/controllers/bookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class bookController extends Controller
{
    /**
     * Read books from storage and database
     */
    public static function readbooks(): array
    {
        // Libros desde JSON
        $booksFromJson = Storage::exists('public/books.json')
            ? Storage::json('public/books.json')
            : [];

        // Libros desde base de datos usando Eloquent
        $booksFromDB = Book::all()->map(function ($book) {
            return $book->toArray(); // convierte el modelo Eloquent a array
        })->toArray();

        // Mezcla ambos orígenes
        return array_merge($booksFromJson, $booksFromDB);
    }

    public function listOldbooks($year = 2000)
    {
        $books = Book::where('year', '<', $year)->get();

        return view('books.list', [
            'title' => "Listado de libros antiguos (Antes de $year)",
            'films' => $books
        ]);
    }

    public function listNewbooks($year = 2000)
    {
        $books = Book::where('year', '>=', $year)->get();

        return view('books.list', [
            'title' => "Listado de libros nuevos (Después de $year)",
            'films' => $books
        ]);
    }

    public function listbooks($year = null, $gender = null)
    {
        $books_filtered = [];
        $title = "Listado de todos los libros";
        $books = bookController::readbooks();

        if (is_null($year) && is_null($gender)) {
            return view('books.list', ["books" => $books, "title" => $title]);
        }

        foreach ($books as $book) {
            $yearMatch = is_null($year) || $book['year'] == $year;
            $genderMatch = is_null($gender) || strtolower($book['gender']) == strtolower($gender);

            if ($yearMatch && $genderMatch) {
                $books_filtered[] = $book;
            }
        }

        return view("books.list", ["books" => $books_filtered, "title" => $title]);
    }

    public function listByYear($year)
    {
        $books = array_filter(bookController::readbooks(), function ($book) use ($year) {
            return $book['year'] == $year;
        });

        return view("books.list", [
            "books" => $books,
            "title" => "Listado de todos los libros filtrado por año"
        ]);
    }

    public function listByGender($gender = null)
    {
        $books = is_null($gender)
            ? bookController::readbooks()
            : array_filter(bookController::readbooks(), function ($book) use ($gender) {
                return strtolower($book['gender']) == strtolower($gender);
            });

        $title = is_null($gender) ? "Listado de todos los libros" : "Listado filtrado por categoría";

        return view("books.list", [
            "books" => $books,
            "title" => $title
        ]);
    }

    public function sortByYear()
    {
        $books = bookController::readbooks();

        usort($books, fn($a, $b) => $a['year'] <=> $b['year']);

        return view('books.list', [
            "books" => $books,
            "title" => "Listado ordenado por año"
        ]);
    }

    public function countbooks()
    {
        $count = count(bookController::readbooks());

        return view('books.count', [
            "books" => $count,
            "title" => "Número de libros"
        ]);
    }

    public function getbooksFromJson()
    {
        $path = storage_path('app/public/books.json');

        if (!file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        return json_decode($content, true) ?: [];
    }

    private function savebooksToJson($books)
    {
        $jsonContent = json_encode($books, JSON_PRETTY_PRINT);
        Storage::disk('public')->put('books.json', $jsonContent);
    }

    public function checkAndAddbooks(Request $request)
    {
        $booksName = $request->input('name');

        if ($this->isbooks($booksName)) {
            return redirect('/')->with('error', 'El libro ya existe.');
        }

        $this->addbook($request);
        return $this->listFilteredbooks();
    }

    public function isbooks($booksName)
    {
        foreach ($this->getbooksFromJson() as $book) {
            if ($book['name'] === $booksName) {
                return true;
            }
        }
        return false;
    }

    private function addbook(Request $request)
    {
        $books = $this->getbooksFromJson();

        $newbook = [
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'gender' => $request->input('gender'),
            'author' => $request->input('author'),
            'pages' => $request->input('pages'),
            'img_url' => $request->input('url_image'),
        ];

        $books[] = $newbook;
        $this->savebooksToJson($books);
    }

    public function listFilteredbooks($year = null, $gender = null)
    {
        $books = $this->getbooksFromJson();

        $filtered = array_filter($books, function ($book) use ($year, $gender) {
            $yearMatch = is_null($year) || $book['year'] == $year;
            $genderMatch = is_null($gender) || strtolower($book['gender']) == strtolower($gender);
            return $yearMatch && $genderMatch;
        });

        return view("books.list", [
            "books" => $filtered,
            "title" => "Listado de todos los libros:"
        ]);
    }
}
?>

