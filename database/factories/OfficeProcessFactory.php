<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OfficeProcess;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(OfficeProcess::class, function (Faker $faker) {
    return [
        'uuid'=>$faker->uuid,
        'active'=>true,
    ];
});
