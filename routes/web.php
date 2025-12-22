<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\FormularioController;
use App\Models\PaginaEditable;
use App\Http\Controllers\UsuarioController;

// ==========================
// LOGIN
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================
// PÁGINAS EDITABLES
// ==========================
Route::get('/paginas', [PaginaController::class, 'index'])->name('lista_paginas');
Route::get('/paginas/crear', [PaginaController::class, 'create'])->name('paginas.create');
Route::post('/paginas', [PaginaController::class, 'store'])->name('paginas.store');
Route::get('/paginas/{id}/editar', [PaginaController::class, 'edit'])->name('paginas.edit');
Route::put('/paginas/{id}', [PaginaController::class, 'update'])->name('paginas.update');

// ==========================
// HOME Y EDICIÓN DEL HOME
// ==========================
// Mostrar el home
Route::get('/', function () {
    $pagina = PaginaEditable::where('slug', 'home')->first();

    if (!$pagina) {
        // Si no existe, se crea una por defecto
        $pagina = PaginaEditable::create([
            'slug' => 'home',
            'nombre' => 'Página de inicio',
            'titulo' => 'Inicio',
            'contenido_html' => '', // Vacío al principio
            'color_fondo' => '#ffffff',
            'color_texto' => '#000000',
        ]);
    }

    return view('home', compact('pagina'));
})->name('home');




Route::get('/editar-home', function () {
    $pagina = App\Models\PaginaEditable::where('slug', 'home')->first();

    // Si no existe, crear por defecto
    if (!$pagina) {
        $pagina = App\Models\PaginaEditable::create([
            'slug' => 'home',
            'nombre' => 'Página de inicio',
            'titulo' => 'Inicio',
            'contenido_html' => '',
        ]);
    }

    // Si aún no tiene contenido guardado, usamos el HTML del Blade "home"
    if (empty($pagina->contenido_html)) {
        // Renderiza el home.blade.php y lo guarda como punto de partida
        $htmlBase = view('home', ['pagina' => $pagina])->render();
        
        // Limpiamos el botón de editar para que no se duplique dentro del editor
        $htmlBase = preg_replace('/<a[^>]*class="edit-btn"[^>]*>.*?<\/a>/si', '', $htmlBase);

        $pagina->contenido_html = $htmlBase;
        $pagina->save();
    }

    return view('editar_home', compact('pagina'));
})->name('editar_home');

// Guardar cambios
Route::post('/editar-home', function (Request $request) {
    $pagina = PaginaEditable::where('slug', 'home')->first();

    if(!$pagina) {
        $pagina = PaginaEditable::create([
            'nombre' => 'home',
            'titulo' => 'Inicio',
            'slug' => 'home',
            'color_fondo' => '#ffffff',
            'color_texto' => '#000000',
            'contenido_html' => ''
        ]);
    }

    // Guardar contenido enviado desde GrapesJS
    $pagina->contenido_html = $request->input('contenido_html');
    $pagina->save();

    return redirect()->route('editar_home')->with('success', 'Página guardada correctamente');
})->name('editar_home_post');


Route::get('/formularios', [FormularioController::class, 'lista'])->name('formulario.lista');
Route::get('/formulario/{id}/ver', [FormularioController::class, 'ver'])->name('formulario.ver');
Route::get('/formulario/{id}/editar', [FormularioController::class, 'editar'])->name('formulario.editar');
Route::put('/formulario/{id}/actualizar', [FormularioController::class, 'actualizar'])->name('formulario.actualizar');

Route::delete('/formulario/{id}/eliminar', [FormularioController::class, 'eliminar'])->name('formulario.eliminar');

Route::get('/formulario/crear', [FormularioController::class, 'crear'])->name('formulario.crear');
Route::post('/formulario/guardar', [FormularioController::class, 'guardar'])->name('formulario.guardar'); 
Route::post('/formulario/responder', [FormularioController::class, 'guardarRespuesta'])->name('formulario.responder');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout.general');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/asignar', [UsuarioController::class, 'mostrarFormulario'])->name('usuarios.asignar');
    Route::post('/usuarios/guardar', [UsuarioController::class, 'guardar'])->name('usuarios.guardar');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminar'])->name('usuarios.eliminar');
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar'])->name('usuarios.editar');
    Route::put('/usuarios/{id}/actualizar', [UsuarioController::class, 'actualizar'])->name('usuarios.actualizar');
});


