<?php

use Faker\Generator as Faker;
use App\Models\HumanResources\Settings\Contact;

$factory->define( Contact::class, function ( Faker $faker ) {
	return [
		'phone'         => $faker->areaCode() . $faker->landline( false ),
		'cellphone'     => $faker->areaCode() . $faker->cellphone( false, true ),
		'skype'         => $faker->unique()->safeEmail,
		'email_contact' => $faker->unique()->safeEmail,
	];
} );