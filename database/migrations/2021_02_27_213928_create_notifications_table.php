<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('store_id')->unsigned()->nullable();
			$table->string('title', 225);
			$table->string('description', 225);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}