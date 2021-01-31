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
            $table->bigInteger('agen_pelayaran_id')
                  ->unsigned()
                  ->before('created_at');
            $table->foreign('agen_pelayaran_id')
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
