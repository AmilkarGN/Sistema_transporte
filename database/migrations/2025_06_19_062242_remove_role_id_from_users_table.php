<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRoleIdFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Elimina la clave foránea primero
            $table->dropForeign(['role_id']);
            // Luego elimina la columna
            $table->dropColumn('role_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();
            // Si quieres, puedes volver a agregar la clave foránea aquí
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }
}