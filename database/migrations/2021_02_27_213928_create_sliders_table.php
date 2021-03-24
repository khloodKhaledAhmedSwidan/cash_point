<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidersTable extends Migration {

	public function up()
	{
		Schema::create('sliders', function(Blueprint $table) {
			$table->increments('id');
			$table->string('image', 255);
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('admin_id')->unsigned()->nullable();
			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')->references('id')
			->on('categories')->onUpdate('cascade')->onDelete('cascade');
			$table->string('link', 255)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sliders');
	}
}