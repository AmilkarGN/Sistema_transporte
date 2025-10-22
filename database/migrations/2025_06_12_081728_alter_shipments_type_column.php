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
        Schema::table('shipments', function (Blueprint $table) {
            // Modificar la columna 'type' a VARCHAR(50)
            // Asegúrate de que 'type' no sea un ENUM si lo era antes,
            // o ajusta el tipo de dato según tu necesidad real.
            // Si era VARCHAR, simplemente cambiamos la longitud.
            $table->string('type', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            // Revertir el cambio, volviendo a una longitud menor.
            // ¡CUIDADO! Esto puede causar pérdida de datos si tienes valores
            // en la base de datos que exceden la longitud original.
            // Asumimos una longitud original de 25, ajústala si es diferente.
            $table->string('type', 25)->change(); // Revertir a una longitud menor (ajusta si es necesario)
        });
    }
};
