<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('image_data');
            $table->text('thumbnail_data');
            $table->string('mime_type');
            $table->text('top_text_template')->nullable();
            $table->text('bottom_text_template')->nullable();
            $table->boolean('is_hidden')->default(false);

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
		Schema::drop('memes');
	}//end down()
}//end class CreateMemesTable

//end file 2014_11_05_200054_create_memes_table.php
