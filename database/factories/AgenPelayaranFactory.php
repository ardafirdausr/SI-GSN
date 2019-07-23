<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$agenPelayaranAutoIncrement = agen_pelayaranAutoIncrement();

function agen_pelayaranAutoIncrement(){
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}

$factory->define(App\Models\AgenPelayaran::class, function (Faker $faker) use ($agenPelayaranAutoIncrement){
    $agenPelayaranAutoIncrement->next();
    $faker->addProvider(new \Faker\Provider\id_ID\Company($faker));
    $faker->addProvider(new \Faker\Provider\id_ID\Address($faker));
    $faker->addProvider(new \Faker\Provider\id_ID\PhoneNumber($faker));
    return [
        'nama' => $faker->company,
        'logo' => 'images/pelindo3.png',
        'alamat' => $faker->address,
        'telepon' => $faker->phoneNumber,
        'loket' => 'loket-'.$agenPelayaranAutoIncrement->current()
    ];
});

$factory->afterCreating(App\Models\AgenPelayaran::class, function ($agenPelayaran, $faker) {
    factory('App\Models\Kapal', 20)->create(['agen_pelayaran_id' => $agenPelayaran->id]);
});