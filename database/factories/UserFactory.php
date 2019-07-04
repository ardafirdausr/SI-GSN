<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$userAutoIncrement = userAutoIncrement();

function userAutoIncrement(){
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}

$factory->define(App\Models\User::class, function (Faker $faker) use ($userAutoIncrement) {
    $userAutoIncrement->next();
    $faker->addProvider(new \Faker\Provider\id_ID\Person($faker));
    $name = $faker->firstName.' '.$faker->lastName;
    return [
        'NIP' => $faker->nik(),
        'username' => Str::camel($name),
        'nama' => $name,
        'foto' => asset('images/man.png'),
        // 'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});