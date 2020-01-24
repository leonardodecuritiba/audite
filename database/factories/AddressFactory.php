<?php

use Faker\Generator as Faker;
use App\Models\HumanResources\Settings\Address;
use \App\Models\Commons\CepStates;
use \App\Models\Commons\CepCities;

$factory->define( Address::class, function ( Faker $faker ) {
    $state_id = CepStates::get()->random( 1 )->first()->id;
	$city     = CepCities::findOrFailByStateId( $state_id )->random( 1 )->first();
	return [
		'state_id'   => $state_id,
		'city_id'    => $city->id,
		'city_code'  => $faker->randomNumber( $nbDigits = 8 ),
		'zip'        => $faker->randomNumber( $nbDigits = 8 ),
		'district'   => $faker->streetName,
		'street'     => $faker->streetName,
		'number'     => $faker->randomNumber( $nbDigits = 4 ),
		'complement' => $faker->word,
        'region'     => $faker->randomNumber( $nbDigits = 1 )
	];
} );
