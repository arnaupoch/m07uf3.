<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class AutorController extends Controller
{
    public function listautores()
    {
        $autores = DB::table('autores')->get();
        $title = "Listado de autores";
        return view('autores.list', compact('autores', 'title'));

    }
    public function countautores()
    {

        $title = "Number of autores";
        $autores = DB::table('autores')->count();


        return view('autores.count', ["autores" => $autores, "title" => $title]);
    }
    public function deliteautores()
    {
        // Obtener todos los autores
        $autores = DB::table('autores')->get();
        $title = "Eliminar Autores";
    
        // Generar el formulario y la lista de autores
        $html = "<h1>$title</h1>";
    
        // Mostrar mensajes de éxito o error si existen
        if (session('success')) {
            $html .= '<p style="color: green;">' . session('success') . '</p>';
        }
        if (session('error')) {
            $html .= '<p style="color: red;">' . session('error') . '</p>';
        }
    
        $html .= '<form action="' . route('destroyAutor') . '" method="POST">';
        $html .= csrf_field(); // Protección CSRF
        $html .= '<label for="id">ID del Autor a Eliminar:</label>';
        $html .= '<input type="number" name="id" required>';
        $html .= '<button type="submit">Eliminar</button>';
        $html .= '</form>';
    
        // Mostrar la lista de autores actuales
        if ($autores->isEmpty()) 
        {
            $html .= "<p>No hay autores registrados.</p>";
        }
        else 
        {
            $html .= "<ul>";
            foreach ($autores as $autor)
            {
                $html .= "<li>{$autor->id} - {$autor->name} ({$autor->birthdate})</li>";
            }
            $html .= "</ul>";
        }
    
        return $html;
    }
    
    public function destroy(Request $request)
    {
        $id = $request->input('id');
    
        // Verificar si el autor existe antes de eliminarlo
        $autor = DB::table('autores')->where('id', $id)->first();
    
        if (!$autor) {
            return redirect()->route('deliteautores')->with('error', 'Autor no encontrado.');
        }
    
        // Intentar eliminar el autor
        DB::table('autores')->where('id', $id)->delete();
    
        // Redirigir de nuevo a la vista con un mensaje de éxito
        return redirect()->route('deliteautores')->with('success', 'Autor eliminado correctamente.');
    }


    public function decadaautores(Request $request)
    {
        // Obtener el año seleccionado en el formulario
        $year = $request->query('year');
        // Inicializar lista de autores vacía
        $autores = [];
        $title = "Selecciona una década para ver los autores";
        // Validar si el año es correcto
        if ($year && is_numeric($year)) {
            $title = "Autores nacidos entre $year y " . ($year + 9);
            // Verificar si la columna birthdate es de tipo DATE o STRING
            $autores = DB::table('autores')
                ->whereYear('birthdate', '>=', $year)
                ->whereYear('birthdate', '<=', $year + 9)
                ->get();
        }
        // Mostrar mensaje si la consulta no trae resultados
        if (empty($autores) || count($autores) == 0) {
            $message = "<p style='color: red;'>No hay autores en esta década.</p>";
        } else {
            $message = "<ul>";
            foreach ($autores as $autor) {
                $message .= "<li>{$autor->name} ({$autor->birthdate})</li>";
            }
            $message .= "</ul>";
        }
        // Generar el formulario con el select de décadas y los resultados como una cadena HTML
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

        // Agregar resultados
        $html .= $message;
        // Retornar la vista con el contenido HTML generado
        return $html;
    }
}
