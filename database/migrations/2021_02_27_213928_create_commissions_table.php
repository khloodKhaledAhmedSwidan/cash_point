<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissionsTable extends Migration {

	public function up()
	{
		Schema::create('commissions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->decimal('total', 10,2)->nullable();
			$table->decimal('paid', 10,2)->nullable();
			$table->decimal('remain', 10,2)->nullable();
			$table->string('image', 255)->nullable();
			$table->integer('invoice')->nullable();
			$table->enum('status', array('0', '1'));
			$table->decimal('coupon', 10,2)->nullable();
			$table->integer('coupon_id')->unsigned()->nullable();
            $table->foreign('coupon_id')->references('id')
			->on('coupons')->onUpdate('cascade')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('commissions');
	}
}