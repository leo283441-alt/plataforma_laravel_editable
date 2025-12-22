<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use Illuminate\Support\Facades\Auth;

class FormularioController extends Controller
{
    // ✅ Mostrar la lista de formularios
   // 🧱 Vista para crear el formulario dinámico
    public function crear()
    {
        // En esta parte solo cargamos la vista (sin estructura todavía)
        return view('crear_formulario', [
            'estructura' => [], // Evita el error de variable indefinida
            'titulo_formulario' => ''
        ]); 
    }

     public function lista()
    {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            // Admin: ve todos los formularios
            $formularios = Formulario::all();
        } else {
            // Usuario normal: solo los que tiene asignados en la tabla pivote
            $formularios = $user->formularios; 
        }

        return view('lista_formularios', compact('formularios'));
    }

    // 💾 Guardar un nuevo formulario dinámico
    public function guardar(Request $request) {
    $request->validate([
        'titulo_formulario' => 'required|string|max:255',
        'estructura_formulario' => 'required|string',
    ]);

    $estructura = json_decode($request->estructura_formulario, true);

    $userId = auth()->id();
    if(!$userId){
        return response()->json([
            'success' => false,
            'message' => 'Debes iniciar sesión para crear un formulario.'
        ], 401);
    }

    // Crear formulario en DB
    Formulario::create([
        'titulo' => $request->titulo_formulario,
        'estructura' => $estructura,
        'user_id' => $userId
    ]);

    return response()->json([
        'success' => true,
        'redirect' => route('formulario.lista')
    ]);
}

    // 🧾 Guardar una respuesta a un formulario existente
    public function guardarRespuesta(Request $request)
    {
        $formId = $request->query('id');
        $formulario = Formulario::findOrFail($formId);

        $nuevoRegistro = [];

        foreach ($formulario->estructura as $campo) {
            $nombreCampo = Str::slug($campo['label'], '_');
            if ($campo['type'] === 'checkbox') {
                $valor = $request->input($nombreCampo, []);
            } else {
                $valor = $request->input($nombreCampo, '');
            }
            $nuevoRegistro[$campo['label']] = $valor;
        }

        Registro::create([
            'formulario_id' => $formulario->id,
            'datos' => $nuevoRegistro
        ]);

        $registros = $formulario->registros;

        return view('formulario_generado', [
            'estructura' => $formulario->estructura,
            'titulo_formulario' => $formulario->titulo,
            'form_id' => $formulario->id,
            'registros' => $registros
        ]);
    }


    // ✅ Editar un formulario
    // Mostrar formulario para editar
public function editar($id)
{
    $formulario = Formulario::findOrFail($id);
    
    $estructura = is_array($formulario->estructura)
    ? $formulario->estructura
    : json_decode($formulario->estructura, true);

    return view('editar_formulario', compact('formulario', 'estructura'));
}

// Guardar cambios (actualizar)
public function actualizar(Request $request, $id)
{
    $formulario = Formulario::findOrFail($id);

    $request->validate([
        'titulo' => 'required|string|max:255',
        'campos' => 'required|array',
    ]);

    $formulario->titulo = $request->titulo;
    $formulario->estructura = json_encode($request->campos);
    $formulario->save();

    return redirect()->route('formulario.lista')->with('success', 'Formulario actualizado correctamente.');
}



    // ✅ Eliminar un formulario
    public function eliminar($id)
    {
        $formulario = Formulario::findOrFail($id);
        $formulario->delete();

        return redirect()->route('formulario.lista')->with('success', 'Formulario eliminado con éxito');
    }
}
