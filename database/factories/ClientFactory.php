<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\HumanResources\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {

	$type = $faker->boolean();
    $cnpj = NULL;
    $social_reason = NULL;
    $fantasy_name = NULL;
	if($type){
		$cnpj = $faker->cnpj( false );
		$social_reason = $faker->company;
        $fantasy_name = $faker->company;
	}


	return [
        'address_id'   => function () {
            return factory( \App\Models\HumanResources\Settings\Address::class )->create()->id;
        },
        'contact_id'   => function () {
            return factory( \App\Models\HumanResources\Settings\Contact::class )->create()->id;
        },
		'type'          => $type,
        'name'          => $faker->name,
        'social_reason' => $social_reason,
        'fantasy_name'  => $fantasy_name,
        'cpf'           => $faker->cpf( false ),
        'cnpj'          => $cnpj,

		'active'        => 1,

	];
});
