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
        Schema::create('garment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garment_id')->constrained('garments')->onDelete('cascade');
            $table->string('name');
            $table->unsignedBigInteger('d1');
            $table->string('d1_scientific');
            $table->string('judgement_d1');
            $table->unsignedBigInteger('d2');
            $table->string('d2_scientific');
            $table->string('judgement_d2');
            $table->unsignedBigInteger('d3');
            $table->string('d3_scientific');
            $table->string('judgement_d3');
            $table->unsignedBigInteger('d4');
            $table->string('d4_scientific');
            $table->string('judgement_d4');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garment_details');
    }
};
