<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHasExerciseDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User_Has_Exercise_Data', function (Blueprint $table) {
            $table->integer('data_id', true);
            $table->integer('user_has_exercise_id');
            $table->integer('sets')->default(5);
            $table->integer('reps')->default(5);
            $table->double('weight')->default(0);
            $table->integer('sets_done')->default(0);
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('User_Has_Exercise_Data');
    }
}
