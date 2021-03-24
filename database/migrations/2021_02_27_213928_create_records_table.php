<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordsTable extends Migration {

	public function up()
	{
		Schema::create('records', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('image', 255)->nullable();
			$table->integer('commission_id')->unsigned();
			$table->enum('status', array('0', '1'));
			$table->decimal('cash', 10,2)->nullable();
			$table->decimal('paid', 10,2)->nullable();
			$table->decimal('remain', 10,2)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('records');
	}
}