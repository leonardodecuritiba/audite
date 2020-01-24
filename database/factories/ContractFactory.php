<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Contract;
use Faker\Generator as Faker;

$factory->define(\App\Models\Moviments\Contract::class, function (Faker $faker) {


	return [
		'cost_type'             => $faker->numberBetween( $min = 1, $max = 6 ),
		'contract_partner_type' => $faker->numberBetween( $min = 1, $max = 2 ),

		'contracted_at'         => $faker->date(),
		'realized_at'           => $faker->date(),

		'description'           => $faker->text( 100 ),
		'value'                 => $faker->randomFloat(5,0,100),
		'payment_form'          => $faker->text( 100 ),
		'payment_date'          => $faker->date(),
		'status'                => $faker->numberBetween( $min = 0, $max = 2 ),
	];
});
