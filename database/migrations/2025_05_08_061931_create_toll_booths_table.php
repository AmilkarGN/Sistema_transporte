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
        Schema::create('toll_booths', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('location');
            $table->integer('route_id')->index('route_id');
            $table->decimal('heavy_vehicle_cost', 10);
            $table->string('operation_hours', 100)->nullable()->default('24 hours');
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
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
        Schema::dropIfExists('toll_booths');
    }
};
