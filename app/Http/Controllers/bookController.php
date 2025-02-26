<?php
// app/http/controller (capa 5) controlador
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class bookController extends Controller
{

    /**
     * Read books from storage
     */
    public static function readbooks(): array
    {
        $books = Storage::json('/public/books.json');
        return $books;
    }
    /**
     * List book older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldbooks($year = null)
    {
        $old_books = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de libros Antiguas (Antes de $year)";
        $books = bookController::readbooks();

        foreach ($books as $book) {
            //foreach ($this->datasource as $book) {
            if ($book['year'] < $year)
                $old_books[] = $book;
        }
        return view('books.list', ["books" => $old_books, "title" => $title]);
    }
    /**
     * List books younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewbooks($year = null)
    {
        $new_books = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de libros Nuevas (Después de $year)";
        $books = bookController::readbooks();

        foreach ($books as $book) {
            if ($book['year'] >= $year)
                $new_books[] = $book;
        }
        return view('books.list', ["books" => $new_books, "title" => $title]);
    }
    /**
     * Lista TODAS los libros o filtra x año o categoría. 
     */
    public function listbooks($year = null, $genre = null)
    {
        $books_filtered = [];

        $title = "Listado de todas los libros";
        $books = bookController::readbooks();

        //if year and genre are null
        if (is_null($year) && is_null($genre))
            return view('books.list', ["books" => $books, "title" => $title]);

        //list based on year or genre informed
        foreach ($books as $book) {
            if ((!is_null($year) && is_null($genre)) && $book['year'] == $year) {
                $title = "Listado de todos los libros filtrado x año";
                $books_filtered[] = $book;
            } else if ((is_null($year) && !is_null($genre)) && strtolower($book['genre']) == strtolower($genre)) {
                $title = "Listado de todos los libros filtrado x categoria";
                $books_filtered[] = $book;
            } else if (!is_null($year) && !is_null($genre) && strtolower($book['genre']) == strtolower($genre) && $book['year'] == $year) {
                $title = "Listado de todos los libros filtrado x categoria y año";
                $books_filtered[] = $book;
            }
        }
        return view("books.list", ["books" => $books_filtered, "title" => $title]);
    }

    public function listByYear($year)
    {
        $books_filtered = [];

        $title = "Listado de todos los por año";
        $books = bookController::readbooks();

        if (is_null($year))
            return view('books.list', ["books" => $books, "title" => $title]);
        //list based on year or genre informed
        foreach ($books as $book) {
            if (!is_null($year) && $book['year'] == $year) {
                $title = "Listado de todos los libros filtrado x año";
                $books_filtered[] = $book;
            }
        }

        return view("books.list", ["books" => $books_filtered, "title" => $title]);
    }

    public function listByGenre($genre = null)
    {
        $books_filtered = [];

        $title = "Listado de todas los libros";
        $books = bookController::readbooks();

        //if year and genre are null
        if (is_null($genre))
            return view('books.list', ["books" => $books, "title" => $title]);

        //list based on year or genre informed 
        foreach ($books as $book) {
            if ((!is_null($genre)) && strtolower($book['genre']) == strtolower($genre)) {
                $title = "Listado de todos los libros filtrado x categoria";
                $books_filtered[] = $book;
            }
        }
        return view("books.list", ["books" => $books_filtered, "title" => $title]);
    }

    public function sortByYear()
    {
        $title = "Listado ordenado por año";

        $books = bookController::readbooks();

        // Sort books by year using usort
        usort($books, function ($a, $b) {
            return $a['year'] - $b['year'];
        });

        return view('books.list', ["books" => $books, "title" => $title]);
    }

    public function countbooks()
    {

        $title = "Number of movies";
        $books = bookController::readbooks();

        $books = count($books);


        return view('books.count', ["books" => $books, "title" => $title]);
    }

    public function getbooksFromJson()
    {
        $path = storage_path('app/public/books.json');

        if (!file_exists($path)) {
            return []; // Return an empty array or handle the missing file case as needed
        }

        $content = file_get_contents($path);
        $books = json_decode($content, true);

        return $books ?: []; // Return decoded books or an empty array if decoding fails
    }

    private function savebooksToJson($books)
    {
        $jsonContent = json_encode($books, JSON_PRETTY_PRINT);
        $filePath = storage_path('app/public/books.json');

        // Write the JSON content to the file
        if ($filePath !== false) {
            Storage::disk('public')->put('books.json', $jsonContent);
        }
    }

    public function checkAndAddbooks(Request $request)
    {
        $booksName = $request->input('name');

        if ($this->isbooks($booksName)) {
            return redirect('/')->with('error', 'book already exists.');
        } else {
            // Add the book if it doesn't exist
            $this->addbook($request);
            return $this->listFilteredbooks();
        }
    }

    public function isbooks($booksName)
    {
        $books = $this->getbooksFromJson();
        foreach ($books as $book) {
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
            'genre' => $request->input('genre'),
            'author' => $request->input('author'),
            'pages' => $request->input('pages'),
            'img_url' => $request->input('url_image'), // renaming 'url_image' to 'img_url'
        ];

        $books[] = $newbook;
        $this->savebooksToJson($books);

    }

    public function listFilteredbooks($year = null, $genre = null)
{
    $books_filtered = [];
    $title = "Listado de todos los libros:";
    $books = $this->getbooksFromJson();

    // If both year and genre are null, return all books
    if (is_null($year) && is_null($genre)) {
        return view("books.list", ["books" => $books, "title" => $title]);
    }

    // Filter books based on year or genre
    foreach ($books as $book) {
        $yearMatches = is_null($year) || $book['year'] == $year;
        $genreMatches = is_null($genre) || strtolower($book['genre']) == strtolower($genre);

        if ($yearMatches && $genreMatches) {
            $books_filtered[] = $book;
        }
    }

    return view("books.list", ["books" => $books_filtered, "title" => $title]);
}
 
}
