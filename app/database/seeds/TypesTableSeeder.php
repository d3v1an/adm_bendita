<?php

// Composer: "fzaninotto/faker": "v1.3.0"
//use Faker\Factory as Faker;

class TypesTableSeeder extends Seeder {

	public function run()
	{
		//$faker = Faker::create();

		Type::create([
			'label'			=> 'Publico',
			'description' 	=> 'Usuario con precios de venta al publico'
		]);
		Type::create([
			'label'			=> 'Medio mayorista',
			'description' 	=> 'Usuario con precios de medio mayorista'
		]);
		Type::create([
			'label'			=> 'Mayorista',
			'description' 	=> 'Usuario con precios de mayorista'
		]);
		Type::create([
			'label'			=> 'Distribuidor',
			'description' 	=> 'Usuario con precios de distribuidor'
		]);
	}

}