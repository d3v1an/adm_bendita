<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDownloablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('downloables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id',false);
			$table->enum('file_type',array('toy_pdf','lingerie_pdf','lingerie_zip'));
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
		Schema::drop('downloables');
	}

}
