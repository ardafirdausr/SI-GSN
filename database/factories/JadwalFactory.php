<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Jadwal::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\id_ID\Address($faker));

    $surabaya = 'Surabaya';
    $isSurabaya = !!rand(0, 1);
    $otherCity = $faker->city;
    while($otherCity == 'Surabaya') $otherCity = $faker->city;

    $keberangkatan = \Carbon\Carbon::now()->add(rand(0,72), 'hour');
    $kedatangan = (new \Carbon\Carbon($keberangkatan))->add(rand(6, 72), 'hour');
    return [
        'asal' => $isSurabaya ? $surabaya : $otherCity,
        'tujuan'  => $isSurabaya ? $otherCity : $surabaya,
        'keberangkatan' => $keberangkatan->locale('id'),
        'kedatangan' => $kedatangan->locale('id'),
        'status' => 'on schedule'
    ];
});