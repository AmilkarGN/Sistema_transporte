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
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Modificar la columna assigned_tons para que sea nullable
            // Asegúrate de que el tipo de dato coincida con tu esquema actual (decimal en este caso)
            $table->decimal('assigned_tons', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Revertir el cambio: hacer la columna assigned_tons NOT NULL de nuevo
            // Esto puede fallar si hay registros con assigned_tons = NULL
            $table->decimal('assigned_tons', 10, 2)->nullable(false)->change();
        });
    }
};
