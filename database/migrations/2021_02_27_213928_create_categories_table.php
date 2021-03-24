<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 225);
			$table->string('image', 255);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}