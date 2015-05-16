<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails_reports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('full_name');
			$table->string('email');
			$table->string('status');
			$table->integer('order_id',false);
			$table->text('email_doc');
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
		Schema::drop('emails_reports');
	}

}
