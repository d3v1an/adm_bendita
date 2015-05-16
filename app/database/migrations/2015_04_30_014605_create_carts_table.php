<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id', false)->index();
			$table->integer('user_id', false)->index();
			$table->string('code');
			$table->text('description');
			$table->integer('type_id', false);
			$table->integer('price', false);
			$table->integer('quanty', false);
			$table->integer('total', false);
			$table->enum('languaje', array('en','es'))->default('es');
			$table->enum('currency', array('MXN','USD'))->default('MXN');
			$table->integer('exchange_rate');
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
		Schema::drop('carts');
	}

}
