<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class InterestTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();

		Interest::create([
			'label' 	=> 'Consumo personal',
			'label_en' 	=> 'Personal consumption'
		]);
		Interest::create([
			'label' 	=> 'Venta por catálogo',
			'label_en' 	=> 'Mail Order'
		]);
		Interest::create([
			'label' 	=> 'Mayoreo',
			'label_en' 	=> 'Wholesale'
		]);
		Interest::create([
			'label' 	=> 'Distribución',
			'label_en' 	=> 'Distribution'
		]);
	}

}