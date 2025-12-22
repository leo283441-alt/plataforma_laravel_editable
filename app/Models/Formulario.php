<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulario extends Model
{
    use HasFactory;

    protected $fillable = [      
        'titulo',
        'estructura',
        'user_id',
    ];

    
    protected $casts = [
         'estructura' => 'array', // equivalente a JSONField
    ];


    public function registros()
    {
        return $this->hasMany(Registro::class);
    }


    public function UsuariosPermitidos()
    {
        return $this->belongsToMany(UsuarioFormulario::class, 'formulario_usuario');
    }

    // app/Models/Formulario.php
public function usuarios()
{
    return $this->belongsToMany(User::class, 'formulario_user', 'formulario_id', 'user_id');
}

    
}
