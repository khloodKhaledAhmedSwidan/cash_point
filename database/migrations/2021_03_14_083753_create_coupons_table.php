<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
			->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('point_id')->unsigned();
            $table->foreign('point_id')->references('id')
			->on('points')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('main', 10,2)->nullable();
            $table->decimal('remain', 10,2)->nullable();
            $table->decimal('pull', 10,2)->nullable();
             
            $table->timestamp('expired_at');

			$table->enum('is_used', array('0', '1', '2'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
