<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Jadwal::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\id_ID\Address($faker));
    $waktu = \Carbon\Carbon::now()->addDay(rand(0, 5))->addHour(rand(4, 24));
    $kota = $faker->city;
    while($kota == 'Surabaya') $kota = $faker->city;
    return [
        'waktu' => $waktu,
        'kota' => $kota,
        'status_kegiatan' => 'datang',
        'status_kapal' => 'on schedule',
        'status_tiket' => 'boarding',
    ];
});

$factory->afterCreating(App\Models\Jadwal::class, function ($jadwal, $faker) {
    $faker->addProvider(new \Faker\Provider\id_ID\Address($faker));
    $waktu = (new \Carbon\Carbon($jadwal->waktu))->addMinute(rand(45, 120));
    $kota = $faker->city;
    while($kota == 'Surabaya') $kota = $faker->city;
    App\Models\Jadwal::create([
        'waktu' => $waktu,
        'kota' => $kota,
        'status_kegiatan' => 'berangkat',
        'status_kapal' => 'on schedule',
        'status_tiket' => 'check in',
        'id_kapal' => $jadwal->id_kapal
    ]);
});