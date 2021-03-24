<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePointsTable extends Migration {

	public function up()
	{
		Schema::create('points', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('main');
			$table->integer('pull')->nullable();
			$table->integer('remain');
			$table->decimal('cash', 10,2)->nullable();
			$table->enum('status', array('1', '2', '3','4'));
			$table->enum('type', array('0', '1'))->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('points');
	}
}