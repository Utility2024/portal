<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMeasureResultsColumnsInEquipmentGroundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('equipment_ground_details', function (Blueprint $table) {
            $table->string('measure_results_ohm')->change(); // Mengubah tipe data ke float
            $table->string('measure_results_volts')->change(); // Mengubah tipe data ke float
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_ground_details', function (Blueprint $table) {
            $table->unsignedBigInteger('measure_results_ohm')->change(); // Mengembalikan tipe data ke unsignedBigInteger
            $table->unsignedBigInteger('measure_results_volts')->change(); // Mengembalikan tipe data ke unsignedBigInteger
        });
    }
}
