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
        Schema::create('worksurface_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksurface_id')->constrained('worksurfaces')->onDelete('cascade');
            $table->string('area');
            $table->string('location');
            $table->enum('item',['TABLE','RACK', 'TROLLEY']);
            $table->unsignedBigInteger('a1');
            $table->string('f1_scientific');
            $table->string('judgement_a1');
            $table->unsignedBigInteger('a2');
            $table->string('judgement_a2');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksurface_details');
    }
};
