<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('phone', 225);
			$table->string('password');
			$table->string('name', 225)->nullable();
			$table->integer('bank_id')->unsigned()->nullable();
			$table->enum('type', array('1', '2'));
			$table->integer('category_id')->unsigned()->nullable();
			$table->integer('active')->default('0');
			$table->string('api_token', 255)->nullable();
			$table->string('remember_token', 255)->nullable();
			$table->enum('language', array('ar', 'en'))->nullable();
			$table->string('description', 255)->nullable();
			$table->decimal('latitude', 10,8)->nullable();
			$table->decimal('longitude', 10,8)->nullable();
			$table->integer('membership_num')->nullable();
			$table->integer('commission')->nullable();
			$table->string('logo', 255)->nullable();
			$table->string('image', 255)->nullable()->default('default.png');
			$table->string('file', 255)->nullable()->default('default.png');
			$table->integer('arranging')->nullable();
			$table->datetime('last_login_at')->nullable();
			$table->string('last_login_ip', 255)->nullable();
			$table->integer('trade_register')->nullable();
			$table->string('bank_account',225)->nullable();
			$table->integer('point_equal_SR')->nullable();
			$table->integer('country_id')->unsigned();
			$table->foreign('country_id')->references('id')
			->on('countries')->onUpdate('cascade')->onDelete('cascade');
			$table->decimal('coupon', 10,2)->nullable();

			$table->integer('member_id')->unsigned()->nullable();
			$table->foreign('member_id')->references('id')
			->on('members')->onUpdate('cascade')->onDelete('cascade');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}