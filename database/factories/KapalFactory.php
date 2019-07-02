<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Kapal::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\id_ID\Person($faker));
    return [
        'kode' => uniqid(),
        'nama' => $faker->lastName
    ];
});

// $factory->afterCreating(App\Models\Kapal::class, function ($kapal, $faker) {
//     $jadwal = $kapal->jadwal()->save(factory('App\Models\Jadwal', 1)->make());
//     $jadwal->update(['id_agen_pelayaran' => $kapal->id_agen_pelayaran]);
// });
