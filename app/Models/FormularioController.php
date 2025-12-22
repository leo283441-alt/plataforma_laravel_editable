<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormularioController extends Controller
{
    // 🔹 Lista de todos los formularios
    public function lista()
    {
        $formularios = Formulario::all();
        return view('lista_formularios', compact('formularios'));
    }

    public function crear()
    {
        return view('crear_formulario'); // ahora la plantilla se encarga de mostrar campos dinámicos
    }



    // 🔹 Guardar formulario o respuestas
    public function guardar(Request $request)
{
    $titulo = $request->input('titulo_formulario');
    $estructura = $request->input('estructura_formulario');

    Formulario::create([
        'titulo' => $titulo,
        'estructura' => json_decode($estructura, true)
    ]);

    return response()->json(['success' => true]);
}


    // 🔹 Mostrar formulario existente con registros
    public function ver($id)
    {
        $formulario = Formulario::findOrFail($id);
        $registros = $formulario->registros()->get();

        return view('crear_formulario', [
            'estructura' => $formulario->estructura,
            'titulo_formulario' => $formulario->titulo,
            'form_id' => $formulario->id,
            'registros' => $registros,
        ]);
    }
}
