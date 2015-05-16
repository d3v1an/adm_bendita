<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class SiteConfigurationsTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();

		SiteConfiguration::create([
			'exchange_rate' => 11
		]);
	}

}