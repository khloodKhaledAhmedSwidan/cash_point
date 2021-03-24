<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatesTable extends Migration {

	public function up()
	{
		Schema::create('rates', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('rate', array('1', '2', '3', '4', '5'));
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->integer('transaction_id')->unsigned();
			$table->foreign('transaction_id')->references('id')
			->on('transactions')->onUpdate('cascade')->onDelete('cascade');
			$table->string('link', 255)->nullable();
			$table->string('description', 225)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('rates');
	}
}