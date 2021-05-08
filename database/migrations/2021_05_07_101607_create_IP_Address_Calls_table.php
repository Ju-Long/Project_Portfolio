<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIPAddressCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('IP_Address_Calls', function (Blueprint $table) {
            $table->string('IP_address', 20);
            $table->integer('times_a_month');
            $table->integer('times_a_day')->nullable();
            $table->integer('user_api_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('IP_Address_Calls');
    }
}
