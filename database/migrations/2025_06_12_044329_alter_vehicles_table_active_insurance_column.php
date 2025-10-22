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
        Schema::table('vehicles', function (Blueprint $table) {
            // Modifica la columna 'active_insurance' para que sea VARCHAR con una longitud de 20
            // Esto permitirá almacenar 'Yes' o 'No'
            $table->string('active_insurance', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Define cómo revertir el cambio si es necesario
            // Si antes era un booleano o tinyint:
            // $table->boolean('active_insurance')->change();
            // O si era un string con menor longitud:
            // $table->string('active_insurance', 10)->change();
        });
    }
};
