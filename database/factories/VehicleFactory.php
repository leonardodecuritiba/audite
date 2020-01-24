<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use \App\Models\Moviments\Vehicle;
use Faker\Generator as Faker;

$factory->define(Vehicle::class, function (Faker $faker) {

	$owner_type = $faker->boolean();
	$owner_cpf = NULL;
	$owner_cnpj = NULL;
	if($owner_type){
		$owner_cnpj = $faker->cnpj( false );
	} else {
		$owner_cpf = $faker->cpf( false );
	}

	$driver_type = $faker->boolean();
	$driver_cpf = NULL;
	$driver_cnpj = NULL;
	if($driver_type){
		$driver_cnpj = $faker->cnpj( false );
	} else {
		$driver_cpf = $faker->cpf( false );
	}

    return [
	    'plate'         => strtoupper($faker->lexify('???')) . $faker->numberBetween( $min = 1000, $max = 9999 ),
	    'contract_type' => $faker->numberBetween( $min = 1, $max = 2 ),

	    'vehicle_type'  => $faker->numberBetween( $min = 1, $max = 10 ),
	    'bodywork_type' => $faker->numberBetween( $min = 1, $max = 6 ),
	    'capacity'      => $faker->numberBetween( $min = 1, $max = 100 ),

	    'owner_type'    => $owner_type,
	    'owner_name'    => $faker->name,
	    'owner_cpf'     => $owner_cpf,
	    'owner_cnpj'    => $owner_cnpj,

	    'driver_type'   => $driver_type,
	    'driver_name'   => $faker->name,
	    'driver_cpf'    => $driver_cpf,
	    'driver_cnpj'   => $driver_cnpj,

	    'brand'         => $faker->text( 50 ),
	    'model'         => $faker->text( 20 ),
	    'active'        => 1,

    ];
});
