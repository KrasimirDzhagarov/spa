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

$factory->define(App\Models\Consumer::class, function (Faker $faker) {

    $cities = ['Sofia' , 'Plovdiv' , 'Varna'];

    return [
        'name' => $faker->name,
        'age' => rand(14,99),
        'city' =>  $cities[mt_rand(0, count($cities) - 1)]
    ];
});
