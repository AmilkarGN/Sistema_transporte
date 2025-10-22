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
        Schema::create('trips', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('route_id')->index('route_id');
            $table->integer('vehicle_id')->index('vehicle_id');
            $table->integer('driver_id')->index('driver_id');
            $table->dateTime('departure_date');
            $table->dateTime('estimated_arrival');
            $table->dateTime('actual_arrival')->nullable();
            $table->enum('status', ['pendiente', 'asignado', 'en_progreso', 'finalizado'])->default('pendiente');            $table->decimal('actual_total_cost', 12)->nullable();
            $table->integer('initial_mileage')->nullable();
            $table->integer('final_mileage')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('time_deviation', 5)->nullable()->comment('Hours deviation vs estimated');
            $table->tinyInteger('route_score')->nullable()->comment('1-5 stars');
            $table->text('delay_reason')->nullable();
            $table->integer('problem_segment_id')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
