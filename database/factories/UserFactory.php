<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    $now = Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'avatar' => $faker->imageUrl(),
        'remember_token' => str_random(10),
        'introduction' => $faker->sentence(),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});