<?php

// Composer: "fzaninotto/faker": "v1.3.0"
//use Faker\Factory as Faker;

class ColorsTableSeeder extends Seeder {

	public function run()
	{
		//$faker = Faker::create();

		Color::create([
			'name'	=> 'Blanco',
			'hex' 	=> 'FFFFFF'
		]);
		Color::create([
			'name'	=> 'Negro',
			'hex' 	=> '000000'
		]);
		Color::create([
			'name'	=> 'Azul',
			'hex' 	=> '0D3857'
		]);
		Color::create([
			'name'	=> 'Rojo',
			'hex' 	=> 'DE1010'
		]);
		Color::create([
			'name'	=> 'Rosa',
			'hex' 	=> 'FF00EE'
		]);
		Color::create([
			'name'	=> 'Fiusha',
			'hex' 	=> 'FF0080'
		]);
		Color::create([
			'name'	=> 'Dorado',
			'hex' 	=> 'FF9D00'
		]);
		Color::create([
			'name'	=> 'Gris',
			'hex' 	=> '6E6E6E'
		]);
		Color::create([
			'name'	=> 'Tinto',
			'hex' 	=> 'C21558'
		]);
		Color::create([
			'name'	=> 'Cafe',
			'hex' 	=> '855600'
		]);
		Color::create([
			'name'	=> 'Verde',
			'hex' 	=> '03D903'
		]);
		Color::create([
			'name'	=> 'Amarillo',
			'hex' 	=> 'EEFF00'
		]);
		Color::create([
			'name'	=> 'Azul Claro',
			'hex' 	=> '55B5FA'
		]);
	}

}