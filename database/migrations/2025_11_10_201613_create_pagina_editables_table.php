<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagina_editables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->string('titulo')->nullable();
            $table->string('color_fondo')->nullable();
            $table->string('color_texto')->nullable();
            $table->longText('contenido_html')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagina_editables', function (Blueprint $table) {
            $table->dropColumn([
                'nombre', 'slug', 'titulo', 'color_fondo', 'color_texto', 'contenido_html'
            ]);
        });
    }

};
