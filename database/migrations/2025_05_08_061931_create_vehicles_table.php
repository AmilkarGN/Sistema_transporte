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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate', 20);
            $table->string('brand', 50);
            $table->string('model', 50);
            $table->integer('year');
            $table->decimal('load_capacity', 10);
            $table->decimal('load_volume', 10)->nullable();
            $table->enum('type', ['trailer', 'truck', 'dump_truck', 'van']);
            $table->enum('status', ['available', 'maintenance', 'on_trip', 'inactive'])->nullable()->default('available');
            $table->integer('driver_id')->nullable()->index('driver_id');
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->boolean('active_insurance')->nullable()->default(true);
            $table->string('insurance_policy', 100)->nullable();
            $table->decimal('average_speed', 5)->nullable()->comment('km/h');
            $table->decimal('historical_performance', 5)->nullable()->comment('Score 1-100');
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
        Schema::dropIfExists('vehicles');
    }
};
