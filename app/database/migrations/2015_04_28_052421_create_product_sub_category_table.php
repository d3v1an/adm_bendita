<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductSubCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_sub_category', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id')->unsigned()->index();
			//$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->integer('sub_category_id')->unsigned()->index();
			//$table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
			//$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_sub_category');
	}

}
