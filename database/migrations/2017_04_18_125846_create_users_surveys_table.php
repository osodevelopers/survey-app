<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSurveysTable extends Migration
{
    /**
     * THIS PIVOT TABLE IS NOT USED
     */
    public function up()
    {
        Schema::create('users_surveys', function (Blueprint $table) {
            $table->integer('survey_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('survey');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['user_id', 'survey_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_surveys');
    }
}
