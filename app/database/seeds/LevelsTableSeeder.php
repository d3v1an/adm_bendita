<?php

// Composer: "fzaninotto/faker": "v1.3.0"
//use Faker\Factory as Faker;

class LevelsTableSeeder extends Seeder {

	public function run()
	{
		//$faker = Faker::create();

		Level::create([
			'label'			=> 'Usuario',
			'description' 	=> 'Usuario normal'
		]);
		Level::create([
			'label'			=> 'Vendedor',
			'description' 	=> 'Vendedor de tienda'
		]);
		Level::create([
			'label'			=> 'Usuario',
			'description' 	=> 'Administrador del sitio'
		]);
	}

}