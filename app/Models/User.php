<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = ['password'];

    public function formularios()
    {
        return $this->belongsToMany(Formulario::class, 'formulario_user', 'user_id', 'formulario_id');
    }
}