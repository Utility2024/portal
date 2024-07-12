<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyF1ColumnInPackagingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packaging_details', function (Blueprint $table) {
            // Ubah tipe data kolom 'f1' menjadi BIGINT
            $table->unsignedBigInteger('f1')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packaging_details', function (Blueprint $table) {
            // Kembalikan tipe data kolom 'f1' ke tipe data sebelumnya, misalnya INTEGER
            $table->integer('f1')->change();
        });
    }
}
