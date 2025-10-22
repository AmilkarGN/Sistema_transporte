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
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->integer('route_id')->index('route_id');
            $table->timestamp('request_date')->useCurrent();
            $table->date('estimated_trip_date');
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'rescheduled'])->nullable()->default('pending');
            $table->enum('estimated_shipment_type', ['soy', 'minerals', 'machinery', 'others']);
            $table->decimal('estimated_weight', 10);
            $table->decimal('estimated_volume', 10)->nullable();
            $table->enum('priority', ['low', 'normal', 'high'])->nullable()->default('normal');
            $table->text('notes')->nullable();
            $table->integer('assigned_trip_id')->nullable()->index('assigned_trip_id');
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
        Schema::dropIfExists('bookings');
    }
};
