<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option', function (Blueprint $table) {
            $table->increments('id')->onDelete('cascade'); //ID auto increments when created
            $table->string('title'); //string to create a title column
            $table->string('description'); //string to create a description (not in use)
            $table->integer('question_id')->unsigned()->default(0); //integer defined question_id
            $table->foreign('question_id')->references('id')->on('question')->onDelete('cascade'); //this indicates where the foreign key question_id is coming from
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
        Schema::drop('option');
    }
}
