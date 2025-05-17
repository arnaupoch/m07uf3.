<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de la API. Laravel las carga automáticamente
| mediante RouteServiceProvider bajo el grupo "api".
|
*/

// Ruta para obtener el usuario autenticado si usas auth:sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// CRUD completo para libros (books)
Route::apiResource('books', BookController::class);

// CRUD completo para autores (autores)
Route::apiResource('autores', AutorController::class);
