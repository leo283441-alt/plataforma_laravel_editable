<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaginaEditable extends Model
{
    protected $table = 'pagina_editables'; // Laravel pluraliza el nombre
    protected $fillable = [
        'nombre',
        'slug',
        'titulo',
        'color_fondo',
        'color_texto',
        'contenido_html',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($pagina) {
            if (empty($pagina->slug)) {
                $pagina->slug = Str::slug($pagina->nombre);
            }
        });
    }
}
