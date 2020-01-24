<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ContractItem;
use Faker\Generator as Faker;

$factory->define(\App\Models\Moviments\ContractItem::class, function (Faker $faker) {
    return [
        'moviment_id' => $faker->numberBetween(1,50),
        'contract_id' => $faker->numberBetween(1,50),
    ];
});
