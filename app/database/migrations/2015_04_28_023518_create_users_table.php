<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->enum('gender',array('m','f'));
			$table->string('name');
			$table->string('first_name');
			$table->string('last_name');
			$table->date('birthday');
			$table->string('address');
			$table->string('suburb');
			$table->string('postal_code');
			$table->string('city');
			$table->integer('state_id', false)->default(0);
			$table->integer('country_id',false)->default(0);
			$table->string('company')->nullable();
			$table->string('email')->unique();
			$table->string('lada')->nullable();
			$table->string('phone');
			$table->integer('interest_id',false);
			$table->string('password');
			$table->string('password_recovery');
			$table->string('remember_token')->nullable();
			$table->string('affiliate_code');
			$table->integer('level_id',false);
			$table->integer('type_id',false);
			$table->string('currency',3);
			$table->string('activation',16);
			// De aqui en adelante son datos mal colocados inmutables
			$table->string('df_razon_social')->nullable();
			$table->string('df_rfc')->nullable();
			$table->enum('df_tipo',array('Fisica','Moral'))->default('Fisica');
			$table->string('df_direccion')->nullable();
			$table->string('df_cp')->nullable();
			$table->string('df_colonia')->nullable();
			$table->string('df_ciudad')->nullable();
			$table->integer('df_state_id',false)->default(0);
			$table->integer('df_country_id',false)->default(0);
			//
			$table->string('de_direccion')->nullable();
			$table->string('de_cp')->nullable();
			$table->string('de_colonia')->nullable();
			$table->string('de_ciudad')->nullable();
			$table->integer('de_state_id',false)->default(0);
			$table->integer('de_country_id',false)->default(0);
			//
			$table->boolean('status')->default(true);
			$table->integer('web_service_client_id',false)->default(0);
			$table->boolean('deleted')->default(false);
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
		Schema::drop('users');
	}

}
