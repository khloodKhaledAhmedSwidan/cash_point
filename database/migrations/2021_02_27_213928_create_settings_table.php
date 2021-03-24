<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('term', 255)->nullable();
			$table->string('condition', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->string('logo', 255)->nullable();
			$table->integer('min_limit_replacement')->nullable();
			$table->integer('client_cash')->nullable();
			$table->integer('coupon_period')->nullable();
			$table->decimal('max_commission', 10,2)->nullable();
			$table->integer('scope_of_search')->nullable()->default(0);

			$table->string('min_text', 225)->nullable();
			$table->string('phone', 225)->nullable();
			$table->string('facebook', 225)->nullable();
			$table->string('instagram', 225)->nullable();
			$table->string('twitter', 225)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}