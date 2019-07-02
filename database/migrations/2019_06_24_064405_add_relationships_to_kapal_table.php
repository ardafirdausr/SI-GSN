<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToKapalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kapal', function (Blueprint $table) {
            $table->bigInteger('id_agen_pelayaran')
                  ->unsigned()
                  ->before('created_at');
            $table->foreign('id_agen_pelayaran')
                  ->references('id')
                  ->on('agen_pelayaran')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kapal', function (Blueprint $table) {
            //
        });
    }
}
