<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ConveyorGeneralities;
use Faker\Generator as Faker;

$factory->define(\App\Models\Moviments\Settings\ConveyorGeneralities::class, function (Faker $faker) {
    return [
        'conveyor_id'   => \App\Models\Moviments\Conveyor::all()->random(1)->first()->id,
        'type'          => $faker->numberBetween(1, 17),
        'value'         => $faker->randomFloat(2,10,100),
    ];
});
