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
        Schema::table('ionizer_details', function (Blueprint $table) {
            $table->string('c1')->change(); // Mengubah tipe data ke float
            $table->string('c2')->change();
            $table->string('c3')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ionizer_details', function (Blueprint $table) {
            $table->unsignedBigInteger('c1')->change(); // Mengembalikan tipe data ke unsignedBigInteger
            $table->unsignedBigInteger('c2')->change();
            $table->unsignedBigInteger('c3')->change(); 
        });
    }
};
