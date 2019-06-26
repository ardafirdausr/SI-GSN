<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$maskapaiAutoIncrement = maskapaiAutoIncrement();

function maskapaiAutoIncrement(){
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}

$factory->define(App\Models\Maskapai::class, function (Faker $faker) use ($maskapaiAutoIncrement){
    $maskapaiAutoIncrement->next();
    $faker->addProvider(new \Faker\Provider\id_ID\Company($faker));
    return [
        'nama' => $faker->company,
        'loket' => $maskapaiAutoIncrement->current()
    ];
});

// $factory->afterCreating(App\Models\Maskapai::class, function ($maskapai, $faker) {
//     $maskapai->kapal()->saveMany(factory('App\Models\Kapal', 5)->make());
// });