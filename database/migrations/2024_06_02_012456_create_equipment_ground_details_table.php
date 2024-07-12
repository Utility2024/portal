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
        Schema::create('equipment_ground_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_ground_id')->constrained('equipment_grounds')->onDelete('cascade');
            $table->string('area')->nullable(); // Mengubah menjadi nullable()
            $table->string('location')->nullable(); // Mengubah menjadi nullable()
            $table->unsignedBigInteger('measure_results_ohm');
            $table->string('judgement_ohm');
            $table->unsignedBigInteger('measure_results_volts');
            $table->string('judgement_volts');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_ground_details');
    }
};
