<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Temporalmente permitir valores nulos para evitar errores durante el cambio de tipo
        Schema::table('routes', function (Blueprint $table) {
            $table->string('status_temp')->nullable()->after('status');
        });

        // Copiar datos existentes (opcional, si quieres mapear valores antiguos a nuevos)
        // En este caso, como 'active' e 'inactive' existen en ambos, podemos simplemente
        // asegurarnos de que estén en el nuevo ENUM. Si tuvieras valores como 'temporary'
        // que no existen en el nuevo ENUM, tendrías que decidir cómo manejarlos (ej. mapear a 'Inactive').
        DB::statement("UPDATE routes SET status_temp = status");


        // Modificar la columna status al nuevo ENUM
        Schema::table('routes', function (Blueprint $table) {
            $table->enum('status', ['Active', 'Inactive', 'Under Maintenance', 'Closed'])
                  ->default('Active')
                  ->change(); // Usamos change() para modificar una columna existente
        });

        // Copiar datos de vuelta (si hiciste mapeo o simplemente para asegurar)
         DB::statement("UPDATE routes SET status = status_temp");


        // Eliminar la columna temporal
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('status_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el cambio (volver al ENUM original)
        // Nota: Esto puede causar pérdida de datos si tenías estados 'Under Maintenance' o 'Closed'
        // ya que no existen en el ENUM original.
        Schema::table('routes', function (Blueprint $table) {
             $table->string('status_temp')->nullable()->after('status');
        });

        DB::statement("UPDATE routes SET status_temp = status");

        Schema::table('routes', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'temporary'])
                  ->default('active')
                  ->change();
        });

        DB::statement("UPDATE routes SET status = status_temp");

        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('status_temp');
        });
    }
};
