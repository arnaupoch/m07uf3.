<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function listautores()
    {
        $autores = Autor::all();
        return view('autores.list', [
            'autores' => $autores,
            'title' => 'Listado de todos los autores'
        ]);
    }

    public function countautores()
    {
        $autoresCount = Autor::count();
        return view('autores.count', compact('autoresCount'));
    }

    public function deliteautores()
    {
        $autores = Autor::all();
        $title = "Eliminar Autores";

        $html = "<h1>$title</h1>";

        if (session('success')) {
            $html .= '<p style="color: green;">' . session('success') . '</p>';
        }
        if (session('error')) {
            $html .= '<p style="color: red;">' . session('error') . '</p>';
        }

        $html .= '<form action="' . route('destroyAutor') . '" method="POST">';
        $html .= csrf_field();
        $html .= '<label for="id">ID del Autor a Eliminar:</label>';
        $html .= '<input type="number" name="id" required>';
        $html .= '<button type="submit">Eliminar</button>';
        $html .= '</form>';

        if ($autores->isEmpty()) {
            $html .= "<p>No hay autores registrados.</p>";
        } else {
            $html .= "<ul>";
            foreach ($autores as $autor) {
                $html .= "<li>{$autor->id} - {$autor->name} ({$autor->birthdate})</li>";
            }
            $html .= "</ul>";
        }

        return $html;
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $autor = Autor::find($id);

        if (!$autor) {
            return redirect()->route('deliteautores')->with('error', 'Autor no encontrado.');
        }

        $autor->delete();

        return redirect()->route('deliteautores')->with('success', 'Autor eliminado correctamente.');
    }

    public function decadaautores(Request $request)
    {
        $year = $request->query('year');
        $autores = collect();
        $title = "Selecciona una década para ver los autores";

        if ($year && is_numeric($year)) {
            $title = "Autores nacidos entre $year y " . ($year + 9);
            $autores = Autor::whereYear('birthdate', '>=', $year)
                           ->whereYear('birthdate', '<=', $year + 9)
                           ->get();
        }

        if ($autores->isEmpty()) {
            $message = "<p style='color: red;'>No hay autores en esta década.</p>";
        } else {
            $message = "<ul>";
            foreach ($autores as $autor) {
                $message .= "<li>{$autor->name} ({$autor->birthdate})</li>";
            }
            $message .= "</ul>";
        }

        $html = "<h1>$title</h1>";

        $html .= '<form action="' . route('decadaautores') . '" method="GET">';
        $html .= '<label for="year">Selecciona una década:</label>';
        $html .= '<select name="year" id="year">';
        $html .= '<option value="">-- Selecciona una década --</option>';

        for ($i = 1900; $i <= date('Y'); $i += 10) {
            $selected = ($year == $i) ? 'selected' : '';
            $html .= "<option value=\"$i\" $selected>$i - " . ($i + 9) . "</option>";
        }

        $html .= '</select>';
        $html .= '<button type="submit">Buscar</button>';
        $html .= '</form>';

        $html .= $message;

        return $html;
    }
}
