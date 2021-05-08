<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->integer('user_id', true);
            $table->integer('user_api_key')->unique('User_user_api_key_uindex');
            $table->string('username', 40)->unique('User_username_uindex');
            $table->string('user_email', 60);
            $table->string('user_password', 60);
            $table->string('user_role', 40);
            $table->integer('reset_password_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('User');
    }
}
