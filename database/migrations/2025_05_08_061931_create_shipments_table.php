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
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->enum('type', ['soy', 'minerals', 'machinery', 'chemicals', 'food', 'textiles', 'others']);
            $table->decimal('weight_kg', 10);
            $table->decimal('volume_m3', 10);
            $table->text('description')->nullable();
            $table->timestamp('request_date')->useCurrent();
            $table->date('required_date')->nullable();
            $table->enum('status', ['pending', 'assigned', 'in_transit', 'delivered', 'canceled'])->nullable()->default('pending');
            $table->string('origin', 100);
            $table->string('destination', 100);
            $table->date('estimated_delivery_date')->nullable();
            $table->dateTime('actual_delivery_date')->nullable();
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->nullable()->default('normal');
            $table->boolean('requires_refrigeration')->nullable()->default(false);
            $table->text('special_instructions')->nullable();
            $table->softDeletes();

            // Claves foráneas aquí mismo
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};