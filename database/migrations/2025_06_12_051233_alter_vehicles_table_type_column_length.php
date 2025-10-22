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
            // Modifica la columna 'type' para que sea VARCHAR con una longitud de 50
            // Esto permitirá almacenar tipos de vehículo más largos
            $table->string('type', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Define cómo revertir el cambio si es necesario
            // Por ejemplo, si antes era VARCHAR(20):
            // $table->string('type', 20)->change();
        });
    }
};
