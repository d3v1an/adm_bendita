<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarrouselsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carrousels', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('pic');
			$table->string('title');
			$table->boolean('linkable');
			$table->string('link')->nullable();
			$table->integer('category_id');
			$table->integer('order')->default(0);
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
		Schema::drop('carrousels');
	}

}
