<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class AdminsTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();
		Admin::create([
			'name'		=> 'Admin',
			'username'	=> 'admin',
			'password'	=> Hash::make('admin')
		]);
		Admin::create([
			'name'		=> 'D3v1an',
			'username'	=> 'd3v1an',
			'password'	=> Hash::make('rurowni0321')
		]);
	}

}