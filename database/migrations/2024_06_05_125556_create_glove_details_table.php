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
        Schema::create('glove_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('glove_id')->constrained('gloves')->onDelete('cascade');
            $table->string('description');
            $table->string('delivery');
            $table->string('c1');
            $table->string('c1_scientific');
            $table->string('judgement');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glove_details');
    }
};
