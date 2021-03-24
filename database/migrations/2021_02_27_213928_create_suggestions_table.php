<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuggestionsTable extends Migration {

	public function up()
	{
		Schema::create('suggestions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description', 255);
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')
			->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('suggestions');
	}
}