<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id', false);
			$table->integer('price', false);
			$table->integer('quanty', false);
			$table->integer('total', false);
			$table->enum('languaje', array('es','en'))->default('es');
			$table->string('currency', 4)->default('MXN');
			$table->integer('exchange_rate', false)->default(0);
			$table->boolean('done')->default(false);
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
		Schema::drop('items');
	}

}
