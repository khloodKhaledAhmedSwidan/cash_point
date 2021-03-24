<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	public function up()
	{

		Schema::create('transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->decimal('cash', 10,2);
			$table->integer('point')->nullable();
			$table->decimal('commission', 10,2)->nullable();
			$table->decimal('coupon', 10,2)->nullable();
			$table->enum('status', array('1', '2'));
			$table->enum('commission_is_paid', array('1', '2'));
			$table->integer('coupon_id')->unsigned()->nullable();
            $table->foreign('coupon_id')->references('id')
			->on('coupons')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('order_number');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('transactions');
	}
}