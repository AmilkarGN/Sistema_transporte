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
        Schema::create('shipment_assignments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('trip_id')->index('trip_id');
            $table->integer('shipment_id')->index('shipment_id');
            $table->enum('status', ['loaded', 'in_transit', 'delivered', 'problem'])->nullable()->default('loaded');
            $table->timestamp('assignment_date')->useCurrent();
            $table->dateTime('delivery_date')->nullable();
            $table->string('received_by', 100)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('assigned_tons', 10);
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
        Schema::dropIfExists('shipment_assignments');
    }
};
