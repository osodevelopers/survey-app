<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table){
            $table->increments('id')->onDelete('cascade');  //inidicates ID with cascade, meaning when deleted it will delete every sub category (e.g. options that belong to the survey)
            $table->longText('title'); //this indicates the title, with the longtext attribute
            $table->integer('creator_id')->unsigned()->default(0); //integer defined creator_id
            $table->integer('pre_question_id')->nullable()->unsigned(); //integer defined pre_question_id
            $table->integer('survey_id')->unsigned(); //integer defined survey_id
            $table->string('question_type'); //Indicates the question type
            $table->boolean('require')->default(false); //boolean to indicate if the question is required or not
            $table->timestamps();
        });

        Schema::table('question', function($table) {
            $table->foreign('pre_question_id')->references('id')->on('question'); //this indicates where the foreign key survey_id is coming from
            $table->foreign('survey_id')->references('id')->on('survey')->onDelete('cascade'); //this indicates where the foreign key survey_id is coming from
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade'); //this indicates where the foreign key creator_id is coming from
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question');
    }
}
