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
            // Modificar la columna 'priority' a VARCHAR(50)
            // Esto asegurará que todos los niveles de prioridad definidos en el formulario quepan.
            // Si la columna era un ENUM, cambiarla a VARCHAR(50) es una opción flexible.
            // Si necesitas mantenerla como ENUM, tendrías que redefinir el ENUM
            // para incluir todos los valores posibles ('Low', 'Medium', 'High', 'Urgent').
            // Cambiar a VARCHAR(50) es más sencillo y cubre todos los casos.
            $table->string('priority', 50)->change();
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
            // Asumimos una longitud original de 25, ajústala si es diferente,
            // o si era un ENUM, reviértelo a la definición original del ENUM.
            $table->string('priority', 25)->change(); // Revertir a una longitud menor (ajusta si es necesario)
        });
    }
};
