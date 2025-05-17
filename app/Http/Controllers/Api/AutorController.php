<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return Autor::with('books')->get();
    }

    public function show($id)
    {
        return Autor::with('books')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $autor = Autor::create($request->only(['name', 'birthdate', 'nationality']));

        if ($request->has('books')) {
            $autor->books()->sync($request->books);
        }

        return response()->json($autor->load('books'), 201);
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);
        $autor->update($request->only(['name', 'birthdate', 'nationality']));

        if ($request->has('books')) {
            $autor->books()->sync($request->books);
        }

        return response()->json($autor->load('books'));
    }

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);
        $autor->books()->detach();
        $autor->delete();

        return response()->noContent();
    }
}
?>
