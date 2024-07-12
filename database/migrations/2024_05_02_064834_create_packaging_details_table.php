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
        Schema::create('packaging_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packaging_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->enum('item',['Tray','Black Box']);
            $table->unsignedBigInteger('f1');
            $table->string('f1_scientific');
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
        Schema::dropIfExists('packaging_details');
    }
};
