<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations;
use Faker\Generator as Faker;

$factory->define(Locations::class, function (Faker $faker) {
    return [
        'location_name' => $faker->name,
        'status' => '1'
    ];
});
