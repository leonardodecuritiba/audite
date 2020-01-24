<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use \App\Models\Moviments\Conveyor;
use Faker\Generator as Faker;

$factory->define(Conveyor::class, function (Faker $faker) {

    $type = $faker->boolean();
    $cpf = NULL;
    $cnpj = NULL;
    if($type){
        $cnpj = $faker->cnpj( false );
    } else {
        $cpf = $faker->cpf( false );
    }

    $set = $faker->boolean;
    return [
        'address_id'   => function () {
            return factory( \App\Models\HumanResources\Settings\Address::class )->create()->id;
        },
        'contact_id'   => function () {
            return factory( \App\Models\HumanResources\Settings\Contact::class )->create()->id;
        },

        'initials'  => strtoupper($faker->lexify('???')),

        'type'              => $type,
        'cpf'               => $cpf,
        'cnpj'              => $cnpj,

        'ie'                => ( $type ) ? null : $faker->randomNumber( $nbDigits = 4 ) . $faker->randomNumber( $nbDigits = 9 ),
        'social_reason'     => $faker->company,
        'active'            => 1,
        'description'       => $faker->text(50),
        'price_type'        => ($set) ? $faker->numberBetween(1,5) : NULL,
        'priority_type'     => ($set) ? $faker->numberBetween(1,4) : NULL,
    ];
});
