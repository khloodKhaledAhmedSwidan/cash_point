<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('rates', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('devices', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('sliders', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('points', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('commissions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('bank_id')->references('id')->on('banks')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('records', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('records', function(Blueprint $table) {
			$table->foreign('commission_id')->references('id')->on('commissions')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('suggestions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_user_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_store_id_foreign');
		});
		Schema::table('devices', function(Blueprint $table) {
			$table->dropForeign('devices_user_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_user_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_store_id_foreign');
		});
		Schema::table('sliders', function(Blueprint $table) {
			$table->dropForeign('sliders_user_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_user_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_store_id_foreign');
		});
		Schema::table('points', function(Blueprint $table) {
			$table->dropForeign('points_user_id_foreign');
		});
		Schema::table('commissions', function(Blueprint $table) {
			$table->dropForeign('commissions_user_id_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_bank_id_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_category_id_foreign');
		});
		Schema::table('records', function(Blueprint $table) {
			$table->dropForeign('records_user_id_foreign');
		});
		Schema::table('records', function(Blueprint $table) {
			$table->dropForeign('records_commission_id_foreign');
		});
		Schema::table('suggestions', function(Blueprint $table) {
			$table->dropForeign('suggestions_user_id_foreign');
		});
	}
}