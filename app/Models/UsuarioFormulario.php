<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioFormulario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'area',
    ];


    protected $hidden = ['password'];

    public function formulariosPermitidos()
    {
        return $this->belongsToMany(Formulario::class, 'usuario_formulario_formulario');
    }
}
