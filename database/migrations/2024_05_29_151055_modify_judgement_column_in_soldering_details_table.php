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
        Schema::table('soldering_details', function (Blueprint $table) {
            $table->string('judgement')->change(); // Menambahkan default value pada kolom 'judgement'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldering_details', function (Blueprint $table) {
            $table->string('judgement')->default(null)->change(); // Menghapus default value saat rollback
        });
    }
};
