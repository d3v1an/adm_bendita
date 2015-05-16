<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sub_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id');
			$table->string('name');
			$table->string('name_en')->nullable();
			$table->string('tag');
			$table->text('description');
			$table->text('description_en')->nullable();
			$table->integer('order', false)->default(0);
			$table->boolean('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sub_categories');
	}

}
