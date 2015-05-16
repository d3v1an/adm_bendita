<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('admin_id');
			$table->text('note')->nullable();
			$table->string('shipping_cost');
			$table->integer('parcel_id', false);//
			$table->string('parcel_number');
			$table->integer('payment_type_id', false);//
			$table->text('payment_detail')->nullable();
			$table->integer('status_id', false);
			$table->boolean('payed');
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
		Schema::drop('orders');
	}

}
