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
    // Tabla para registrar dispositivos por IP
    Schema::create('user_devices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('ip_address', 45);
        $table->timestamps();
    });

    // Columnas nuevas en la tabla de usuarios
    Schema::table('users', function (Blueprint $table) {
        $table->string('two_factor_code')->nullable()->after('password');
        $table->dateTime('two_factor_expires_at')->nullable()->after('two_factor_code');
    });
}

public function down(): void
{
    Schema::dropIfExists('user_devices');
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['two_factor_code', 'two_factor_expires_at']);
    });
}
};
