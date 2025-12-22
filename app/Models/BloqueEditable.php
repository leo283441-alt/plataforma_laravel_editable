<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloqueEditable extends Model
{
    use HasFactory;

    protected $fillable = [
        'pagina_id',
        'nombre_bloque',
        'tipo',
        'contenido',
        'orden',
    ];

    public function pagina()
    {
        return $this->belongsTo(PaginaEditable::class, 'pagina_id');
    }
}
