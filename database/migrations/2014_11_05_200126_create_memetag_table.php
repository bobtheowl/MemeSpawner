<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemetagTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meme_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meme_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('meme_id')->references('id')->on('memes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

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
		Schema::drop('meme_tag');
	}//end down()
}//end class CreateMemetagTable

//end file 2014_11_05_200126_create_memetag_table.php
