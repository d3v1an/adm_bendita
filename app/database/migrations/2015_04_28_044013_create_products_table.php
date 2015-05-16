<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id', false);
			$table->integer('sub_category_id', false);
			$table->string('code')->unique();
			$table->integer('price_public', false);
			$table->integer('price_public_usd', false);
			$table->integer('price_half_wholesale', false);
			$table->integer('price_half_wholesale_usd', false);
			$table->integer('price_wholesale', false);
			$table->integer('price_wholesale_usd', false);
			$table->integer('price_dealer', false);
			$table->integer('price_dealer_usd', false);
			$table->text('description');
			$table->text('description_en');
			$table->text('detail');
			$table->text('detail_en');
			$table->enum('gender',array('m','f'))->default('f');
			$table->integer('stock',false)->default(0);
			$table->integer('minimal_stock',false)->default(0);
			$table->boolean('status')->default(false);
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
		Schema::drop('products');
	}

}
