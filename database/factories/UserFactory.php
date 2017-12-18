<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'admin', function (Faker $faker) {
   return[
     'role' => \App\User::ROLE_ADMIN,
     'role_name' => 'Administrador'
   ];
});

$factory->state(App\User::class, 'responsavel', function (Faker $faker) {
    return[
        'role' => \App\User::ROLE_RESPONSAVEL,
        'role_name' => 'Responsável'
    ];
});

$factory->state(App\User::class, 'atendente', function (Faker $faker) {
    return[
        'role' => \App\User::ROLE_ATENDENTE,
        'role_name' => 'Atendente'
    ];
});


$factory->state(App\User::class, 'suporte', function (Faker $faker) {
    return[
        'role' => \App\User::ROLE_SUPORTE,
        'role_name' => 'Suporte'
    ];
});

$factory->state(App\User::class, 'at_temporario', function (Faker $faker) {
    return[
        'role' => \App\User::ROLE_AT_TEMPORARIO,
        'role_name' => 'At. Temporário'
    ];
});