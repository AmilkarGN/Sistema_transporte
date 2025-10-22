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
        Schema::table('drivers', function (Blueprint $table) {
            // Modifica la columna 'status' para que sea VARCHAR con una longitud de 20
            // Asegúrate de que el tipo de dato y la longitud sean adecuados para todos tus posibles estados
            $table->string('status', 20)->change();

            // Si usas ENUM y quieres añadir valores, sería algo como:
            // $table->enum('status', ['active', 'inactive', 'on_leave', 'suspended', 'nuevo_estado'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            // Define cómo revertir el cambio si es necesario
            // Por ejemplo, si antes era VARCHAR(10):
            // $table->string('status', 10)->change();

            // Si antes era ENUM con menos valores:
            // $table->enum('status', ['active', 'inactive', 'on_leave', 'suspended'])->change();
        });
    }
};

