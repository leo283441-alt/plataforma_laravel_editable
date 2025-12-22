<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Formulario;

class UsuarioController extends Controller
{
    // Mostrar formulario para crear usuario y asignar formularios
    public function mostrarFormulario()
    {
        $formularios = Formulario::all();
        $usuarios = User::with('formularios')->get();

        return view('asignar', compact('formularios', 'usuarios'));
    }

    // Guardar nuevo usuario y asignarle formularios
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|string|in:admin,editor,usuario',
        ]);

        $usuario = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
        ]);

        if ($request->has('formularios_permitidos')) {
            $usuario->formularios()->sync($request->formularios_permitidos);
        }

        return redirect()->route('usuarios.asignar')->with('success', 'Usuario creado correctamente.');
    }

    public function eliminar($id)
    {
        $usuario = user::findOrFail($id);
        $usuario->formularios()->detach();
        $usuario->delete();

        return redirect()->route('usuarios.asignar')->with('success', '🗑️ Usuario eliminado correctamente');
    }

    public function editar($id)
    {
        $usuario = User::with('formularios')->findOrFail($id);
        $formularios = Formulario::all();

        return view('editar_usuario', compact('usuario', 'formularios'));
    }

    public function actualizar(Request $request, $id)
{
    $usuario = User::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:users,email,' . $usuario->id,
        'rol' => 'required|string|in:admin,editor,usuario',
    ]);

    $usuario->update([
        'name' => $request->nombre,
        'email' => $request->correo,
        'rol' => $request->rol,
    ]);

    if ($request->has('formularios_permitidos')) {
        $usuario->formularios()->sync($request->formularios_permitidos);
    } else {
        $usuario->formularios()->detach();
    }

    return redirect()->route('usuarios.asignar')->with('success', '✅ Usuario actualizado correctamente.');
}


}
