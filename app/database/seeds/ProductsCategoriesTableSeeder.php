<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class ProductsCategoriesTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();

		ProductsCategory::create([
			'name'		=> 'Lenceria',
			'name_en'	=> 'Lingerie',
			'tag'		=> 'lenceria',
			'tag_en'	=> 'lingerie',
			'order'		=> 1
		]);
		ProductsCategory::create([
			'name'		=> 'Zapatos',
			'name_en'	=> 'Shoes',
			'tag'		=> 'zapatos',
			'tag_en'	=> 'shoes',
			'order'		=> 3
		]);
		ProductsCategory::create([
			'name'		=> 'Juguetes',
			'name_en'	=> 'Toys',
			'tag'		=> 'juguetes',
			'tag_en'	=> 'toys',
			'order'		=> 4
		]);
		ProductsCategory::create([
			'name'		=> 'Accesorios',
			'name_en'	=> 'Accesories',
			'tag'		=> 'accesorios',
			'tag_en'	=> 'accesories',
			'order'		=> 2
		]);
	}

}