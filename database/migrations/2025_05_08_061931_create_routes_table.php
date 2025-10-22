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
        Schema::create('routes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('origin', 100);
            $table->string('destination', 100);
            $table->decimal('origen_lat', 10, 7)->nullable();
            $table->decimal('origen_lng', 10, 7)->nullable();
            $table->decimal('destino_lat', 10, 7)->nullable();
            $table->decimal('destino_lng', 10, 7)->nullable();
            $table->decimal('distance_km', 10);
            $table->decimal('estimated_time_hours', 5);
            $table->integer('toll_booths')->nullable()->default(0);
            $table->decimal('estimated_toll_cost', 10)->nullable()->default(0);
            $table->enum('status', ['active', 'inactive', 'temporary'])->nullable()->default('active');
            $table->enum('difficulty', ['low', 'medium', 'high'])->nullable()->default('medium');
            $table->text('details')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
            $table->integer('risk_points')->nullable()->default(0);
            $table->timestamp('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
