
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer', function (Blueprint $table) {
            $table->increments('id'); //id is defines
            $table->string('title'); //title is defined in a string
            $table->longText('atext'); //atext is the text that the survey stores from the users input
            $table->string('answered_by')->nullable(); //who submitted the answer?
            $table->integer('question_id')->unsigned(); //integer defined question_id
            $table->integer('survey_id')->unsigned(); //integer defined survey_id
            $table->foreign('question_id')->references('id')->on('question')->onDelete('cascade'); //this indicates where the foreign key question_id is coming from
            $table->foreign('survey_id')->references('id')->on('survey')->onDelete('cascade'); //this indicates where the foreign key survey_id is coming from
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
        Schema::drop('answer');
    }
}
