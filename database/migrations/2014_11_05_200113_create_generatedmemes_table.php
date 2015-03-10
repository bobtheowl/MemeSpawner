<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratedmemesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generatedmemes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('image_data');
            $table->text('thumbnail_data');
            $table->string('mime_type');

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
		Schema::drop('generatedmemes');
	}//end down()
}//end class CreateGeneratedmemesTable

//end file 2014_11_05_200113_create_generatedmemes_table.php
