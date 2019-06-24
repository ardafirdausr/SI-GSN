<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->integer('id_maskapai')
                  ->unsigned();
            $table->foreign('id_maskapai')
                  ->references('id')
                  ->on('maskapai')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('id_kapal')
                  ->unsigned();
            $table->foreign('id_kapal')
                  ->references('id')
                  ->on('kapal')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            //
        });
    }
}
