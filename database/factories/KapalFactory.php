<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Kapal::class, function (Faker $faker) {
    return [
        'nama' => $faker->lastName
    ];
});

$factory->afterCreating(App\Models\Kapal::class, function ($kapal, $faker) {
    factory('App\Models\Jadwal', 1)->create(['kapal_id' => $kapal->id]);
});
