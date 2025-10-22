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
            // Modificar la columna trip_id para que sea nullable
            // Asegúrate de que el tipo de dato y la restricción foreign key coincidan con tu esquema actual
            $table->unsignedBigInteger('trip_id')->nullable()->change();
        });
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Asegúrate de que las columnas existan y sean unsignedBigInteger
            // $table->unsignedBigInteger('shipment_id')->change();
            // $table->unsignedBigInteger('trip_id')->nullable()->change();

            // Agregar claves foráneas si no existen
            if (!\Illuminate\Support\Facades\DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'shipment_assignments' AND COLUMN_NAME = 'shipment_id' AND CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL")) {
                $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            }
            if (!\Illuminate\Support\Facades\DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'shipment_assignments' AND COLUMN_NAME = 'trip_id' AND CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL")) {
                $table->foreign('trip_id')->references('id')->on('trips')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Revertir el cambio: hacer la columna trip_id NOT NULL de nuevo
            // Esto puede fallar si hay registros con trip_id = NULL
            $table->unsignedBigInteger('trip_id')->nullable(false)->change();
        });
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Eliminar claves foráneas si existen
            $table->dropForeign(['shipment_id']);
            $table->dropForeign(['trip_id']);
        });
    }
};
