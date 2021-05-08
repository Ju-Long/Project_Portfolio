<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAPIKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User_API_Keys', function (Blueprint $table) {
            $table->integer('user_api_key')->unique('User_API_Keys_user_api_key_uindex');
            $table->string('datamall', 100)->nullable()->unique('User_API_Keys_datamall_uindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('User_API_Keys');
    }
}
