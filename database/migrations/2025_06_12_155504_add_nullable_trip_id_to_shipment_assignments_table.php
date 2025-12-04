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
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // CORRECCIÓN 1: trip_id debe ser 'integer' para coincidir con la tabla 'trips'
            // Le quitamos el unsignedBigInteger y usamos integer
            $table->integer('trip_id')->nullable()->change();

            // CORRECCIÓN 2: shipment_id debe ser 'unsignedBigInteger' para coincidir con la tabla 'shipments'
            $table->unsignedBigInteger('shipment_id')->change();
        });

        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Verificar y agregar llave foránea para trip_id
            if (!DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'shipment_assignments' AND COLUMN_NAME = 'trip_id' AND CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL")) {
                $table->foreign('trip_id')->references('id')->on('trips')->onDelete('set null');
            }

            // Verificar y agregar llave foránea para shipment_id
            if (!DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'shipment_assignments' AND COLUMN_NAME = 'shipment_id' AND CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL")) {
                $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_assignments', function (Blueprint $table) {
            // Eliminar claves foráneas primero
            $table->dropForeign(['shipment_id']);
            $table->dropForeign(['trip_id']);
            
            // Revertir cambios (esto es aproximado, ya que revertir tipos exactos es complejo)
            $table->integer('trip_id')->nullable(false)->change();
        });
    }
};