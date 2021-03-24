<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhoneVerificationTable extends Migration {

	public function up()
	{
		Schema::create('phone_verification', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('phone', 225);
			$table->string('code', 225);
			$table->integer('country_id');
			$table->foreign('country_id')->references('id')
			->on('countries')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('phone_verification');
	}
}