<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class ParcelsTableSeeder extends Seeder {

	public function run()
	{
		// $faker = Faker::create();

			Parcel::create([
				'label' => 'Estafeta',
				'link'	=> 'http://www.estafeta.com/herramientas/rastreo.aspx'
			]);
			Parcel::create([
				'label' => 'Redpack',
				'link'	=> 'http://www.redpack.com.mx/RpkWeb/RastreoEnvios'
			]);
			Parcel::create([
				'label' => 'UPS',
				'link'	=> 'http://www.ups.com/WebTracking/track?loc=es_MX'
			]);
			Parcel::create([
				'label' => 'Tres Guerras',
				'link'	=> 'http://soa.tresguerras.com.mx:8080/web/actsa/track'
			]);
			Parcel::create([
				'label' => 'Estrella Blanca',
				'link'	=> 'http://www.enviageb.com.mx/pages/'
			]);
	}

}