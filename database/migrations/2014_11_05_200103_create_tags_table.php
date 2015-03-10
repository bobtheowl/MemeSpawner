<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });//end Schema::create()
	}//end up()

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tags');
	}//end down()
}//end class CreateTagsTable

//end file 2014_11_05_200103_create_tags_table.php
