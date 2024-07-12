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
        Schema::create('ionizer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ionizer_id')->constrained('ionizers')->onDelete('cascade');
            $table->string('area');
            $table->string('location');
            $table->string('pm_1');
            $table->string('pm_2');
            $table->string('pm_3');
            $table->unsignedBigInteger('c1');
            $table->string('judgement_c1');
            $table->unsignedBigInteger('c2');
            $table->string('judgement_c2');
            $table->unsignedBigInteger('c3');
            $table->string('judgement_c3');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ionizer_details');
    }
};
