<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        //new table created
    {
        Schema::create('survey', function (Blueprint $table) {
           $table->increments('id')->onDelete('cascade'); //inidicates ID with cascade, meaning when deleted it will delete every sub category (e.g. questions that belong to the survey)
           $table->integer('creator_id')->unsigned()->default(0); //integer defined creator_id
           $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade'); //this indicates where the foreign key creator_id is coming from
           $table->string('slug')->nullable()->unique(); //not used
           $table->longText('title')->nullable(); //this indicates the title, with the longtext attribute
           $table->longText('description')->nullable();  //this indicates the description, with the longtext attribute
           $table->boolean('active')->default(false); //this is a boolean (1 or 0)with the default value 'false' or 0
           $table->boolean('anonymous')->default(false); //this is a boolean (1 or 0)with the default value 'false' or 0
           $table->timestamps();
           $table->timestamp('published_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('survey');
    }
}
