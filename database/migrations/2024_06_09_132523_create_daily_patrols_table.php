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
        Schema::create('daily_patrols', function (Blueprint $table) {
            $table->id();
            $table->string('description_problem');
            $table->string('area');
            $table->string('location');
            $table->string('status');
            $table->string('photo_before');
            $table->string('photo_after');
            $table->string('corrective_action');
            $table->date('date_corrective');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_patrols');
    }
};
