<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class PaymentTypesTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();

		PaymentType::create([
			'label' => 'Desposito Bancario'
		]);
		PaymentType::create([
			'label' => 'Efectivo'
		]);
		PaymentType::create([
			'label' => 'Paypal'
		]);
		PaymentType::create([
			'label' => 'Oxxo'
		]);
		PaymentType::create([
			'label' => 'Cheque'
		]);
		PaymentType::create([
			'label' => 'Local'
		]);
	}

}