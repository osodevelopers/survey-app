<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeTable extends Migration
{
    /**
     * THIS TABLE WAS NEVER USED
     */
    public function up()
    {
        Schema::create('type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('type');
    }
}
