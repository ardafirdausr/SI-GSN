<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('email')->unique();
            $table->string('NIP', 25)->unique();
            $table->string('username', 25)->unique();
            $table->string('nama', 50);
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('access_role', ['petugas terminal', 'petugas agen', 'admin']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
