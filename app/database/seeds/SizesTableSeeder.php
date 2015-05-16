<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class SizesTableSeeder extends Seeder {

	public function run()
	{
		//$faker = Faker::create();

		Size::create([
			'size' => 'CH'
		]);
		Size::create([
			'size' => 'M'
		]);
		Size::create([
			'size' => 'G'
		]);
		Size::create([
			'size' => 'EG'
		]);
		Size::create([
			'size' => 'XXL'
		]);
		Size::create([
			'size' => 'XXXL'
		]);
		Size::create([
			'size' => 'Unitalla'
		]);
	}

}