<?php

// Composer: "fzaninotto/faker": "v1.3.0"
//use Faker\Factory as Faker;

class AdminsLevelsTableSeeder extends Seeder {

	public function run()
	{
		//$faker = Faker::create();

		AdminsLevel::create([
			'alias' => 'Admin'
		]);
		AdminsLevel::create([
			'alias' => 'Sub-Administrador'
		]);
		AdminsLevel::create([
			'alias' => 'Consultor'
		]);
	}

}