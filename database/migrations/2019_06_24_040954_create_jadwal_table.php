<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('waktu');
            $table->string('kota');
            $table->enum('status_kegiatan', ['datang', 'berangkat']);
            $table->enum('status_kapal', ['on schedule', 'delay', 'cancel']);
            $table->enum('status_tiket', ['check in', 'boarding']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}
