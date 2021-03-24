<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBanksTable extends Migration {

	public function up()
	{
		Schema::create('banks', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 225);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('banks');
	}
}