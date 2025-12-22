<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaginaEditable;
use Illuminate\Support\Str;

class PaginaController extends Controller
{
    public function index()
    {
        $paginas = PaginaEditable::all();
        return view('lista_paginas', compact('paginas'));
    }

    public function create()
    {
        return view('crear_pagina');
    }

    public function store(Request $request)
    {
        // Validación simple
        $request->validate([
            'nombre' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
        ]);

        // Crear nueva página
        $pagina = new PaginaEditable();
        $pagina->nombre = $request->nombre;
        $pagina->titulo = $request->titulo;
        $pagina->slug = Str::slug($request->nombre); // genera slug automático
        $pagina->contenido_html = '';
        $pagina->save();

        return redirect()->route('lista_paginas')->with('success', 'Página creada correctamente.');
    }

    public function edit($id)
    {
        // usar el modelo correcto (PaginaEditable)
        $pagina = PaginaEditable::findOrFail($id);
        return view('editar_pagina', compact('pagina'));
    }

    public function update(Request $request, $id)
    {
        // corregido: findOrFail estaba mal escrito
        $pagina = PaginaEditable::findOrFail($id);
        $pagina->contenido_html = $request->contenido_html;
        $pagina->save();

        return redirect()->route('paginas.edit', $pagina->id)
            ->with('success', 'Cambios guardados correctamente.');
    }

    // 🔹 NUEVO: Mostrar el home dinámico
    public function home()
    {
       //busca la pagina 'home' o la crea con valores por defecto si no existe
       $pagina = PaginaEditable::FirstOrCreate(
            ['slug' => 'home'],
            [
                'nombre' => 'home',
                'titulo' => 'Inicio',
                'color_fondo' => '#ffffff',
                'color_texto' => '#000000',
                'contenido_html' => ''
            ]
            );
            return view('home', compact('pagina'));
    }


    // 🔹 NUEVO: Página de edición del home
    public function editarHome()
    {
        // usa firstOrFail para asegurarse de que la pagina 'home' exista
        // Nota: si usas el metodo home() primero, siempre existir.
        $pagina = PaginaEditable::where('slug', 'home')->firstOrFail();

        //usamos la vista 'editar-home.blade.php' que contiene grapesJS
        return view('editar_home', compact('pagina'));
    }


    // Guardar contenido del home
    public function guardarHome(Request $request)
    {
        $pagina = PaginaEditable::where('slug', 'home')->firstOrFail();

        //Guardar contenido enviado desde GrapesJS 
        $pagina->contenido_html = $request->input('contenido_html');
        $pagina->save();

        return redirect()->route('editar-home')->with('success', 'Pagina guardada correctamente');
    }
}
