<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenPelayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agen_pelayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 50);
            $table->string('alamat', 100);
            $table->string('telepon', 20);
            $table->string('loket', 20);
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
        Schema::dropIfExists('agen_pelayaran');
    }
}
