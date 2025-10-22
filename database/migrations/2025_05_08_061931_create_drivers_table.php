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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->string('license_number', 50);
            $table->date('license_expiration');
            $table->string('license_type', 20)->nullable();
            $table->enum('status', ['available', 'on_trip', 'inactive'])->nullable()->default('available');
            $table->integer('monthly_driving_hours')->nullable()->default(0);
            $table->decimal('safety_score', 3)->nullable()->default(5)->comment('Scale 1-5');
            $table->date('last_evaluation')->nullable();
            $table->decimal('current_lat', 10, 7)->nullable();
            $table->decimal('current_lng', 10, 7)->nullable();
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
        Schema::dropIfExists('drivers');
    }
};