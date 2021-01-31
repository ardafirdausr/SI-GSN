<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

define('pelabuhan', [
    'Pelabuhan Tanjung Intan',
    'Pelabuhan Kalianget',
    'Pelabuhan Kalimas',
    'Pelabuhan Kamal',
    'Pelabuhan Ketapang',
    // 'Pelabuhan Tanjung Perak',
    'Pelabuhan Ujung',
    'Pelabuhan Tanjung Wangi',
    'Pelabuhan Pertiwi',
    'Pelabuhan Pramuka',
    'Pelabuhan Tanjung Priok',
    'Pelabuhan ASDP Dompak',
    'Pelabuhan ASDP Parit Rempak',
    'Pelabuhan ASDP Tanjung Uban',
    'Pelabuhan ASDP Telaga Punggur',
    'Pelabuhan Bakong',
    'Pelabuhan Batam Centre',
    'Pelabuhan Batu Ampar',
    'Pelabuhan Bulang Linggi',
    'Pelabuhan Dabo Singkep',
    'Pelabuhan Harbour Bay',
    'Pelabuhan Kijang Sri Bayintan',
    'Pelabuhan Kote',
    'Pelabuhan Letung Jemaja',
    'Pelabuhan Marok Tua',
    'Pelabuhan Telaga Punggur',
    'Pelabuhan Tarempa',
    'Pelabuhan Tanjung Setelung Serasan',
    'Pelabuhan Tanjung Buton',
    'Pelabuhan Tanjung Balai Karimun',
    'Pelabuhan Sunggak',
    'Pelabuhan Sungai Buluh',
    'Pelabuhan Sri Payung',
    'Pelabuhan Sri Bintan Pura',
    'Pelabuhan Sijantung',
    'Pelabuhan Sekupang',
    'Pelabuhan Senayang',
    'Pelabuhan Sei Tenam',
    'Pelabuhan Muara',
    'Pelabuhan Pangkal Balam',
    'Pelabuhan Belawan',
    'Pelabuhan Krueng Geukueh',
    'Pelabuhan Malundung',
    'Pelabuhan Trisakti',
    'Pelabuhan Samudera',
    'Pelabuhan Gorontalo',
    'Pelabuhan Anggrek',
    'Pelabuhan Paotere',
    'Pelabuhan Pamatata',
    'Pelabuhan Malili',
    'Pelabuhan Pare Pare',
    'Pelabuhan Barru',
    'Pelabuhan Pantoloan',
    'Pelabuhan Buton',
]);

$factory->define(App\Models\Jadwal::class, function(Faker $faker) {
    $faker->addProvider(new \Faker\Provider\id_ID\Address($faker));
    $waktu = \Carbon\Carbon::now()->addDay(rand(0, 3))->addHour(rand(4, 24));
    $kota = pelabuhan[rand(0, count(pelabuhan) - 1)];
    return [
        'waktu' => $waktu,
        'kota' => $kota,
        'status_kegiatan' => 'datang',
        'status_kapal' => 'on schedule',
        'status_tiket' => 'boarding',
    ];
});

$factory->afterCreating(App\Models\Jadwal::class, function($jadwal, $faker) {
    $faker->addProvider(new \Faker\Provider\id_ID\Address($faker));
    $waktu = (new \Carbon\Carbon($jadwal->waktu))->addMinute(rand(45, 120));
    $kota = pelabuhan[rand(0, count(pelabuhan) - 1)];
    while($kota == 'Surabaya') $kota = $faker->city;
    App\Models\Jadwal::create([
        'waktu' => $waktu,
        'kota' => $kota,
        'status_kegiatan' => 'berangkat',
        'status_kapal' => 'on schedule',
        'status_tiket' => 'check in',
        'kapal_id' => $jadwal->kapal_id
    ]);
});