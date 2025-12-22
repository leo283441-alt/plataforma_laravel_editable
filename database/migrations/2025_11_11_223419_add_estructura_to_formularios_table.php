<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('formularios', function (Blueprint $table) {
            $table->json('estructura')->nullable(); // agrega la columna JSON
        });
    }

    public function down()
    {
        Schema::table('formularios', function (Blueprint $table) {
            $table->dropColumn('estructura');
        });
    }
};
