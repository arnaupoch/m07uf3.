<?php

use App\Http\Controllers\bookController;
use App\Http\Controllers\AutorController;
use App\Http\Middleware\ValidateYear;
use Illuminate\Support\Facades\Route;
// routes/web.php (capa 3)rutas
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('year')->group(function () {
    Route::group(['prefix' => 'bookout'], function () {
        // Routes included with prefix "bookout"
        // book y books
        Route::get('oldbooks/{year?}', [bookController::class, "listOldbooks"])->name('oldbooks');
        Route::get('newbooks/{year?}', [bookController::class, "listNewbooks"])->name('newbooks');
        Route::get('booksByYear/{year?}', [bookController::class, "listByYear"])->name('listbooksByYear');
        Route::get('booksByGenre/{genre?}', [bookController::class, "listByGenre"])->name('listbooksByGenre');
        Route::get('sortbooks', [bookController::class, "sortByYear"])->name('sortByYear');
        Route::get('countbooks', [bookController::class, "countbooks"])->name('listCount');
        Route::get('allbooks', [bookController::class, "listbooks"])->name('listbooks');
        // autor y autores
        Route::get('countautores', [AutorController::class, "countautores"])->name('countautores');
        Route::get('listautores', [AutorController::class, "listautores"])->name('listautors');
        Route::get('deliteautores', [AutorController::class, "deliteautores"])->name('deliteautores');
        Route::get('decadaautores', [AutorController::class, "decadaautores"])->name('decadaautores');
        Route::get('destroy', [AutorController::class, "destroy"])->name('destroyAutor');
        Route::post('/autores/destroy', [AutorController::class, 'destroy'])->name('destroyAutor');

    });
});

Route::prefix('bookin')->group(function () {
    Route::post('/createbook', [bookController::class, 'checkAndAddbooks'])
        ->name('createbook')
        ->middleware('validateUrl');
        
});

