<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class StatusesTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();

		Status::create([
			'label' => 'Pendiente',
			'detail' => 'Orden pendiente'
		]);
		Status::create([
			'label' => 'Procesada',
			'detail' => 'Orden procesada'
		]);
		Status::create([
			'label' => 'Enviada',
			'detail' => 'Orden enviada a destinatario'
		]);
		Status::create([
			'label' => 'Cancelada',
			'detail' => 'Orden cancelada'
		]);
	}

}