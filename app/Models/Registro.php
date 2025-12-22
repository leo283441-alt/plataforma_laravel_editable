<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'formularios_id',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array',
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }
}
