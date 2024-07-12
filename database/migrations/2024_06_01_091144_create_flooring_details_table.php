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
        Schema::create('flooring_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flooring_id')->constrained()->onDelete('cascade');
            $table->string('area');
            $table->string('location');
            $table->unsignedBigInteger('b1');
            $table->string('b1_scientific');
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
        Schema::dropIfExists('flooring_details');
    }
};
