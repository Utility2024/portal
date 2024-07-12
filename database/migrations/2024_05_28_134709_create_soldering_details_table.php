<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolderingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('soldering_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soldering_id')->constrained()->onDelete('cascade');
            $table->string('area');
            $table->string('location');
            $table->unsignedBigInteger('e1');
            $table->string('judgement');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('soldering_details');
    }
}
