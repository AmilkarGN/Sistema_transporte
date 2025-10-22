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
            // Modifica las columnas para que sean VARCHAR con una longitud adecuada
            // 50 caracteres debería ser suficiente para los rangos aproximados
            $table->string('load_capacity', 50)->change();
            $table->string('load_volume', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Define cómo revertir el cambio si es necesario
            // Si antes eran numéricos, podrías revertir a eso, por ejemplo:
            // $table->decimal('load_capacity', 8, 2)->change();
            // $table->decimal('load_volume', 8, 2)->change();
            // O si eran strings con menor longitud:
            // $table->string('load_capacity', 20)->change();
            // $table->string('load_volume', 20)->change();
        });
    }
};
